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
        // Genera la URL de reseteo
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject(Lang::get('auth.password_reset_subject')) // auth.php
            ->line(Lang::get('auth.password_reset_line1'))
            ->action(Lang::get('auth.password_reset_action'), $url)
            ->line(Lang::get('auth.password_reset_line2'));
    }
}
