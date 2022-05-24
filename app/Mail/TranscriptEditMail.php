<?php

namespace App\Mail;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TranscriptEditMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $transcript;
    protected $transcript_new_array;
    protected $employee;
    protected $transcript_file_uploaded;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($transcript, $transcript_new_array, $employee, $transcript_file_uploaded)
    {
        $this->transcript = $transcript;
        $this->transcript_new_array = $transcript_new_array;
        $this->employee = $employee;
        $this->transcript_file_uploaded = $transcript_file_uploaded;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(Request $request)
    {
        $mailable = $this->subject('DIU Transcript Edit Notification')->view('emails.transcript_edit', [
            'transcript' => $this->transcript,
            'transcript_new_array' => $this->transcript_new_array,
            'employee' => $this->employee,
            'transcript_file_uploaded' => $this->transcript_file_uploaded,
            'ip' => $request->ip(),
        ]);
        return $mailable;
    }
}
