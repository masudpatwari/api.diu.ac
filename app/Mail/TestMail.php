<?php

namespace App\Mail;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $employee;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($employee)
    {
        $this->employee = $employee;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(Request $request)
    {
        $mailable = $this->subject($request->subject)->view('emails.mail_template', [
            'data' => [
                'message' => $request->message,
                'auth' => [
                    'name' => $this->employee->name,
                    'designation' => $this->employee->relDesignation->name,
                    'department' => $this->employee->relDepartment->name,
                    'mobile' => $this->employee->personal_phone_no,
                ]
            ]
        ]);
        if($request->hasFile('attechment_file'))
        {
            $attachments = $request->file('attechment_file');
            foreach ($attachments as $attachment)
            {
                $mailable->attach(
                    $attachment->getRealPath(),
                    [
                        'mime' => $attachment->getClientMimeType(),
                        'as' => $attachment->getClientOriginalName()
                    ]
                );
            }
        }
        return $mailable;
    }
}
