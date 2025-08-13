<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PaymentRejected extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public $payment) {}

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Payment Rejected')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your application payment has been rejected.')
            ->line('Reference: ' . $this->payment->payment_reference)
            ->line('Please review and re-submit a valid payment proof.')
            ->action('Login to Your Account', url('/student/dashboard'))
            ->line('Thank you for applying!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Your payment (Ref: ' . $this->payment->payment_reference . ') was rejected.',
            'payment_id' => $this->payment->id,
        ];
    }
}
