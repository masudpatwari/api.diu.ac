<?php

namespace App\Models\INTL;

use Illuminate\Database\Eloquent\Model;
use App\Models\STD\AttendanceReport;
use App\Models\INTL\User;
use Carbon\Carbon;
use App\Http\Resources\intl\VisaExpireResource;
use App\Http\Resources\intl\ForeignStudentAttendanceReportResource;
use App\Http\Resources\intl\ForeignStudentListResource;
use App\Http\Resources\intl\DumpForeignStudentResourse;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ForeignStudent extends Model
{


	protected $table = "foreign_students";
    protected $connection = 'intl';

    //*
    protected $dates = [
        'visa_date_of_issue',
        'visa_date_of_expire',
        'dump_date',
        'date_of_issue',
        'date_of_expire',
        'date_of_arrival_bd',
    ];
    //*/

    protected $fillable = [
        "user_id",
        "permanent_address",
        "permanent_telephone",
        "permanent_mobile",
        "present_address",
        "present_telephone",
        "present_mobile",
        "address_in_bd",
        "bd_telephone",
        "bd_mobile",
        "dob",
        "sex",
        "marital_status",
        "blood_group",
        "religion",
        "place_of_birth",
        "present_nationality",
        "country_of_birth",
        "interested_subject",
        "passport_no",
        "type_of_passport",
        "date_of_issue",
        "place_of_issue",
        "date_of_expire",
        "date_of_last_visit_bd",
        "last_visa_no",
        "visa_category",
        "visa_place_of_issue",
        "visa_date_of_issue",
        "visa_date_of_expire",
        "date_of_arrival_bd",
        "flight_no",
        "father_name",
        "father_nationality",
        "father_mobile",
        "mother_name",
        "mother_nationality",
        "mother_mobile",
        "spouse_name",
        "spouse_nationality",
        "spouse_mobile",
        "guardian_name",
        "guardian_nationality",
        "guardian_mobile",
        "emergency_name",
        "emergency_nationality",
        "o_name_of_exam",
        "o_group",
        "o_roll_no",
        "o_year_of_passing",
        "o_letter_grade",
        "o_cgpa","o_board",
        "o_link_of_certificate",
        "t_name_of_exam",
        "t_group",
        "t_roll_no",
        "t_year_of_passing",
        "t_letter_grade",
        "t_cgpa","t_board",
        "t_link_of_certificate",
        "th_name_of_exam",
        "th_group",
        "th_roll_no",
        "th_year_of_passing",
        "th_letter_grade",
        "th_cgpa","th_board",
        "th_link_of_certificate",
        "fo_name_of_exam",
        "fo_group",
        "fo_roll_no",
        "fo_year_of_passing",
        "fo_letter_grade",
        "fo_cgpa",
        "fo_board",
        "fo_link_of_certificate",
        "registration_no",
        "student_id",
        "department_id",
        "batch_id",
        "roll",
        "referral_id",
        "running_semester",
        "adm_frm_sl",
        "session",
        "idcard_expire",
        "is_admitted",
        "emergency_mobile",
        "reference_facebook",
        "reference_email",
        "reference_relation",
        "reference_type",
        "media_reference_type",
        "media_reference_detail",
        "fg_monthly_income",
    ];

    public function scopeDump($query, bool $value)
    {
        return $query->where('is_dump', $value);
    }

    public function scopeAdmitted( $query )
    {
        return $query->where('is_admitted', 'true');
    }

    public function scopeNotAdmitted( $query )
    {
        return $query->where('is_admitted', 'false');
    }

    public function scopeIsAppliedForVisa( $query , $value)
    {
        return $query->where('applied_for_visa', $value);
    }

    public static function applidForVisa($student_id)
    {
        $foreignStudent = self::where('student_id', $student_id)->first();

        if ( ! $foreignStudent ) {
            return response()->json(['message'=>'No Student Found!'], 400);
        }

        if( $foreignStudent->applied_for_visa == true){
            return response()->json(['message'=>'Student Visa pending!'], 400);
        }

        $foreignStudent->applied_for_visa = true;
        $foreignStudent->save();

        return response()->json(['message'=>'Student marked as Applide For Visa ']);
    }

    public static function show($userId){
         $foreignStudentList = self::with('relUser')
            ->where('user_id', $userId)
            ->notAdmitted()
            ->first();
        return $foreignStudentList;
    }
    /**
        All foreign student list
    */
    public static function studentListAll()
    {
        $foreignStudentList = self::with('relUser')            
            ->get();

        if ( $foreignStudentList->count() == 0) {
            return response()->json(['message'=>'No Student Found As Visa Pending!'], 400);
        }

        return ForeignStudentListResource::collection( $foreignStudentList );
    }

    /**
        foreign student list who are not admitted yet
    */
    public static function upcomingStudentListAll()
    {
        $foreignStudentList = self::with('relUser')  
            ->notAdmitted()
            ->get();

        if ( $foreignStudentList->count() == 0) {
            return response()->json(['message'=>'No Student Found As Visa Pending!'], 400);
        }

        return ForeignStudentListResource::collection( $foreignStudentList );
    }

    public static function studentListForAppliedForVisa()
    {
        $foreignStudentList = self::dump(false)
            ->admitted()
            ->with('relUser')            
            ->where('applied_for_visa', true)
            ->get();

        if ( $foreignStudentList->count() == 0) {
            return response()->json(['message'=>'No Student Found As Visa Pending!'], 400);
        }

        return ForeignStudentListResource::collection( $foreignStudentList );
    }

    public static function makeDump(Request $request)
    {
        $foreignStudent = self::findForeignStudent( $request->student_id, $withUser =false );

        if ( $foreignStudent->is_dump ) {
            throw new \Exception("Student already dumped", 400);
        }
        $foreignStudent->is_dump = true;
        $foreignStudent->dump_date = (new Carbon)->now();
        $foreignStudent->dump_cause = $request->cause;
        $foreignStudent->dump_by = $request->auth->id;
        $foreignStudent->save();
    }

    public static function retiveDump($student_id, $cause)
    {
        $foreignStudent = self::findForeignStudent( $student_id, $withUser =false );

        if ( ! $foreignStudent->is_dump ) {
            throw new \Exception("Student not in dumped", 400);
        }

        $foreignStudent->is_dump = false;
        $foreignStudent->dump_date = null;
        $foreignStudent->dump_cause = null;
        $foreignStudent->dump_by = null;
        return $foreignStudent->save();
    }
    

    public static function dumpStudentList()
    {
        $dumpForeignStudent = self::with('relUser')->dump(true)->get();

        if ( $dumpForeignStudent->count() == 0 ) {
            throw new \Exception("Dump Student list empty", 400);
        }
        return DumpForeignStudentResourse::collection($dumpForeignStudent);
    }

    public function relUser()
    {
        return $this->belongsTo(User::class,'user_id','id');
    } 

    public function relReferralBy()
    {
        return $this->belongsTo(User::class, 'referral_id', 'id');
    }

    public static function studentList()
    {
         $foreignStudentCollection = self::dump(false)->with('relUser')
            ->where( [ 'is_admitted' => 'true' ] )
            ->get();

        return ForeignStudentListResource::collection( $foreignStudentCollection );
    }

    public static function attendanceReport( int $daysBefore = 15 )
    {


        $foreignStudentCollection = self::dump(false)->with('relUser')
            ->where( [ 'is_admitted' => 'true' ] )
            ->get();

        $foreignStudentIds = $foreignStudentCollection->pluck( 'student_id')
            ->toArray();


        $lastClass = AttendanceReport::selectRaw("max(student_id) student_id ,max(created_at) created_at")
            ->whereIn('student_id', $foreignStudentIds)
            ->groupby('student_id')
            ->get();

        $lastClassUpdateCollection = $lastClass
            ->filter(function($i)  {
                $i->daysBefore =  $i->created_at->diffInDays((new Carbon())->now());
                return $i;
            });

        $foreignStudentCollection->filter( function( $i ) use( $lastClassUpdateCollection, $daysBefore ){

            $classHistory = $lastClassUpdateCollection->where('student_id', $i->student_id)->first();
            
            if ( $classHistory ) {
                if ( $classHistory->daysBefore > $daysBefore) {
                    $i->lastClassAttainedOn = $classHistory->created_at->format("d F, Y");
                    $i->daysBefore = $classHistory->daysBefore;
                    return $i;
                }else{
                    $i->lastClassAttainedOn = 'Regular';
                    $i->daysBefore = 'Regular';
                    return $i;
                }
            }else{
                $i->lastClassAttainedOn = 'Att. Not Found!';
                $i->daysBefore = 'NA';
                return $i;
            }
        });

        $finalData = $foreignStudentCollection
            ->where('lastClassAttainedOn','!=','Regular')
            ->sortByDesc('daysBefore');

        return ForeignStudentAttendanceReportResource::collection( $finalData );
        
    }

    /**
     *  get visa report that will expire within 3 months
     */    
    public static function visaExpireReport()
    {

        $before = (new Carbon())->addMonths(3);   

        $data = self::dump(false)
            ->isAppliedForVisa(false)
            ->with('relUser')
            ->select(['id','user_id','student_id','registration_no','visa_date_of_issue','visa_date_of_expire', 'bd_mobile'])
            // ->whereBetween('visa_date_of_expire', [$now , $before])
            ->where(function($q)use($before){
                $q->where('visa_date_of_expire', '<' , $before)
                    ->orWhereRaw('visa_date_of_expire is null');
            })
            ->where('is_admitted', 'true')
            ->get();

        if ( $data->count() == 0 ) {
                return response()->json(['message'=>'No Student found which will expire within 90 days !'], 400);
        }    

        $studentIdsArray =  $data->pluck('student_id')->toArray();

        /*
         ACCOUNTS INFO 
        */
        $input = [
            'ora_uids'=> $studentIdsArray 
        ];

        $url = env('RMS_API_URL').'/get-accounts-info';

        $accoutsInfoResponse = Curl::to($url)->withData($input)->returnResponseObject()->asJson(true)->post();
        
        if( $accoutsInfoResponse->status != 200 ){
            return response()->json(['message'=>'ERP data load fail'], 400);
        }
        $accoutsInfo = $accoutsInfoResponse->content;

        /* 
         LAST CLASS DATE
        */
        $lastClass = AttendanceReport::selectRaw("max(student_id) student_id ,max(created_at) created_at")
            ->whereIn('student_id', $studentIdsArray )
            ->groupby('student_id')
            ->get();

        $lastClassUpdateCollection = $lastClass
            ->filter(function($i)  {
                $i->daysBefore =  $i->created_at->diffInDays((new Carbon())->now());
                return $i;
            });

        $data->filter( function( $i ) use( $accoutsInfo, $lastClassUpdateCollection ){
            try {
                
                $i->remainDays = 'NA';

                if ( isset($i->visa_date_of_issue) && $i->visa_date_of_issue ) {
                    $i->visa_issue_date =  isset($i->visa_date_of_issue)? $i->visa_date_of_issue->format("d M, Y"): '';
                }
        
                if ( isset($i->visa_date_of_expire) && $i->visa_date_of_expire ) {
                    $i->remainDays =  isset($i->visa_date_of_expire)? $i->visa_date_of_expire->diffInDays((new Carbon())->now()) : '';
                    $i->visa_expire_date =  isset($i->visa_date_of_expire)? $i->visa_date_of_expire->format("d F, Y"):'';
                }

                $i->accoutsInfo = $accoutsInfo[ $i->student_id]['summary'];
                
                $i->lastClass = $lastClassUpdateCollection->where('student_id', $i->student_id)->first();

                return $i;
            } catch (\Exception $e) {
                return $i;
            }
           
        }); 

        return VisaExpireResource::collection($data->sortBy('remainDays'));    
    }
    

    public static function findForeignStudent( int $studentId , $withUser = false, $withDump = false)
    {
        $student = self::dump($withDump)->where('student_id', $studentId )->first();

        if ( $student ) {
            if ( $withUser) {
                $student->load('reluser');
            }
            return $student;
        }

        throw new \Exception("No student Found", 400);        

    }
    
    public static function updateVisaExpireDate(
        int $studentId, 
        string $visa_date_of_issue, 
        string $visa_date_of_expire,
        string $bd_mobile,
        string $email,
        string $present_address,
        string $emergency_name,
        string $emergency_nationality,
        string $emergency_mobile,
        string $passport_no,
        string $date_of_issue,
        string $date_of_expire,
        string $date_of_arrival_bd,
        string $first_visa_number,
        string $running_semester,
        string $sex,
        string $present_nationality
    )
    {

        $vars =  get_defined_vars();

        $student = self::findForeignStudent(  $studentId ) ;
        

        foreach( $vars as $var => $val){
            if ( $var == 'studentId' || $val =='') {
                continue;
            }

            if ( $var == 'email') {
                $user = User::find($student->user_id);
                $user->email = $val;
                $user->save();
            }else{
                $student->$var = $val;
            }
        }

        if ( $student->isDirty('visa_date_of_issue') || $student->isDirty('visa_date_of_expire')) {
            $student->applied_for_visa = false;            
        }
        
        if ( $student->isDirty()) {
            $student->save();    
        }
        return $student;
        
    }


}
