<?php

namespace App\Mail;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApprovalNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userRegistration;

    public function __construct($userRegistration)
    {
        $this->userRegistration = $userRegistration;
    }

    public function build()
    {
        return $this->subject('Your Graveyard Registration Approved')
                    ->view('mails.approvals')
                    ->with([
                        'name' => $this->userRegistration->name,
                        'father_name' => $this->userRegistration->father_name,
                        'id' => $this->userRegistration->id,
                    ]);
    }
}

