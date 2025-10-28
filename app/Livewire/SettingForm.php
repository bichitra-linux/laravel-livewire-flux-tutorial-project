<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class SettingForm extends Component
{
    public $name;
    public $email;

    public function mount(){
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function save(){
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.Auth::id(),
        ]);
        Auth::user()->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);
        session()->flash('message', 'Settings updated successfully.');
    }
    public function render()
    {
        return view('livewire.setting-form');


    }
}
