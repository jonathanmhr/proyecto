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
            ->subject(Lang::get('auth.verify_email_subject'))
            ->greeting(Lang::get('auth.greeting', ['name' => $notifiable->name]))
            ->line(Lang::get('auth.line1'))
            ->action(Lang::get('auth.action'), $verificationUrl)
            ->line(Lang::get('auth.line2'))
            ->line(Lang::get('auth.verification_trouble') . ' ' . $verificationUrl);
    }
}

