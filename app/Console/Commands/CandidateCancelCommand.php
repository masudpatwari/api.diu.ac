<?php
/**
 *
 * PHP version >= 7.0
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */

namespace App\Console\Commands;


use App\Mail\CandidateRejectionMail;
use App\Resume;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

/**
 * Class deletePostsCommand
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class CandidateCancelCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "CancelCandidates";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Sync Image from ORACLE to API Server";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
//        $id = ["63",
//            "269",
//            "210",
//            "338",
//            "574",
//            "630",
//            "724",
//            "61",
//            "802",
//            "781",
//            "865",
//            "369",
//            "259",
//            "768",
//            "808",
//            "762",
//            "id",
//            "831",
//            "766",
//            "191",
//            "695",
//            "87",
//            "48",
//            "261",
//            "547",
//            "72",
//            "603",
//            "171",
//            "57",
//            "617",
//            "318",
//            "88",
//            "734",
//            "857",
//            "339",
//            "706",
//            "803",
//            "200",
//            "582",
//            "309",
//            "333",
//            "611",
//            "291",
//            "845",
//            "876",
//            "761",
//            "253",
//            "295",
//            "212",
//            "254"];
//
//
//        $resumes = Resume::whereIn('id', $id)->get();
//
//        dd($resumes->pluck('a_status'));
//
//        foreach ($resumes as $resume)
//        {
//
//            $resume->update([
//            'a_status' => 4
//        ]);
//
//        }
//
//        dd($id);
        $resumes = Resume::where('a_status', 4)->get();


//        foreach ($resumes as $resume)
//        {
//            $resume->update([
//                'a_status' => 3
//            ]);
//        }
//
//        dd('done');

        foreach ($resumes as $resume)
        {
            if($resume)
            {
                $resume->update([
                    'a_status' => 0
                ]);

                Mail::to($resume->email)->send(new CandidateRejectionMail($resume));

//                dd('Candidate Cancelled Successfully: '. $resume->name);

                $this->info('Candidate Cancelled Successfully: '. $resume->name);

            }else{
                $this->info('Candidate Not Found: '. $resume);
            }
        }
    }
}
