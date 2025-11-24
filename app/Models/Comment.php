<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'content',
        'parent_id',
        'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    protected $with = ['user'];

    //   AUTO-SANITIZE ON SAVE
    protected static function booted()
    {
        // Sanitize content before saving
        static::saving(function ($comment) {
            if ($comment->isDirty('content')) {
                $comment->content = self::sanitizeContent($comment->content);
            }
        });

        // Enforce reply depth limit
        static::creating(function ($comment) {
            if ($comment->parent_id) {
                $depth = 0;
                $parent = Comment::find($comment->parent_id);

                while ($parent && $parent->parent_id) {
                    $depth++;
                    if ($depth >= 2) { // Max 3 levels (0, 1, 2)
                        throw new \Exception('Maximum reply depth (3 levels) exceeded.');
                    }
                    $parent = $parent->parent;
                }
            }
        });
    }

    /**
     * Sanitize HTML content - allows safe tags only
     */
    private static function sanitizeContent(string $content): string
    {
        // STEP 1: Remove dangerous tags AND their content
        $dangerousTags = [
            'script',
            'iframe',
            'object',
            'embed',
            'applet',
            'meta',
            'link',
            'style',
            'form',
            'input',
            'button',
            'svg',
            'math',
            'base',
            'noscript'
        ];

        foreach ($dangerousTags as $tag) {
            // Remove opening and closing tags with ALL content between them
            $content = preg_replace(
                '/<' . $tag . '(?:\s[^>]*)?>.*?<\/' . $tag . '>/is',
                '',
                $content
            );
            // Also remove self-closing tags
            $content = preg_replace('/<' . $tag . '(?:\s[^>]*)?\/?>/is', '', $content);
        }

        // STEP 2: Remove ALL event handlers BEFORE processing other attributes
        $content = preg_replace('/ on\w+\s*=\s*["\'][^"\']*["\']/i', '', $content);
        $content = preg_replace('/ on\w+\s*=\s*[^\s>]*/i', '', $content);

        // STEP 3: Remove dangerous self-closing tags (img, input, etc.) but preserve text after them
        $dangerousSelfClosing = ['img', 'input', 'embed', 'object'];
        foreach ($dangerousSelfClosing as $tag) {
            $content = preg_replace('/<' . $tag . '(?:\s[^>]*)?\/?>/is', '', $content);
        }

        // STEP 4: Clean up <a> tags - only allow safe href and title
        $content = preg_replace_callback(
            '/<a\s+([^>]*)>(.*?)<\/a>/is',
            function ($matches) {
                $attrs = $matches[1];
                $linkText = $matches[2];
                $href = '';
                $title = '';

                // Extract href
                if (preg_match('/href\s*=\s*["\']([^"\']*)["\']/', $attrs, $hrefMatch)) {
                    $url = trim($hrefMatch[1]);

                    // Block ALL dangerous protocols
                    $dangerousProtocols = [
                        'javascript:',
                        'data:',
                        'vbscript:',
                        'file:',
                        'about:',
                        'blob:',
                        'tel:',
                        'sms:'
                    ];

                    $urlLower = strtolower($url);
                    $isDangerous = false;

                    foreach ($dangerousProtocols as $protocol) {
                        if (strpos($urlLower, $protocol) === 0) {
                            $isDangerous = true;
                            break;
                        }
                    }

                    // Only allow http, https, mailto, or relative URLs
                    if (
                        !$isDangerous && (
                            strpos($urlLower, 'http://') === 0 ||
                            strpos($urlLower, 'https://') === 0 ||
                            strpos($urlLower, 'mailto:') === 0 ||
                            strpos($url, '/') === 0 ||
                            strpos($url, '#') === 0
                        )
                    ) {
                        $href = $url;
                    }
                }

                // Extract title
                if (preg_match('/title\s*=\s*["\']([^"\']*)["\']/', $attrs, $titleMatch)) {
                    $title = htmlspecialchars($titleMatch[1], ENT_QUOTES, 'UTF-8');
                }

                // Reconstruct safe link
                if ($href) {
                    $safe = '<a href="' . htmlspecialchars($href, ENT_QUOTES, 'UTF-8') . '"';
                    if ($title) {
                        $safe .= ' title="' . $title . '"';
                    }
                    // Only add target="_blank" for external links
                    if (strpos($href, 'http') === 0) {
                        $safe .= ' target="_blank" rel="noopener noreferrer"';
                    }
                    $safe .= '>' . $linkText . '</a>';
                    return $safe;
                }

                // If no valid href, return just the text (remove link tags)
                return $linkText;
            },
            $content
        );

        // STEP 5: Strip all tags except allowed ones
        $allowedTags = '<p><br><strong><b><em><i><u><a><ul><ol><li><blockquote><code><pre>';
        $content = strip_tags($content, $allowedTags);

        // STEP 6: Remove any remaining dangerous attributes
        $content = preg_replace('/ style\s*=\s*["\'][^"\']*["\']/i', '', $content);
        $content = preg_replace('/ class\s*=\s*["\'][^"\']*["\']/i', '', $content);
        $content = preg_replace('/ id\s*=\s*["\'][^"\']*["\']/i', '', $content);
        $content = preg_replace('/ data-\w+\s*=\s*["\'][^"\']*["\']/i', '', $content);

        //   STEP 7 REMOVED - No longer needed, Step 4 handles all <a> tags properly

        return trim($content);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')
            ->approved()
            ->with('user')
            ->orderBy('created_at', 'asc');
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeParentOnly($query)
    {
        return $query->whereNull('parent_id');
    }

    public function isReply()
    {
        return !is_null($this->parent_id);
    }

    public function canEdit($user = null)
    {
        $user = $user ?? Auth::user();

        if (!$user) {
            return false;
        }

        // Admins/editors can always edit
        if ($user->hasRole(['admin', 'editor'])) {
            return true;
        }

        // Users can edit their own comments within 15 minutes
        if ($user->id === $this->user_id) {
            return $this->created_at->diffInMinutes(now()) <= 15;
        }

        return false;
    }

    public function canDelete($user = null)
    {
        $user = $user ?? Auth::user();
        return $user && ($user->id === $this->user_id || $user->hasRole(['admin', 'editor']));
    }

    public function getExcerpt($limit = 100)
    {
        // Strip HTML for excerpt
        return Str::limit(strip_tags($this->content), $limit);
    }

    //   Already sanitized on save, just return it
    public function getSafeContentAttribute()
    {
        return $this->content;
    }

    //   Get plain text version
    public function getPlainTextAttribute()
    {
        return strip_tags($this->content);
    }

    //   Check if editable
    public function isEditable(): bool
    {
        return $this->created_at->diffInMinutes(now()) <= 15;
    }

    //   Get reply depth
    public function getDepth(): int
    {
        $depth = 0;
        $parent = $this->parent;

        while ($parent && $parent->parent_id) {
            $depth++;
            $parent = $parent->parent;

            // Safety limit
            if ($depth > 10) {
                break;
            }
        }

        return $depth;
    }
}