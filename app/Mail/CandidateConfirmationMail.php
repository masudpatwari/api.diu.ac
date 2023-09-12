<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\URL;

class CandidateConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $candidate;
    public $subject;
    public $link;
//    public $leave;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($candidate)
    {
        $this->candidate = $candidate;

//        $this->leave = $leave;



        $explode_by = '.0.0.0.0.';

        $application_id = $candidate->id;


        $dob = $candidate->dob;


        $info = implode($explode_by, [$application_id, $dob]);


        $token = encrypt($info);


        $this->link = env('APP_URL').'submit-information/'.$token;

        $this->subject = 'Application for the Junior Officer (Admission & Information) position.';

//        $start_date = date('d/m/Y', $leave->start_date);
//        $end_date = date('d/m/Y', $leave->end_date);

        $this->message = "Dear {$candidate->name}";

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(Request $request)
    {
        $mailable = $this->subject($this->subject)->view('emails.mail_candidate_selection_template', [
            'data' => [
                'message' => $this->message,
                'link' => $this->link
//                'auth' => [
//                    'name' => $this->employee->name,
//                    'designation' => $this->employee->relDesignation->name,
//                    'department' => $this->employee->relDepartment->name,
//                    'mobile' => $this->employee->personal_phone_no,
//                ]
            ]
        ]);

        $attachment =  storage_path('images/resumes/'.$this->candidate->id. "_" .$this->candidate->name. '.pdf');
//        dd($attachment);
//        $attachment =  storage_path($this->candidate->resume);


//        dd($attachment, $attachment->getClientMimeType(), $attachment->getClientOriginalName());

        $mailable->attach(
            $attachment
        );

        return $mailable;
    }
}
