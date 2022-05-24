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
use Ixudra\Curl\Facades\Curl;


class ImportSmsCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "ImportSmsCommand";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Import SmsCommand";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $urlArray = [
            'http://www.bangladeshsms.com/miscapi/C20035295ea81b0d403aa8.09681548/getUnreadReplies'
        ];

        foreach ($urlArray as $url) {

            $response = Curl::to($url)
                ->returnResponseObject()
                ->asJson(true)
                ->get();
            
            if ($response->status == 200) {
                $rows = $response->content;
            }
            else{
                echo " Import fail from $url @ " . date("Y-m-d H:i:s");
                return;
            }

            // $jsonString = file_get_contents(storage_path('all from Elitbuzz tec.json'));
            // $fetch_json_data = json_decode($jsonString, true);

            $inserData = [];
            foreach ($rows as $row) {
                $inserData[] = [
                    'mobilenumber' => $row['mobile'],
                    'message' => $row['message'],
                    'message_time' => $row['time_MO'],
                ];
            }

            \DB::table('imported_sms')->insert($inserData);

            echo "sucessfully insert from $url @ ". date("Y-m-d H:i:s") ."\n";

        }

    }
}
