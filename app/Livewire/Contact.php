<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class Contact extends Component
{

    public $name = '';
    public $email = '';
    public $message = '';
    public $successMessage = '';
    public $errorMessage = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'subject' => 'required|string|max:255',
        'message' => 'required|string|max:2000',
    ];

    protected $messages = [
        'name.required' => 'Please enter your name.',
        'email.required' => 'Please enter your email address.',
        'email.email' => 'Please enter a valid email address.',
        'subject.required' => 'Please enter the subject.',
        'message.required' => 'Please enter your message.',
    ];

    public function submit(){
        $validated = $this->validate();

        try{
            Mail::to(config('mail.from.addess'))->send(new ContactMail($validated));
            $this->successMessage = "Your message has been sent successfully!";
            $this->errorMessage = '';
            $this->reset(['name', 'email', 'subject', 'message']);
        } catch (\Exception $e){
            $this->errorMessage = "There was an error sending your message. Please try again later.";
            $this->successMessage = '';
        }
    }
    public function render()
    {
        return view('livewire.contact');
    }
}
