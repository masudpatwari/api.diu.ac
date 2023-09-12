<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\URL;

class InterviewConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $candidate;
    public $subject;
//    public $message;
//    public $leave;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($candidate)
    {
        $this->candidate = $candidate;

        $this->subject = 'Confirmation Letter of Test & Interview';

        $this->message = "Dear {$candidate->name}";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(Request $request)
    {
        $mailable = $this->subject($this->subject)->view('emails.interview_confirmation_mail_template', [
            'data' => [
                'message' => $this->message,
            ]
        ]);

        return $mailable;
    }
}
