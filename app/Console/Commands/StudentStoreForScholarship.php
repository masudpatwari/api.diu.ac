<?php

/**
 *
 * PHP version >= 7.0
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */

namespace App\Console\Commands;


use Illuminate\Console\Command;
use App\Liaison_programs;
use App\LiaisonOfficer;
use App\BillOnStudentAdmission;
use Ixudra\Curl\Facades\Curl;


/**
 * Class deletePostsCommand
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class StudentStoreForScholarship extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "StudentStoreForScholarship";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "New  Student Store for Scholarship";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {


        $amount = 0;
        $student_detail = '';
        $person_detail = '';
        $personId = 0;
        $eligible_id = null;

        $students = $this->traits_get_new_admission_student();

        if($students){
            foreach ($students as $student) {
                $exists = BillOnStudentAdmission::where('student_id', $student['id'])->first();
    
                if (empty($exists)) {
                    $person_detail = '';
                    $student_detail = '';
                    $eligible_status = 0
;    
                    // Check if there's a liaison officer with the specified code
                    $officer = LiaisonOfficer::where('code', $student['ref_val'])->first();
    
                    if ($officer) {
                        // Populate person details for officer
                        $person_detail .= 'ID# ' . $officer->id .'(LO)'.'<br>';
                        $person_detail .= $officer->name . '<br>';
                        $person_detail .= $officer->institute . '<br>';
                        $person_detail .= $officer->code . '<br>';
                        $person_detail .= $officer->mobile1 . '<br>';
    
                        $amount = $this->get_amount_for_officer($student);
                        $type = 'liaison_officer';
                        $personId = $officer->id; // Set person ID for liaison officer (if needed)
                    } elseif (isset($student['admittedByStd']['id']) && $student['admittedByStd']['id'] != null) {
                        // Populate person details for admitted student
                        $person_detail .= 'ID# ' . $student['admittedByStd']['id']  .'<br>';
                        $person_detail .= $student['admittedByStd']['name'] . '<br>';
                        $person_detail .= $student['admittedByStd']['department']['name'] . '<br>';
                        $person_detail .= $student['admittedByStd']['reg_code'] . '<br>';
                        $person_detail .= 'Batch- ' . $student['admittedByStd']['batch']['batch_name'] . '<br>';
                        $person_detail .= 'Roll# ' . $student['admittedByStd']['roll_no'] . '<br>';
    
                        $amount = $this->get_amount_for_student($student); // Calculate amount for student
                        $type = 'liaison_student';
                        $personId = $student['admittedByStd']['id']; // Set person ID for student
                    } else {
                        // Handle case where neither officer nor student details are available
                        $type = 'general';
                        $amount = 0;
                        $personId = 0;
                        $eligible_status = 1;
                        $eligible_id = $student['id'];
                    }
    
                    // Populate student details
                    $student_detail .= 'ID# ' . $student['id'] . '<br>';
                    $student_detail .= $student['name'] . '<br>';
                    $student_detail .= $student['department']['name'] . '<br>';
                    $student_detail .= $student['reg_code'] . '<br>';
                    $student_detail .= 'Batch- ' . $student['batch']['batch_name'] . '<br>';
                    $student_detail .= 'Roll# ' . $student['roll_no'] . '<br>';
    
                    // Create new bill instance and save
                    $bill = new BillOnStudentAdmission();
                    $bill->student_id = $student['id'];
                    $bill->type = $type;
                    $bill->person_id = $personId;
                    $bill->student_detail = $student_detail;
                    $bill->person_detail = $person_detail;
                    $bill->amount = $amount;
                    $bill->eligible_id = $eligible_id;
                    $bill->eligible_status = $eligible_status;
                    $bill->save();

                    $today = date('Y-m-d H:i:s');

                    $this->info('Student Insert For Scholarship_'.$today);
                }
            }

        }

       
    }

    public function traits_get_new_admission_student()
    {

        $url = '' . env('RMS_API_URL') . '/get_new_admission_students';
        $response = Curl::to($url)->returnResponseObject()->asJson(true)->get();
        if ($response->status == 200) {
            return $response->content;
        }
        throw new \Exception("Student not found", 1);
    }

    public function get_amount_for_student($std)
    {
        if (strpos(strtolower($std['nationality']), 'ban') !== false) {
            return optional(Liaison_programs::where('name', trim($std['department']['name']))->first())
                ->amount_std_local;
        } else {
            return Liaison_programs::where('name', trim($std['department']['name']))->first()->amount_std_foreign;
        }
    }

    public function get_amount_for_officer($stddata)
    {

        if (strpos(trim(strtolower($stddata['nationality'])), 'ban') !== false) {
            return optional(Liaison_programs::where('name', $stddata['department']['name'])->first())
                ->amount_liaison_local;
        } else {

            $ret = Liaison_programs::where('name', $stddata['department']['name'])->first()->amount_liaison_foreign;
            return $ret;
        }
    }
}
