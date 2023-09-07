<?php

namespace App\Mail;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class StudentSupportPermissionMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;
    public $supportTicket;
    public $employee;

    public function __construct($data, $supportTicket,$employee)
    {
        $this->data = $data;
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
        return $this->subject('Permission For New Modification')->view('emails.studentBotPermission', [
            'botData' => $this->data,
            'supportTicket' => $this->supportTicket,
            'employee' => $this->employee
        ]);
    }
}