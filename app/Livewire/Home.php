<?php

namespace App\Livewire;

use Livewire\Component;

class Home extends Component
{

    public $message = "Home page with Livewire Components";
    public $count = 0;

    public function increment(){
        $this->count++;
    }
    public function render()
    {
        return view('livewire.home');
    }
}
