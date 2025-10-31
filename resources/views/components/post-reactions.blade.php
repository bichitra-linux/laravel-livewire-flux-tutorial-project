@props(['post'])

<div x-data="{
    showPicker: false,
    reacting: false,
    pickerLocked: false,
    reactions: {{ Js::from($post->reaction_counts ?? collect()) }},
    total: {{ $post->total_reactions ?? 0 }},
    userReaction: {{ Js::from(optional($post->userReaction())->type) }},
    hasReacted: {{ $post->userReaction() ? 'true' : 'false' }},
    
    async react(type) {
        if (this.reacting) return;
        
        this.reacting = true;
        this.showPicker = false;
        this.pickerLocked = false;
        
        // ✅ ADDED: Check for CSRF token
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
            
            // ✅ ADDED: Better error handling
            if (!response.ok) {
                const errorData = await response.json().catch(() => ({}));
                console.error('Response error:', response.status, errorData);
                throw new Error(errorData.message || `HTTP ${response.status}: ${response.statusText}`);
            }
            
            const data = await response.json();
            console.log('Reaction response:', data);  // ✅ Debug log
            
            if (data.reactions) {
                this.reactions = data.reactions.counts || {};
                this.total = data.reactions.total || 0;
                this.userReaction = data.reactions.user_reaction;
                this.hasReacted = data.reactions.user_reaction !== null;
            }
        } catch (error) {
            console.error('Reaction error:', error);
            alert('Failed to react: ' + error.message);
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
    },
    
    togglePicker() {
        this.pickerLocked = !this.pickerLocked;
        this.showPicker = this.pickerLocked;
    }
}" 
class="flex flex-col gap-4">

    {{-- BEFORE REACTING: Show Reaction Button with Picker --}}
    <div x-show="!hasReacted" class="relative">
        <button 
            @mouseenter="if (!pickerLocked) showPicker = true"
            @mouseleave="if (!pickerLocked) setTimeout(() => { if (!pickerLocked) showPicker = false }, 1000)"
            @click="togglePicker()"
            class="flex items-center gap-2 px-6 py-3 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200 font-medium text-sm border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400"
            :disabled="reacting">
            <span class="text-xl">👍</span>
            <span>Like</span>
            <span x-show="reacting" class="ml-2">
                <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </span>
        </button>

        {{-- Reaction Picker Popup --}}
        <div 
            x-show="showPicker"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95 translate-y-2"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            @mouseenter="showPicker = true; pickerLocked = true"
            @mouseleave="setTimeout(() => { pickerLocked = false; showPicker = false }, 500)"
            @click.away="if (!pickerLocked) { showPicker = false; pickerLocked = false }"
            style="display: none;"
            class="absolute bottom-full left-0 mb-3 bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border-2 border-gray-200 dark:border-gray-600 p-3 flex gap-2 z-50">
            
            @foreach(['like', 'love', 'care', 'haha', 'wow', 'sad', 'angry'] as $type)
                <button 
                    type="button"
                    @click.prevent="react('{{ $type }}')"
                    class="w-12 h-12 rounded-full flex items-center justify-center text-3xl transition-all duration-200 hover:scale-150 hover:bg-gray-100 dark:hover:bg-gray-700"
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

    {{-- AFTER REACTING: Show Reaction Counter with All Types --}}
    <div x-show="hasReacted" x-cloak class="space-y-3">
        {{-- Your Reaction (Highlighted) --}}
        <div class="flex items-center gap-2 px-4 py-2 bg-blue-50 dark:bg-blue-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-full">
            <span class="text-xl" x-text="getEmoji(userReaction)"></span>
            <span class="text-sm font-semibold text-blue-700 dark:text-blue-300">
                You reacted with <span x-text="userReaction" class="capitalize"></span>
            </span>
            <button 
                @click="react(userReaction)"
                class="ml-auto text-xs text-blue-600 dark:text-blue-400 hover:underline"
                :disabled="reacting">
                Remove
            </button>
        </div>

        {{-- All Reactions Counter --}}
        <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-3">
                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Reactions</h4>
                <span class="text-xs text-gray-500 dark:text-gray-400">
                    <span x-text="total"></span> total
                </span>
            </div>

            {{-- Reaction Types Grid --}}
            <div class="grid grid-cols-7 gap-2">
                <template x-for="(count, type) in reactions" :key="type">
                    <button
                        @click="react(type)"
                        :class="type === userReaction ? 'ring-2 ring-blue-500 bg-blue-100 dark:bg-blue-900' : 'hover:bg-gray-200 dark:hover:bg-gray-700'"
                        class="flex flex-col items-center justify-center p-2 rounded-lg transition-all duration-200 group"
                        :title="`React with ${type}`">
                        <span class="text-2xl group-hover:scale-125 transition-transform" x-text="getEmoji(type)"></span>
                        <span class="text-xs font-semibold text-gray-600 dark:text-gray-400 mt-1" x-text="count"></span>
                    </button>
                </template>
            </div>

            <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-600">
                <p class="text-xs text-gray-500 dark:text-gray-400 text-center">
                    Click any reaction to change yours
                </p>
            </div>

            @if($post->total_reactions > 5)
                <a href="{{ route('reactions.users', $post) }}" 
                    class="mt-3 block text-center text-sm text-blue-600 dark:text-blue-400 hover:underline">
                    View all {{ $post->total_reactions }} reactions →
                </a>
            @endif
        </div>

        {{-- Quick Change Picker --}}
        <div class="flex items-center justify-center gap-2">
            @foreach(['like', 'love', 'care', 'haha', 'wow', 'sad', 'angry'] as $type)
                <button 
                    type="button"
                    @click.prevent="react('{{ $type }}')"
                    :class="userReaction === '{{ $type }}' ? 'scale-125 ring-2 ring-blue-500' : 'hover:scale-125 opacity-60 hover:opacity-100'"
                    class="w-10 h-10 rounded-full flex items-center justify-center text-2xl transition-all duration-200"
                    title="Change to {{ ucfirst($type) }}">
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

</div>

<style>
    [x-cloak] { 
        display: none !important; 
    }
</style>