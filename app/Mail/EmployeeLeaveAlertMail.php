<?php

namespace App\Mail;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\URL;

class EmployeeLeaveAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $employee;
    public $subject;
    public $message;
    public $leave;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($employee, $leave, $alt_employee)
    {
        $this->employee = $employee;

        $this->leave = $leave;

        $this->subject = 'Employee on leave '.$employee->name;

        $start_date = date('d/m/Y', $leave->start_date);
        $end_date = date('d/m/Y', $leave->end_date);

        $this->message = "{$employee->name} is on leave from {$start_date} to {$end_date}. During this time, his/her duty will be assisted by {$alt_employee->name}.";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(Request $request)
    {
        $mailable = $this->subject($this->subject)->view('emails.mail_message_template', [
            'data' => [
                'message' => $this->message,
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
