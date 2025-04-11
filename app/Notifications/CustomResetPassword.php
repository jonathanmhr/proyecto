<?php
namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as BaseResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class CustomResetPassword extends BaseResetPassword
{
    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $url = $this->resetUrl($notifiable);

        return (new MailMessage)
            ->subject(Lang::get('auth.password_reset_subject')) // Asegúrate de que esta clave esté en el archivo de traducción
            ->line(Lang::get('auth.password_reset_line1'))
            ->action(Lang::get('auth.password_reset_action'), $url)
            ->line(Lang::get('auth.password_reset_line2'));
    }
}
