<?php

namespace App\Http\Controllers\INTL;


use App\Http\Controllers\Controller;
use App\Models\INTL\ForeignStudent;
use Illuminate\Http\Request;
use App\Http\Resources\intl\ForeignStudentResource;
use App\Traits\DocmtgTraits;
use App\Docmtg;

class DocumentsController extends Controller
{

    use DocmtgTraits;


    public $employee_doc = [
        [
            'name' => 'Bonafide Letter',
            'filename' => 'bonafide_letter',
        ],
        [
            'name' => 'Issue A Student VISA',
            'filename' => 'issue_student_visa',
        ],
        [
            'name' => 'Recommendation Letter',
            'filename' => 'recommendation_letter',
        ],
        [
            'name' => 'Sponsorship Certificate',
            'filename' => 'sponsorship_certificate',
        ],
        [
            'name' => 'Studentship Certificate',
            'filename' => 'studentship_certificate',
        ],
        [
            'name' => 'TO WHOM IT MAY CONCERN',
            'filename' => 'to_whom_it_may_concern',
        ],
        [
            'name' => 'NOTE NO',
            'filename' => 'note_no',
        ],
        [
            'name' => 'FOCAL POINT',
            'filename' => 'focal_point',
        ],
        [
            'name' => 'COURSE COMPLETE',
            'filename' => 'course_complete',
        ],
        [
            'name' => 'RE VERIFICATION',
            'filename' => 're_verification',
        ],
        [
            'name' => 'PASSPORT RE ISSUE',
            'filename' => 'passport_re_issue',
        ],
        [
            'name' => 'INFORMATION SHEET FOR THE FOREIGNER STUDENT',
            'filename' => 'information_sheet_for_the_foreigner_student',
        ],
        [
            'name' => 'ADMISSION LETTER',
            'filename' => 'admission_letter',
        ],
        [
            'name' => 'OATH',
            'filename' => 'oath',
        ],
        [
            'name' => 'PAYMENT SCHEDULE',
            'filename' => 'payment_schedule',
        ],
        /*[
            'name' => 'PASSPORT RECEIVING SLIP',
            'filename' => 'passport_receiving_slip',
        ],*/
        [
            'name' => 'EXTEND VISA',
            'filename' => 'extend_visa',
        ],
        [
            'name' => 'FOR ANOTHER UNIVERSITY STUDENT ADMISSION',
            'filename' => 'for_another_university_student_admission',
        ],
        [
            'name' => 'NEXT PAYMENT',
            'filename' => 'next_payment',
        ],
        [
            'name' => 'COURSE COMPLETION',
            'filename' => 'course_completion',
        ],
    ];


