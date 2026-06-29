<?php

namespace App\Mail;

use App\Models\MarbleBooking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MarbleBookingStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public MarbleBooking $booking;

    public function __construct(MarbleBooking $booking)
    {
        $this->booking = $booking;
    }

    public function build()
    {
        return $this->subject('Marble Service Booking Status Update')
                    ->view('mails.marble_booking_status');
    }
}