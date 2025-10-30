@props(['post'])

<div x-data="{
    showPicker: false,
    reacting: false,
    reactions: {{ Js::from($post->reaction_counts ?? collect()) }},
    total: {{ $post->total_reactions ?? 0 }},
    userReaction: {{ Js::from(optional($post->userReaction())->type) }},
    
    async react(type) {
        if (this.reacting) return;
        
        this.reacting = true;
        this.showPicker = false;
        
        try {
            const response = await fetch('{{ route('reactions.toggle', $post) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ type })
            });
            
            const data = await response.json();
            
            if (data.reactions) {
                this.reactions = data.reactions.counts;
                this.total = data.reactions.total;
                this.userReaction = data.reactions.user_reaction;
            }
        } catch (error) {
            console.error('Reaction error:', error);
            alert('Failed to react. Please try again.');
        } finally {
            this.reacting = false;
        }
    },
    
    getEmoji(type) {
        const emojis = {
            'like': '👍',
            'love': '❤️',
            'care': '🤗',
            'haha': '😂',
            'wow': '😮',
            'sad': '😢',
            'angry': '😠'
        };
        return emojis[type] || '👍';
    }
}" 
class="flex items-center gap-3">
    {{-- Reaction Button --}}
    <div class="relative">
        <button 
            @mouseenter="showPicker = true"
            @mouseleave="setTimeout(() => showPicker = false, 300)"
            @click="userReaction ? react(userReaction) : showPicker = !showPicker"
            :class="userReaction ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400'"
            class="flex items-center gap-2 px-4 py-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200 font-medium text-sm"
            :disabled="reacting">
            <span x-show="!userReaction" class="text-xl">👍</span>
            <span x-show="userReaction" x-text="getEmoji(userReaction)" class="text-xl"></span>
            <span x-text="userReaction ? userReaction.charAt(0).toUpperCase() + userReaction.slice(1) : 'Like'"></span>
        </button>

        {{-- Reaction Picker Popup --}}
        <div 
            x-show="showPicker"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            @mouseenter="showPicker = true"
            @mouseleave="showPicker = false"
            style="display: none;"
            class="absolute bottom-full left-0 mb-2 bg-white dark:bg-gray-800 rounded-full shadow-2xl border border-gray-200 dark:border-gray-700 p-2 flex gap-1 z-50">
            
            @foreach(['like', 'love', 'care', 'haha', 'wow', 'sad', 'angry'] as $type)
                <button 
                    type="button"
                    @click="react('{{ $type }}')"
                    :class="userReaction === '{{ $type }}' ? 'scale-125' : 'hover:scale-150'"
                    class="w-10 h-10 rounded-full flex items-center justify-center text-2xl transition-transform duration-200 hover:bg-gray-100 dark:hover:bg-gray-700"
                    title="{{ ucfirst($type) }}">
                    {{ match($type) {
                        'like' => '👍',
                        'love' => '❤️',
                        'care' => '🤗',
                        'haha' => '😂',
                        'wow' => '😮',
                        'sad' => '😢',
                        'angry' => '😠',
                    } }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Reaction Summary --}}
    @if($post->total_reactions > 0)
        <a href="{{ route('reactions.users', $post) }}" 
            class="flex items-center gap-1 text-sm text-gray-600 dark:text-gray-400 hover:underline">
            <div class="flex -space-x-1">
                @php
                    $topReactions = collect($post->reaction_counts)->sortDesc()->take(3);
                @endphp
                @foreach($topReactions as $type => $count)
                    <span class="text-lg">
                        {{ match($type) {
                            'like' => '👍',
                            'love' => '❤️',
                            'care' => '🤗',
                            'haha' => '😂',
                            'wow' => '😮',
                            'sad' => '😢',
                            'angry' => '😠',
                            default => '👍',
                        } }}
                    </span>
                @endforeach
            </div>
            <span>{{ number_format($post->total_reactions) }}</span>
        </a>
    @endif
</div>