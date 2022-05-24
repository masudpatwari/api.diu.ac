<?php
/**
 *
 * PHP version >= 7.0
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\ItSupport\SupportTicket;
use App\Models\ItSupport\SupportTicketReply;


class AutoSupportTicketCompleteCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "AutoSupportTicketComplete";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "After 7 days support ticket auto solve and auto msg fire by root user";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        // employee ticket auto complete start
        $employeeSupportTicket = SupportTicket::has('supportTicketReplies')
            ->whereStatus('active')
            ->get();

        foreach ($employeeSupportTicket as $supportTicket) {

            $employeeSupportTicketReply = SupportTicketReply::where('support_ticket_id', $supportTicket->id)->orderByDesc('id')->first();


            if ($employeeSupportTicketReply->created_by != $supportTicket->created_by && Carbon::parse($employeeSupportTicketReply->reply_date_time)->addDay(7)->format('Y-m-d') <= Carbon::now()->format('Y-m-d')) {

                SupportTicketReply::create([
                    'support_ticket_id' => $supportTicket->id,
                    'reply_text' => 'You didn\'t reply for last 7 days on that issue. So we assumed that your problem has been solved. If it is till exists, please don\'t hesitate to re-open it.',
                    'created_by' => 1,
                    'reply_date_time' => Carbon::now(),
                ]);

                SupportTicket::find($supportTicket->id)->update([
                    'status' => 'solved',
                    'completed_by' => '1',
                    'completed_date_time' => Carbon::now(),
                ]);

            }

        }
        // employee ticket auto complete end

        // student ticket auto complete start
        $studentSupportTickets = \App\Models\STD\SupportTicket::has('supportTicketReplies')
            ->whereStatus('active')
            ->get();

        foreach ($studentSupportTickets as $supportTicket) {

            $supportTicketReply = \App\Models\STD\SupportTicketReply::where('support_ticket_id', $supportTicket->id)->orderByDesc('id')->first();

            if ($supportTicketReply->created_by && Carbon::parse($supportTicketReply->reply_date_time)->addDay(7)->format('Y-m-d') <= Carbon::now()->format('Y-m-d')) {

                \App\Models\STD\SupportTicketReply::create([
                    'support_ticket_id' => $supportTicket->id,
                    'reply_text' => 'You didn\'t reply for last 7 days on that issue. So we assumed that your problem has been solved. If it is till exists, please don\'t hesitate to re-open it.',
                    'created_by' => 1,
                    'reply_date_time' => Carbon::now(),
                ]);

                \App\Models\STD\SupportTicket::find($supportTicket->id)->update([
                    'status' => 'solved',
                    'completed_by' => '1',
                    'completed_date_time' => Carbon::now(),
                ]);
            }

        }
        // student ticket auto complete end

        echo "successfully insert from @ ". date("Y-m-d H:i:s") ."\n";

    }
}
