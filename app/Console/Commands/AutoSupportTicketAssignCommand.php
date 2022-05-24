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

class AutoSupportTicketAssignCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "AutoSupportTicketAssignCommand";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Every day support ticket auto assign to department authorize person by root user";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        //employee ticket department wise auto assign start
        $employeeSupportTickets = \App\Models\ItSupport\SupportTicket::with('support_ticket_department', 'support_ticket_department.supportTicketDepartmentRandomEmployees')
            ->whereNotNull('support_ticket_department_id')
            ->whereStatus('active')
            ->whereNull('assaign_to')
            ->get();

        foreach ($employeeSupportTickets as $employeeSupportTicket) {

            $employeeSupportTicket->assaign_to = $employeeSupportTicket->support_ticket_department->supportTicketDepartmentRandomEmployees->employee_id ?? null;
            $employeeSupportTicket->assign_by = env('ROOT_EMPLOYEE_ID');
            $employeeSupportTicket->assign_date_time = Carbon::now();
            $employeeSupportTicket->save();

            $this->info("IST-E-{$employeeSupportTicket->id} assign successfully by root employee.");

        }
        //employee ticket department wise auto assign end


        //student ticket department wise auto assign start
        $studentSupportTickets = \App\Models\STD\SupportTicket::with('support_ticket_department', 'support_ticket_department.supportTicketDepartmentRandomEmployees')
            ->whereNotNull('support_ticket_department_id')
            ->whereStatus('active')
            ->whereNull('assaign_to')
            ->get();

        foreach ($studentSupportTickets as $studentSupportTicket) {

            $studentSupportTicket->assaign_to = $studentSupportTicket->support_ticket_department->supportTicketDepartmentRandomEmployees->employee_id ?? null;
            $studentSupportTicket->assign_by = env('ROOT_EMPLOYEE_ID');
            $studentSupportTicket->assign_date_time = Carbon::now();
            $studentSupportTicket->save();
            $this->info("IST-S-{$studentSupportTicket->id} assign successfully by root employee.");

        }
        //student ticket department wise auto assign end

    }
}
