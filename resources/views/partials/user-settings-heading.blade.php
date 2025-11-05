<div class="relative mb-6 w-full">
    <div class="flex items-center justify-between mb-4">
        <div>
            <flux:heading size="xl" level="1">{{ __('Account Settings') }}</flux:heading>
            <flux:subheading size="lg" class="mb-6">{{ __('Manage your account preferences') }}</flux:subheading>
        </div>
        <a href="{{ route('home') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline" wire:navigate>
            ← Back to Home
        </a>
    </div>
    <flux:separator variant="subtle" />
</div>