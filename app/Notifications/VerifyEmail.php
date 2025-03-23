<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmail extends Notification
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
        // Añade esta línea para verificar si la traducción se carga correctamente
        dd(__('notifications.email.verification.subject'));  // Esto mostrará el valor de la traducción
    
        return (new MailMessage)
            ->subject(__('notifications.email.verification.subject')) // Asunto en español
            ->greeting(__('notifications.email.verification.greeting')) // Saludo en español
            ->line(__('notifications.email.verification.message')) // Mensaje en español
            ->action(__('notifications.email.verification.button'), url(route('verification.verify', ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification())], false)))
            ->line(__('notifications.email.verification.fallback_message')); // Mensaje adicional en español
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
