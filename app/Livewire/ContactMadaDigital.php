<?php

namespace App\Livewire;

use App\Notifications\contactMadaDigitalNotification;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\Layout;
use Livewire\Component;


#[Layout('layouts.mainLayout')]
class ContactMadaDigital extends Component
{
    public $contact;

    public function submitContact()
    {
        $email = "clarco.dev@mada-digital.net";

        Notification::route('mail', $email)
                    ->route('contact', $this->contact)
                    ->notify(new contactMadaDigitalNotification());

        $this->contact = [];
        $this->dispatch("ShowSuccessMsg", ['message' => 'Message envoyer avec success !', 'type' => 'success']);

    }

    public function render()
    {
        return view('pages.mada-contact');
    }
}
