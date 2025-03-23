<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class CustomVerifyEmail extends BaseVerifyEmail
{
    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject(Lang::get('Verifica tu cuenta en MiGimnasio'))
            ->greeting(Lang::get('¡Hola :name!', ['name' => $notifiable->name]))
            ->line(Lang::get('Gracias por registrarte en MiGimnasio. Para continuar, verifica tu dirección de correo haciendo clic en el botón de abajo.'))
            ->action(Lang::get('Verificar Correo'), $verificationUrl)
            ->line(Lang::get('Si no creaste una cuenta, no necesitas hacer nada.'))
            ->salutation(Lang::get('Saludos, El equipo de MiGimnasio'));
    }
}
