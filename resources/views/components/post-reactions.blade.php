@props(['post', 'compact' => false])

@php
    $reactions = $post->reaction_counts ?? collect();
    $total = $post->total_reactions ?? 0;
    $userReaction = auth()->check() ? $post->userReaction(auth()->id()) : null;
    $hasReacted = $userReaction !== null;
    
    $reactionTypes = [
        'like' => ['emoji' => '👍', 'label' => 'Like', 'color' => 'blue'],
        'love' => ['emoji' => '❤️', 'label' => 'Love', 'color' => 'red'],
        'care' => ['emoji' => '🤗', 'label' => 'Care', 'color' => 'yellow'],
        'haha' => ['emoji' => '😂', 'label' => 'Haha', 'color' => 'yellow'],
        'wow' => ['emoji' => '😮', 'label' => 'Wow', 'color' => 'purple'],
        'sad' => ['emoji' => '😢', 'label' => 'Sad', 'color' => 'gray'],
        'angry' => ['emoji' => '😠', 'label' => 'Angry', 'color' => 'orange'],
    ];
@endphp

<div x-data="{
    showPicker: false,
    reacting: false,
    reactions: {{ Js::from($reactions) }},
    total: {{ $total }},
    userReaction: {{ Js::from($userReaction?->type?->value) }},
    hasReacted: {{ $hasReacted ? 'true' : 'false' }},
    
    async react(type) {
        if (this.reacting) return;
        
        this.reacting = true;
        this.showPicker = false;
        
        const csrfToken = document.querySelector('meta[name=csrf-token]');
        if (!csrfToken) {
            console.error('CSRF token not found');
            alert('Security token missing. Please refresh the page.');
            this.reacting = false;
            return;
        }
        
        try {
            const response = await fetch('{{ route('reactions.toggle', $post) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken.content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ type })
            });
            
            if (!response.ok) {
                const errorData = await response.json().catch(() => ({}));
                throw new Error(errorData.message || `HTTP ${response.status}`);
            }
            
            const data = await response.json();
            
            if (data.reactions) {
                this.reactions = data.reactions.counts || {};
                this.total = data.reactions.total || 0;
                this.userReaction = data.reactions.user_reaction;
                this.hasReacted = data.reactions.user_reaction !== null;
            }
            
            // Show success toast
            this.$dispatch('toast', {
                message: data.message || 'Reaction updated!',
                type: 'success'
            });
            
        } catch (error) {
            console.error('Reaction error:', error);
            this.$dispatch('toast', {
                message: 'Failed to react: ' + error.message,
                type: 'error'
            });
        } finally {
            this.reacting = false;
        }
    },
    
    getEmoji(type) {
        const emojis = {
            'like': '👍', 'love': '❤️', 'care': '🤗',
            'haha': '😂', 'wow': '😮', 'sad': '😢', 'angry': '😠'
        };
        return emojis[type] || '👍';
    },
    
    getColor(type) {
        const colors = {
            'like': 'blue', 'love': 'red', 'care': 'yellow',
            'haha': 'yellow', 'wow': 'purple', 'sad': 'gray', 'angry': 'orange'
        };
        return colors[type] || 'blue';
    }
}" 
class="reaction-container">

    @if($compact)
        {{-- COMPACT VIEW: Just show counts (for listing pages) --}}
        <div class="flex items-center gap-3">
            @if($total > 0)
                <div class="flex items-center gap-2">
                    {{-- Top 3 reaction emojis --}}
                    <div class="flex -space-x-1">
                        @foreach(collect($reactions)->sortDesc()->take(3) as $type => $count)
                            <div class="w-7 h-7 rounded-full bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 flex items-center justify-center text-base shadow-sm"
                                title="{{ ucfirst($type) }}: {{ $count }}">
                                {{ $reactionTypes[$type]['emoji'] ?? '👍' }}
                            </div>
                        @endforeach
                    </div>
                    
                    {{-- Count --}}
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ $total }}
                    </span>
                </div>
            @else
                <span class="text-sm text-gray-500 dark:text-gray-400">No reactions yet</span>
            @endif
        </div>
    @else
        {{-- FULL INTERACTIVE VIEW: For post detail page --}}
        <div class="bg-linear-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 shadow-lg">
            
            {{-- Header --}}
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-pink-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                    </svg>
                    Reactions
                </h3>
                <span class="text-sm font-semibold text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-700 px-3 py-1 rounded-full">
                    <span x-text="total"></span> total
                </span>
            </div>

            {{-- User's Current Reaction (if any) --}}
            <div x-show="hasReacted" x-cloak x-transition class="mb-4 p-3 bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 rounded-lg">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="text-2xl" x-text="getEmoji(userReaction)"></span>
                        <span class="text-sm font-semibold text-blue-700 dark:text-blue-300">
                            You reacted with <span x-text="userReaction" class="capitalize"></span>
                        </span>
                    </div>
                    <button 
                        @click="react(userReaction)"
                        class="text-xs text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200 font-medium underline"
                        :disabled="reacting">
                        Remove
                    </button>
                </div>
            </div>

            {{-- Reaction Picker Buttons --}}
            <div class="grid grid-cols-7 gap-2 mb-4">
                @foreach($reactionTypes as $type => $data)
                    <button
                        @click="react('{{ $type }}')"
                        :class="{
                            'ring-4 ring-{{ $data['color'] }}-500 ring-opacity-50 scale-110': userReaction === '{{ $type }}',
                            'hover:scale-110 hover:bg-{{ $data['color'] }}-50 dark:hover:bg-{{ $data['color'] }}-900/20': userReaction !== '{{ $type }}'
                        }"
                        :disabled="reacting"
                        class="group relative flex flex-col items-center justify-center p-3 rounded-xl bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 transition-all duration-200 hover:shadow-lg hover:-translate-y-1"
                        title="{{ $data['label'] }}">
                        
                        {{-- Emoji --}}
                        <span class="text-3xl group-hover:scale-125 transition-transform duration-200">
                            {{ $data['emoji'] }}
                        </span>
                        
                        {{-- Count Badge --}}
                        <span 
                            x-show="reactions['{{ $type }}'] > 0"
                            x-text="reactions['{{ $type }}']"
                            class="absolute -top-1 -right-1 bg-{{ $data['color'] }}-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center shadow-md">
                        </span>
                        
                        {{-- Label --}}
                        <span class="text-xs font-medium text-gray-600 dark:text-gray-400 mt-1">
                            {{ $data['label'] }}
                        </span>
                    </button>
                @endforeach
            </div>

            {{-- Reaction Breakdown (if reactions exist) --}}
            <div x-show="total > 0" x-cloak class="space-y-2">
                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                    <h4 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2">Breakdown</h4>
                    <template x-for="(count, type) in reactions" :key="type">
                        <div x-show="count > 0" class="flex items-center justify-between py-2 px-3 rounded-lg bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                            <div class="flex items-center gap-2">
                                <span class="text-xl" x-text="getEmoji(type)"></span>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300 capitalize" x-text="type"></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-bold text-gray-900 dark:text-white" x-text="count"></span>
                                <div class="w-16 bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                    <div 
                                        :class="'bg-' + getColor(type) + '-500'"
                                        class="h-2 rounded-full transition-all duration-500"
                                        :style="'width: ' + Math.round((count / total) * 100) + '%'">
                                    </div>
                                </div>
                                <span class="text-xs text-gray-500 dark:text-gray-400" x-text="Math.round((count / total) * 100) + '%'"></span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Loading State --}}
            <div x-show="reacting" x-cloak class="absolute inset-0 bg-white/80 dark:bg-gray-900/80 rounded-2xl flex items-center justify-center">
                <div class="flex flex-col items-center gap-2">
                    <svg class="animate-spin h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Processing...</span>
                </div>
            </div>

            {{-- View All Reactions Link --}}
            @if($total > 10)
                <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('reactions.users', $post) }}" 
                        class="block text-center text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200 hover:underline">
                        View all {{ $total }} reactions →
                    </a>
                </div>
            @endif
        </div>
    @endif

</div>

<style>
    [x-cloak] { display: none !important; }
</style>