    public $doc_info = [

        'bonafide_letter' => [
            'to' => 'to',
            'desent_reference' => 'desent_reference',
            'signatory' => 'sig',
            'subject' => 'sub',
            'description_of_letter' => 'dol',
        ],
        'issue_student_visa' => [
            'to' => 'The Director General',
            'desent_reference' => 'Professor Shah Alam Chowdhury',
            'signatory' => 'Prof. Md. Rofiqul Islam',
            'subject' => 'Recommendation for issuing a Student Visa',
            'description_of_letter' => 'Issue Student Visa of ',
        ],
        'recommendation_letter' => [
            'to' => 'to',
            'desent_reference' => 'desent_reference',
            'signatory' => 'sig',
            'subject' => 'sub',
            'description_of_letter' => 'dol',
        ],
        'sponsorship_certificate' => [
            'to' => 'to',
            'desent_reference' => 'desent_reference',
            'signatory' => 'sig',
            'subject' => 'sub',
            'description_of_letter' => 'dol',
        ],
        'studentship_certificate' => [
            'to' => 'to',
            'desent_reference' => 'desent_reference',
            'signatory' => 'sig',
            'subject' => 'sub',
            'description_of_letter' => 'dol',
        ],
        'to_whom_it_may_concern' => [
            'to' => 'to',
            'desent_reference' => 'desent_reference',
            'signatory' => 'sig',
            'subject' => 'sub',
            'description_of_letter' => 'dol',
        ],
        'note_no' => [
            'to' => '',
            'desent_reference' => '',
            'signatory' => '',
            'subject' => '',
            'description_of_letter' => '',
        ],
        'focal_point' => [
            'to' => '',
            'desent_reference' => '',
            'signatory' => '',
            'subject' => '',
            'description_of_letter' => '',
        ],
        'course_complete' => [
            'to' => '',
            'desent_reference' => '',
            'signatory' => '',
            'subject' => '',
            'description_of_letter' => '',
        ],
        're_verification' => [
            'to' => '',
            'desent_reference' => '',
            'signatory' => '',
            'subject' => '',
            'description_of_letter' => '',
        ],
        'passport_re_issue' => [
            'to' => '',
            'desent_reference' => '',
            'signatory' => '',
            'subject' => '',
            'description_of_letter' => '',
        ],
        'information_sheet_for_the_foreigner_student' => [
            'to' => '',
            'desent_reference' => '',
            'signatory' => '',
            'subject' => '',
            'description_of_letter' => '',
        ],
        'admission_letter' => [
            'to' => '',
            'desent_reference' => '',
            'signatory' => '',
            'subject' => '',
            'description_of_letter' => '',
        ],
        'oath' => [
            'to' => '',
            'desent_reference' => '',
            'signatory' => '',
            'subject' => '',
            'description_of_letter' => '',
        ],
        'payment_schedule' => [
            'to' => '',
            'desent_reference' => '',
            'signatory' => '',
            'subject' => '',
            'description_of_letter' => '',
        ],
        'passport_receiving_slip' => [
            'to' => '',
            'desent_reference' => '',
            'signatory' => '',
            'subject' => '',
            'description_of_letter' => '',
        ],
        'extend_visa' => [
            'to' => '',
            'desent_reference' => '',
            'signatory' => '',
            'subject' => '',
            'description_of_letter' => '',
        ],
        'for_another_university_student_admission' => [
            'to' => '',
            'desent_reference' => '',
            'signatory' => '',
            'subject' => '',
            'description_of_letter' => '',
        ],
        'next_payment' => [
            'to' => '',
            'desent_reference' => '',
            'signatory' => '',
            'subject' => '',
            'description_of_letter' => '',
        ],
        'course_completion' => [
            'to' => '',
            'desent_reference' => '',
            'signatory' => '',
            'subject' => '',
            'description_of_letter' => '',
        ],
    ];

    public function pdfDoc(Request $request, $filename, int $studentRmsId)
    {

        $doc = null;

        $filenames = array_column($this->employee_doc, 'filename');

        if (!in_array($filename, $filenames)) {
            return response()->json(['message' => 'Invalid Filename'], 400);
        }

        $foreign_student = ForeignStudent::with('relUser', 'relReferralBy')
            ->whereStudentId($studentRmsId)
            ->first();

        if (!$foreign_student) {
            return response()->json(['message' => 'Student Not Found'], 400);
        }


        if ($request->has('create_doc') && $request->create_doc == 1) {

            $info = $this->doc_info[$filename];

            $doc = $this->create_doc(
                $info['to'],
                $info['subject'],
                $info['desent_reference'],
                $info['signatory'],
                $info['description_of_letter'] . $foreign_student->relUser->name ?? 'NA',
                $request->auth->id,
                date("Y-m-d")
            );

            $id = $doc->id;


            $code = $id . '/INF/DIU/' . date('m') . '/' . date('Y');

            $doc->doc_mtg_code = $code;
            $doc->save();

        }

//         dd($foreign_student);

        $data['profile'] = $this->resource_employee($foreign_student);

        $data['doc'] = $doc;
        $data['visa_year'] = $request->visa_year;
        $data['sup'] = $this->sup($data['profile']['running_semester']);

        $view = view()->make('foreign_student_docs/' . $filename . '', $data);

        $mpdf = new \Mpdf\Mpdf(['tempDir' => storage_path('temp'), 'mode' => 'utf-8', 'format' => 'A4-P', 'orientation' => 'P','autoScriptToLang'=>true,'autoLangToFont'=>true]);
        $mpdf->SetTitle($filename);
        $mpdf->WriteHTML(file_get_contents(resource_path('views') . '/foreign_student_docs/css/' . $filename . '.css'), 1);
        $mpdf->WriteHTML($view, 2);

        return $mpdf->Output($filename, 'I');
    }

    public function searchStudentByRegcode(Request $request)
    {
        $this->validate($request,
            [
                'reg_no' => 'required|min:5',
            ],
            [
                'reg_no.required' => 'Registration no is required',
                'reg_no.min' => 'Minimum 5 character need for search',
            ]
        );
        $students = ForeignStudent::with('relUser', 'relReferralBy')->where('registration_no', 'like', '%' . $request->reg_no . '%')->get();

        if ($students->count() == 0) {
            return response()->json(['message' => 'No Student Found'], 400);
        }

        return ForeignStudentResource::collection($students);
    }


