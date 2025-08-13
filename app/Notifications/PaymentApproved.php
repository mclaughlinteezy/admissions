<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Payment;

class PaymentApproved extends Notification implements ShouldQueue
{
    use Queueable;

    public $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // Send both email and in-app notification
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Payment Approved & Application Submitted')
            ->line('Your payment has been approved successfully.')
            ->line('Your application has now been automatically submitted.')
            ->action('View Application', url('/student/dashboard'));
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Your payment with reference ' . $this->payment->reference . ' has been approved.',
            'payment_id' => $this->payment->id,
            'amount' => $this->payment->amount,
        ];
    }
}
