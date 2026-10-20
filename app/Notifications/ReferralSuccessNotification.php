<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReferralSuccessNotification extends Notification
{
    use Queueable;

    protected $referralPayment;

    /**
     * Create a new notification instance.
     */
    public function __construct($referralPayment)
    {
        $this->referralPayment = $referralPayment;
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
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pemberitahuan: Klaim Referral BAKUMDA Disetujui')
            ->greeting('Halo, ' . $notifiable->name)
            ->line('Kami informasikan bahwa klaim reward referral Anda telah disetujui.')
            ->line('Jumlah Komisi: Rp ' . number_format($this->referralPayment->amount, 0, ',', '.'))
            // ->action('Cek Dashboard Referral', route('user-referral.index'))
            ->line('Terima kasih atas kontribusi Anda bersama BAKUMDA!')
            ->salutation('Salam hormat, Tim BAKUMDA');
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
