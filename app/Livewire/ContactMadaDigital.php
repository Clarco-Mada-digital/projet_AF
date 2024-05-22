<?php

namespace App\Livewire;

use App\Notifications\contactMadaDigitalNotification;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\Layout;
use Livewire\Component;


#[Layout('layouts.mainLayout')]
class ContactMadaDigital extends Component
{
    public $contact = ['name' => '', 'email'=>'','subject'=>'','message'=>''];

    protected function rules()
    {
        $rule = [
            'contact.name' => ['required'],
            'contact.email' => ['required'],
            'contact.subject' => ['required'],
            'contact.message' => ['required'],
        ];

        return $rule;
    }

    public function submitContact()
    {
        $email = "clarco.dev@mada-digital.net";
        
        $this->validate();

        Notification::route('mail', $email)
                    ->route('contact', $this->contact)
                    ->notify(new contactMadaDigitalNotification());

        $this->contact = ['name' => '', 'email'=>'','subject'=>'','message'=>''];
        $this->dispatch("ShowSuccessMsg", ['message' => 'Message envoyer avec success !', 'type' => 'success']);

    }

    public function render()
    {
        // $this->submitContact();
        return view('pages.mada-contact');
    }
}
