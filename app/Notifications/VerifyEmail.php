<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class VerifyEmail extends BaseVerifyEmail
{
    /**
     * Build the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject(Lang::get('Verifikasi Alamat Email Anda'))
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line(Lang::get('Silakan klik tombol di bawah ini untuk memverifikasi alamat email Anda.'))
            ->action(Lang::get('Verifikasi Alamat Email'), $verificationUrl)
            ->line(Lang::get('Jika Anda tidak mendaftarkan akun, tidak ada tindakan lebih lanjut yang diperlukan.'));
    }
}
