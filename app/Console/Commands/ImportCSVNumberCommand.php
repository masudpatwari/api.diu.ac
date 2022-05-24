<?php
/**
 *
 * PHP version >= 7.0
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */

namespace App\Console\Commands;

use App\Models\PhoneCall\PhoneCall;
use Illuminate\Console\Command;
use Ixudra\Curl\Facades\Curl;


class ImportCSVNumberCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "ImportCSVNumberCommand";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Import CSV Number Command";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // $jsonString = file_get_contents(storage_path('all from Elitbuzz tec.json'));
        // $fetch_json_data = json_decode($jsonString, true);

        $filecontent = file_get_contents(storage_path('part-1.csv'));
        $lines = explode("\n", $filecontent);

        $phoneCall = [];

        $i = 0;

        foreach ($lines as $line) {
            if ($i == 0) {
                $i++;
                continue;
            }
            /*
            0   "Serial No."
            1   "mobile_number"
            */

            $fields = explode(",", $line);

            if (!isset($fields[1])) {
                continue;
            }


            $phoneCall[$i]['mobile_number'] = trim($fields[1]);
            $phoneCall[$i]['response'] = 'NEW';

            $i++;
        }

//        PhoneCall::insert($phoneCall);

        echo $filecontent;

//        echo "sucessfully insert from @ ". date("Y-m-d H:i:s") ."\n";

    }
}
