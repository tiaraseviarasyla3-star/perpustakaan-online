<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewLoanNotification extends Notification
{
     use Queueable;

    protected $loan;

    public function __construct($loan)
    {
        $this->loan = $loan;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
{
    return [
        'loan_id' => $this->loan->id,
        'user' => $this->loan->user->name,
        'book' => $this->loan->book->title,
        'message' => 'Pengajuan pinjaman baru',
    ];
}
}
