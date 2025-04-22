<?php

use Illuminate\Auth\Notifications\ResetPassword;
use App\Notifications\CustomResetPassword;

public function boot()
{
    ResetPassword::toMailUsing(function ($notifiable, $token) {
        return (new CustomResetPassword($token))->toMail($notifiable);
    });
}
