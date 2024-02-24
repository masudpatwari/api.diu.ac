<?php

namespace App\Mail;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\URL;

class EmployeeConfirmMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $employee;
    public $subject;
    public $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($employee, $leave)
    {
        $this->employee = $employee;

        $this->subject = 'Please confirm responsibility on behalf of that '.$employee->name;

        $explode_by = '.0.0.0.0.';

        $application_id = $leave->id;
        $timeout = strtotime(($leave->created_at)->addDays(7));
        $user_id = $leave->alt_employee;

        $info = implode($explode_by, [$application_id, $timeout, $user_id]);

        $token = encrypt($info);

        $this->message = env('APP_URL').'confirm-mail/'.$token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(Request $request)
    {
        $mailable = $this->subject($this->subject)->view('emails.mail_confirmation_template', [
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
