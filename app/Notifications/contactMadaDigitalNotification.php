<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class contactMadaDigitalNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $contact = $notifiable->routes['contact'];
        // dd($contact);
        return (new MailMessage)
                    ->subject("[AF-Application] - ". $contact['subject'])
                    ->greeting("Bonjour administrateur !")
                    ->line("Vous avez reçu un message de l'Alliance Française.")
                    ->line("De l'appart de : ". $contact['name'])
                    ->line($contact['message'])
                    ->action('Répondre au message', url('mailto:'. $contact['email']));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
