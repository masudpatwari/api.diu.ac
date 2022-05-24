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
use App\LiaisonOfficersSmsHistory;

/**
 * Class deletePostsCommand
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class LiaisonOfficersSendSms extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "LiaisonOfficersSendSms";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Send sms from liaison_officers_sms_histories table";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $histories = LiaisonOfficersSmsHistory::where('status', 'false')->get();
        if (!empty($histories)) {
            foreach ($histories as $key => $history) {
                if (smsSender($history->mobile_no, $history->message)) {
                    LiaisonOfficersSmsHistory::where('mobile_no', $history->mobile_no)->update([
                        'status' => 'true'
                    ]);
                }
            }
        }
    }
}
