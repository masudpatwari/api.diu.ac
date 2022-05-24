<?php
/**
 *
 * PHP version >= 7.0
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */

namespace App\Console\Commands;


use App\Employee;
use App\Models\STD\Book;
use App\Models\STD\Question;
use App\Models\STD\Student;
use App\Radcheck;
use App\Transcript;
use App\WiFi;
use Exception;
use Illuminate\Console\Command;

/**
 * Class deletePostsCommand
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class TranscriptCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "TranscriptCommand";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "import Transcript";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

//        dd(Student::where('reg_code','like','%LL-E-26-18%')->count());

        $reg_codes  = Student::where('REG_CODE','like','%LL-E-26-18%')->get()->pluck('REG_CODE')->toArray();

//        dd($reg_codes);
        if ($reg_codes)
        foreach ( $reg_codes as $reg_code){
            $std = Student::where('REG_CODE', $reg_code)->first();
            $new_reg_code = str_replace('-18-','-19-',$reg_code);
            echo $reg_code . ' => ' . $new_reg_code."\n";
            dd($std);
            $std->REG_CODE = $new_reg_code;
            $std->save();

        }
        $new_reg_codes  = Student::where('REG_CODE','like','%LL-E-26-%')->get()->pluck('REG_CODE')->toArray();
        dd($reg_codes, $new_reg_codes);
    }
}
