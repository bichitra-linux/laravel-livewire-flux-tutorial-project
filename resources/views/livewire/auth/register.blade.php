<x-layouts.auth>
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6">
            @csrf
            <!-- Name -->
            <flux:input
                name="name"
                :label="__('Name')"
                type="text"
                required
                autofocus
                autocomplete="name"
                :placeholder="__('Full name')"
            />

            <!-- Email Address -->
            <flux:input
                name="email"
                :label="__('Email address')"
                type="email"
                required
                autocomplete="email"
                placeholder="email@example.com"
            />

            <!-- Password -->
            <flux:input
                name="password"
                :label="__('Password')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Password')"
                viewable
            />

            <!-- Confirm Password -->
            <flux:input
                name="password_confirmation"
                :label="__('Confirm password')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Confirm password')"
                viewable
            />

            <div class="flex items-start gap-2">
                <input 
                    type="checkbox" 
                    name="terms" 
                    id="terms" 
                    required
                    class="mt-1 h-4 w-4 rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500 dark:bg-gray-700"
                >
                <label for="terms" class="text-sm text-gray-600 dark:text-gray-400">
                    I agree to the 
                    <a href="{{ route('terms') }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline">
                        Terms of Service
                    </a>
                    and 
                    <a href="{{ route('privacy') }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline">
                        Privacy Policy
                    </a>
                    <span class="text-red-500">*</span>
                </label>
            </div>
            @error('terms')
                <p class="text-red-500 text-xs -mt-4">{{ $message }}</p>
            @enderror

            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary" class="w-full" data-test="register-user-button">
                    {{ __('Create account') }}
                </flux:button>
            </div>
        </form>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            <span>{{ __('Already have an account?') }}</span>
            <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
        </div>
    </div>
</x-layouts.auth>