    public static function ssl()
    {
        return stream_context_create(
            [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ],
            ]);
    }

    public static function src_by_reg($reg_no)
    {
        $decode_values = json_decode(@file_get_contents('' . env('RMS_API_URL') . '/src_by_reg/' . $reg_no . '', false, self::ssl()));
        return collect($decode_values);
    }

    public static function student_by_id($id)
    {
        $decode_values = json_decode(@file_get_contents('' . env('RMS_API_URL') . '/student_by_id/' . $id . '', false, self::ssl()));
        return collect($decode_values);
    }


    public static function department_info($id)
    {
        $department = json_decode(@file_get_contents('' . env('RMS_API_URL') . '/get_deptartment/' . $id . '', false, self::ssl()));
        return collect($department);
    }

    public static function batch_info($id)
    {
        $batch = json_decode(@file_get_contents('' . env('RMS_API_URL') . '/get_batch/' . $id . '/', false, self::ssl()));
        return collect($batch);

    }

    public static function get_student_by_adm_frm_no($adm_frm_no)
    {
        $adm_frm = json_decode(@file_get_contents('' . env('RMS_API_URL') . '/get_student_by_adm_frm_no/' . $adm_frm_no . '/', false, self::ssl()));
        return collect($adm_frm);
    }

    /*
    public function student_documents()
    {
        Cache::forget('document_data');
        $expiresAt = now()->addMinutes(env('CACHETIME',3000));
        $data['documents'] = Documents::documents();
        $foreign_student = ForeignStudent::whereUserId(auth()->user()->id)->with('relUser', 'relReferralBy')->first();
        $data['profile'] = $this->resource_student( $foreign_student );
        Cache::put('document_data', $data, $expiresAt);
        return view('admin.documents.show', $data);
    }
    */

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function resource_employee($foreign_student)
    {
        $rmsStudent = self::student_by_id($foreign_student->student_id);

        $batchInfo = self::batch_info($foreign_student->batch_id);


        $departmentInfo = self::department_info($foreign_student->department_id);

        $session = $rmsStudent['session_name'];
        $no_of_semester = $batchInfo['no_of_semester'];
        $duration_of_sem_month = $batchInfo['duration_of_sem_m'];
        $valid_d_idcard = $batchInfo['valid_d_idcard'];
        $departmentName = $departmentInfo['name'];

        return [
            'id' => $foreign_student->id,
            'name' => $foreign_student->relUser->name,
            'email' => $foreign_student->relUser->email,
            'profile_photo' => $foreign_student->relUser->profile_photo,
            'permanent_address' => $foreign_student->permanent_address,
            'permanent_mobile' => $foreign_student->permanent_mobile,
            'present_address' => $foreign_student->present_address,
            'present_mobile' => $foreign_student->present_mobile,
            'bd_mobile' => $foreign_student->bd_mobile,
            'passport_no' => $foreign_student->passport_no,
            'type_of_passport' => $foreign_student->type_of_passport,
            'place_of_issue' => $foreign_student->place_of_issue,
            'date_of_issue' => ($foreign_student->date_of_issue),
            'date_of_expire' => ($foreign_student->date_of_expire),
            'date_of_last_visit_bd' => ($foreign_student->date_of_last_visit_bd),
            'last_visa_no' => $foreign_student->last_visa_no,
            'visa_date_of_issue' => ($foreign_student->visa_date_of_issue),
            'visa_place_of_issue' => $foreign_student->visa_place_of_issue,
            'nationality' => $foreign_student->present_nationality,
            'father_name' => $foreign_student->father_name,
            'mother_name' => $foreign_student->mother_name,
            'spouse_name' => $foreign_student->spouse_name,
            'country_of_birth' => $foreign_student->country_of_birth,
            'date_of_arrival_bd' => ($foreign_student->date_of_arrival_bd),
            'last_visa_no' => $foreign_student->last_visa_no,
            'visa_category' => $foreign_student->visa_category,
            'dob' => $foreign_student->dob,
            'sex' => $foreign_student->sex,
            'marital_status' => $foreign_student->marital_status,
            'place_of_birth' => $foreign_student->place_of_birth,
            'roll' => $foreign_student->roll,
            'registration_no' => $foreign_student->registration_no,
            'session' => $session,
            'running_semester' => $foreign_student->running_semester,
            'semester' => $foreign_student->semester,
            'subject' => $foreign_student->interested_subject,
            'visa_date_of_expire' => ($foreign_student->visa_date_of_expire),
            'department_name' => $departmentName,
            'program_duration_of_year' => (($no_of_semester * $duration_of_sem_month) / 12),
            'total_semester' => $no_of_semester,
            'idcard_expire' => date('d F Y', strtotime($foreign_student->idcard_expire)),
            'batch_name' => $batchInfo['batch_name'],
            'idcard_validity' => $valid_d_idcard,
            'created_at' => date('d F Y', strtotime($foreign_student->created_at)),
            'reference_name' => $foreign_student->reference_name,
            'reference_address' => $foreign_student->reference_address,
            'reference_contact_no' => $foreign_student->reference_contact_no,
            'reference_facebook' => $foreign_student->reference_facebook,
            'reference_email' => $foreign_student->reference_email,
            'reference_relation' => $foreign_student->reference_relation,
            'signature' => [
                'name' => 'Professor Shah Alam Chowdhury',
                'position' => 'Additional Registrar',
                'uni' => 'Dhaka International University',
                'email' => [
                    'dhakaintluniversity@gmail.com',
                    'admission@diu.net.bd',
                ],
                'cell' => '+8801939851061',
            ],

            'registrar' => [
                'name' => 'Prof. Md. Rofiqul Islam',
                'position' => 'Registrar',
                'uni' => 'Dhaka International University',
            ],

            'signature_focal_point' => [
                'name' => 'Kamal Sarker (Focal Point)',
                'position' => 'Assistant Registrar',
                'uni' => 'Dhaka International University',
                'email' => 'dhakaintluniversity@gmail.com',
                'cell' => '+8801611348346',
            ]
        ];
    }
    /*
    public function resource_student( $resource )
    {
        return [
            'id' => $resource->id,
            'name' => $resource->relUser->name,
            'email' => $resource->relUser->email,
            'profile_photo' => $resource->relUser->profile_photo,
            'permanent_address' => $resource->permanent_address,
            'permanent_mobile' => $resource->permanent_mobile,
            'present_address' => $resource->present_address,
            'present_mobile' => $resource->present_mobile,
            'bd_mobile' => $resource->bd_mobile,
            'passport_no' => $resource->passport_no,
            'type_of_passport' => $resource->type_of_passport,
            'place_of_issue' => $resource->place_of_issue,
            'date_of_issue' => db2d($resource->date_of_issue),
            'date_of_expire' => db2d($resource->date_of_expire),
            'date_of_last_visit_bd' => db2d($resource->date_of_last_visit_bd),
            'last_visa_no' => $resource->last_visa_no,
            'visa_date_of_issue' => db2d($resource->visa_date_of_issue),
            'visa_place_of_issue' => $resource->visa_place_of_issue,
            'nationality' => $resource->present_nationality,
            'father_name' => $resource->father_name,
            'mother_name' => $resource->mother_name,
            'spouse_name' => $resource->spouse_name,
            'country_of_birth' => $resource->country_of_birth,
            'date_of_arrival_bd' => db2d($resource->date_of_arrival_bd),
            'last_visa_no' => $resource->last_visa_no,
            'visa_category' => $resource->visa_category,
            'dob' => $resource->dob,
            'sex' => $resource->sex,
            'marital_status' => $resource->marital_status,
            'place_of_birth' => $resource->place_of_birth,
            'roll' => $resource->roll,
            'registration_no' => $resource->registration_no,
            'session' => $resource->session,
            'running_semester' => $resource->running_semester,
            'semester' => $resource->semester,
            'subject' => $resource->interested_subject,
            'visa_date_of_expire' => db2d($resource->visa_date_of_expire),
            'department_name' => $resource->interested_subject,
            'idcard_expire' => date('d F Y', strtotime($resource->idcard_expire)),
            'signature' => [
                'name' => 'Associate Professor Shah Alam Chowdhury',
                'position' => 'Additional Registrar',
                'uni' => 'Dhaka International University',
                'email' => [
                    'dhakaintluniversity@gmail.com',
                    'shahjabeen2010@gmail.com',
                ],
                'cell' => '+8801716559369',
            ],
            'registrar' => [
                'name' => 'Prof. Md. Rofiqul Islam',
                'position' => 'Registrar',
                'uni' => 'Dhaka International University',
            ]
        ];
    }
    */
    /**
     * Display the doclist with a student info
     *
     * @param int $id
     */
    public function docNameList()
    {
        return $this->employee_doc;
    }


    function sup($semester)
    {
    	if ( $semester == '' ) {
    		return '--';
    	}

        $a = [1 => 'st', 2 => 'nd', 3 => 'rd'];
        if ($semester < 4) {
            return $a[$semester];
        }
        return 'th';
    }
}
