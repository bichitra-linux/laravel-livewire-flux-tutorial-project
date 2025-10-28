<div>
    <form wire;submit.prevent="save">
        @csrf
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" wire:model="name" required>
            @error('name')<span>{{ $message }}</span> @enderror
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" wire:model="email" required>
            @error('email')<span>{{ $message }}</span> @enderror
        </div>
        <button type="submit">Save</button>
    </form>

    @if (session()->has('message'))
    <div>{{ session('message') }}</div>
    @endif
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
</div>
