<?php
/**
 *
 * PHP version >= 7.0
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use App\Models\INTL\User;
use App\Models\INTL\ForeignStudent;
use App\Traits\RmsApiTraits;
use Illuminate\Support\Facades\Log;


/**
 * Class deletePostsCommand
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class ImportForeignStdToIntlSite extends Command
{
    
    use RmsApiTraits;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "ImportForeignStdToIntlSite";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Import Foreign Student from RMS to Int'l Site. ";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $insertedStudentIdArray = ForeignStudent::where('is_admitted','true')
            ->pluck('student_id')
            ->toArray();


        $studentsAsArray =  $this->traits_latest_foreign_students( $insertedStudentIdArray );

        if ( $studentsAsArray !== false) {
            
            $studentCollection = collect( $studentsAsArray );

            $this->info( $studentCollection->count() . " student are importing at " . date("Y-m-d H:i:s"));
            foreach ($studentCollection as $student) {
                $profile = $student;

                try {
                    //DB::connection('intl')->beginTransaction();

                    $user = User::create([
                        'name' => $profile['name'],
                        'email' => (!empty($profile['email'])) ? $profile['email'] : strtolower($profile['reg_code']).'@dummy.fun',
                        'email_verified_at' => date('Y-m-d h:m:s'),
                        'password' => app('hash')->make('123456'),
                        'role' => 'student',
                        'type' => 'foreign',
                    ]);

                    $student = ForeignStudent::create([
                        'user_id' => $user->id,
                        'permanent_address' => $profile['parmanent_add'],
                        'present_address' => $profile['mailing_add'],
                        'bd_telephone' => $profile['phone_no'],
                        'bd_mobile' => $profile['phone_no'],
                        'dob' => date('Y-m-d', strtotime($profile['dob'])),
                        'sex' => '',
                        'blood_group' => $profile['blood_group'],
                        'present_nationality' => '',
                        'interested_subject' => $profile['department']['name'],
                        'passport_no' => '',
                        'visa_date_of_expire' => null,
                        'father_name' => '',
                        'mother_name' => '',
                        'emergency_name' => $profile['e_name'],
                        'emergency_mobile ' => $profile['e_cellno'],
                        'registration_no' => $profile['reg_code'],
                        'session' => $profile['session_name'],
                        'referral_id' => 0,
                        'student_id' => $profile['id'],
                        'department_id' => $profile['department']['id'],
                        'batch_id' => $profile['batch']['id'],
                        'roll' => $profile['roll_no'],
                        'adm_frm_sl' => $profile['adm_frm_sl'],
                        'running_semester' => null,
                        'idcard_expire' => date('Y-m-d', strtotime($profile['batch']['valid_d_idcard'])),
                        'is_admitted' => 'true',
                    ]);
                    //DB::commit();
                } catch (\PDOException $e) {
                    //DB::rollBack();
                    Log::error($e->getMessage());
                }
                
            }

        }

    }
}
