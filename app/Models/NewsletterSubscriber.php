<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;

class NewsletterSubscriber extends Model
{
    //
    use HasFactory, Notifiable;

    protected $fillable =[
        'email',
        'name',
        'ip_address',
        'user_agent',
        'token',
        'is_subscribed',
        'subscribed_at',
        'unsubscribed_at',
    ];

    protected $casts = [
        'is_subscribed' => 'boolean',
        'subscribed_at' => 'datetime',
        'unsubscribed_at' => 'datetime',
    ];

    protected static function boot(){
        parent::boot();

        static::creating(function ($subscriber){
            if (empty($subscriber->token)){
                $subscriber->token = Str::random(32);
            }
            if (empty($subscriber->subscribed_at) && $subscriber->is_subscribed){
                $subscriber->subscribed_at = now();
            }
        });
    }

    public function scopeActive($query){
        return $query->where('is_subscribed', true);
    }

    public function subscribe(){
        $this->update([
            'is_subscribed' => true,
            'subscribed_at' => now(),
            'unsubscribed_at' => null,
        ]);
    }

    public function unsubscribe(){
        $this->update([
            'is_subscribed' => false,
            'unsubscribed_at' => now(),
        ]);
    }

    public function routeNotificationForMail(){
        return $this->email;
    }
}
