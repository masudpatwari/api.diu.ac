<?php

namespace App\Mail;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserSupportTicketNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $supportTicket;
    public $employee;

    public function __construct($supportTicket, $employee)
    {
        $this->supportTicket = $supportTicket;
        $this->employee = $employee;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('IT Support Ticket Reply')->view('emails.supportTicketEmployee', [
            'supportTicket' => $this->supportTicket,
            'employee' => $this->employee
        ]);
    }
}