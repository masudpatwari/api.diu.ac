<?php

namespace App\Http\Controllers\INTL;

use App\Http\Controllers\Controller;
use App\Models\INTL\ForeignStudent;
use Illuminate\Http\Request;
use App\Rules\CheckValidPhoneNumber;
use App\Traits\RmsApiTraits;
use App\Models\INTL\StudentMedia;
use App\Http\Resources\intl\ForeignStudentDocResource;

class IntlStudentsController extends Controller
{
    use RmsApiTraits;


    public function index()
    {
        return  ForeignStudent::attendanceReport();
    }

    public function studnetInfoDetail($userId){
        return  ForeignStudent::show( $userId );    
    }

    public function upcomingStudentListAll()
    {
        return ForeignStudent::upcomingStudentListAll();
    }
    
    public function studentListAll()
    {
        return ForeignStudent::studentListAll();
    }
    
    public function studentList()
    {

        return ForeignStudent::studentList();
    }
    
    public function visaExpireReport()
    {
        return  ForeignStudent::visaExpireReport();
    }

    public function updateVisaDate(Request $request)
    {

//        dump(\Log::error(print_r($request->all(),true)));

        $this->validate($request, 
            [
                'student_id' => ['required', 'integer'],
                'new_date_of_visa_issue' => ['nullable', 'date'],
                'new_date_of_visa_expire' => ['nullable', 'date'],
                'bd_mobile' => ['nullable', new CheckValidPhoneNumber],
                'email' => ['nullable', 'email'],
                'present_address' => ['nullable'],
                'emergency_name' => ['nullable'],
                'emergency_nationality' => ['nullable'],
                'emergency_mobile' => ['nullable'],
                'passport_no' => ['nullable'],
                'date_of_issue' => ['nullable','date'],
                'date_of_expire' => ['nullable','date'],
                'date_of_arrival_bd' => ['nullable','date'],
                'first_visa_number' => ['nullable'],
                'running_semester' => ['nullable'],
                'sex' => ['required'],
                'present_nationality' => ['required'],
            ]
        );

        try {
    
            ForeignStudent::updateVisaExpireDate( 
                $request->student_id , 
                $request->new_date_of_visa_issue,
                $request->new_date_of_visa_expire,
                $request->bd_mobile,
                $request->email,
                $request->present_address,
                $request->emergency_name,
                $request->emergency_nationality,
                $request->emergency_mobile,
                $request->passport_no,
                $request->date_of_issue,
                $request->date_of_expire,
                $request->date_of_arrival_bd,
                $request->first_visa_number,
                $request->running_semester,
                $request->sex,
                $request->present_nationality
            );

            return response()->json(['message'=>'Visa Updated'], 200);       

        } catch (\Exception $e) {

            return response()->json(['message'=> $e->getMessage() .', code:' . $e->getCode()],  400);       
        }


        
    }

    
    public function applidForVisa( $student_id )
    {
        return ForeignStudent::applidForVisa( $student_id );        
    }

    
    public function studentListForAppliedForVisa(Request $request)
    {
        return ForeignStudent::studentListForAppliedForVisa();        
    }

    
/**
     *  get visa report that will expire within 3 months
     */    
    public static function studentListForCSVDownload()
    {
        
        
        $students = ForeignStudent::dump(false)
            ->isAppliedForVisa(false)
            ->with('relUser')
            // ->select(['id','user_id','student_id','registration_no','visa_date_of_issue','visa_date_of_expire', 'bd_mobile'])
            ->admitted()
            ->get();

        if ( $students->count() == 0 ) {
            return response()->json(['message'=>'No Student found!'], 400);
        }    

        $batch_ids  = ['batch_ids'=>$students->pluck('batch_id')->toArray()];
        
        $batch_info = self::rms_get_batch_info_by_ids( $batch_ids);
        $batch_info_collection = collect( $batch_info );
        

        $headerArray = [
          "name" => "name",
          "email" => "email",
          "interested_subject" => "Department",
          "batch_id" => "batch",
          "roll" => "roll",
          "permanent_mobile" => "permanent_mobile",
          "present_telephone" => "present_telephone",
          "present_mobile" => "present_mobile",
          "father_mobile" => "father_mobile",
          "guardian_mobile" => "guardian_mobile",
          "present_address" => "present_address",
          "bd_mobile" => "bd_mobile",
          "emergency_name" => "emergency_name",
          "emergency_nationality" => "emergency_nationality",
          "emergency_mobile" => "emergency_mobile",
          "passport_no" => "passport_no",
          "date_of_issue" => "date_of_issue",
          "date_of_expire" => "date_of_expire",
          "first_visa_number" => "first_visa_number",
          "visa_date_of_issue" => "visa_date_of_issue",
          "visa_date_of_expire" => "visa_date_of_expire",
          "date_of_arrival_bd" => "date_of_arrival_bd",
        ];

        $dataArray = [];
        $i = 1;

        foreach ($students as $student) {
            $batch = $batch_info_collection->where('id', $student->batch_id)->first();
            
            $dataArray  [] = [
                "name" =>$student->relUser->name ?? '',
                "email" => $student->relUser->email ?? '',
                "interested_subject" => $student->interested_subject,
                "batch_id" => $batch['batch_name'] ?:'NA'  , 
                "roll" => $student->roll,
                "permanent_mobile" => $student->permanent_mobile,
                "present_telephone" => $student->present_telephone,
                "present_mobile" => $student->present_mobile,
                "father_mobile" => $student->father_mobile,
                "guardian_mobile" => $student->guardian_mobile,
                "present_address" => $student->present_address,
                "bd_mobile" => $student->bd_mobile,
                "emergency_name" => $student->emergency_name,
                "emergency_nationality" => $student->emergency_nationality,
                "emergency_mobile" => $student->emergency_mobile,
                "passport_no" => $student->passport_no,
                "date_of_issue" => $student->date_of_issue==null?'--': $student->date_of_issue->format("Y-m-d"),
                "date_of_expire" => $student->date_of_expire==null?'--': $student->date_of_expire->format("Y-m-d"),
                "first_visa_number" => $student->first_visa_number,
                "visa_date_of_issue" => $student->visa_date_of_issue==null?'--': $student->visa_date_of_issue->format("Y-m-d"),
                "visa_date_of_expire" => $student->visa_date_of_expire==null?'--': $student->visa_date_of_expire->format("Y-m-d"),
                "date_of_arrival_bd" => $student->date_of_arrival_bd==null?'--': $student->date_of_arrival_bd->format("Y-m-d"),
            ];

            $i++;
        }

       self::collectionToCSV( $dataArray , $headerArray);

    } 

    /*
     
    */
    public static function collectionToCSV(array $data,array $rowName=[],string $fileName="export.csv")
    {

          
        header('Content-Disposition: attachment; filename="'.$fileName.'"');
        header("Cache-control: private");
        header("Content-type: application/force-download");
        header("Content-transfer-encoding: binary\n");

        if ( count($data) == 0) {
            echo "No Data Found!";
            exit(0);    
        }

        if ( count( $rowName) > 0) {
            foreach ($rowName as $key => $title) {
                echo '"' . $title . '",';
            }
            echo "\n";
        }

        foreach ($data as $row) {

            if (count($rowName) ==0 ) {

                $rowName = array_keys( $row );
                $rowName = array_flip( $rowName );
            }

            foreach ($rowName as $key=>$property) {                
                echo '"' . $row[$key] .'",';
            }
            echo "\n"; 

            
        }

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        return ForeignStudent::findForeignStudent($id, $withUser = true);
    }
}
