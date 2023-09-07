<?php

namespace App\Http\Controllers\STD;

use App\Models\ItSupport\SupportTicketDepartments;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\STD\SupportTicket;
use App\Http\Controllers\Controller;
use App\Models\STD\SupportTicketFile;
use App\Models\STD\SupportTicketReply;
use App\Models\STD\SupportTicketReplyFile;
use App\Http\Resources\SupportTicketResource;

class SupportTicketController extends Controller
{
    public function index(Request $request)
    {

        $supportTickets = SupportTicket::with(
            'user:ID,NAME',
            'assign:id,name',
            'deny:id,name',
            'cancel:id,name',
            'completed:id,name',
            'permissionSeeker:id,name',
            'supportTicketFiles',
            'supportTicketReplies',
            'support_ticket_department'
        )->withCount([
            'supportTicketReplies AS totalRow' => function ($query) {
                $query->select(\DB::raw('count(*)'))
                    ->whereStatus('unseen')
                    ->whereNotNull('created_by');
            }
        ])
            ->whereCreatedBy($request->auth->ID)
            ->orderBy('id', 'desc')
            ->paginate(50);


        return SupportTicketResource::collection($supportTickets);
    }

    public function store(Request $request)
    {
//        dump(\Log::error(print_r($request->all(),true)));

        $this->validate($request, [
            'support_ticket_department_id' => 'required|string|max:300',
            'subject' => 'required|string|max:300',
            'purpose' => 'required|string',
            'file.*' => ['nullable', 'mimes:doc,docx,pdf,jpeg,jpg,png', 'max:1024'], // 1024 = 1MB
            'priority' => 'required|in:low,medium,high,urgent',
            'type' => 'required|in:student,employee',
        ]);


        try {

            \DB::beginTransaction();
            $form = $request->all();
            unset($form['file']);
            $form['status'] = 'active';
            $form['created_by'] = $request->auth->ID;

            $data = SupportTicket::create($form);

            $files = $request->file('file');
            $imageData = [];
            if ($files) {

                foreach ($files as $key => $file) {
                    $extension = $file->getClientOriginalExtension();
                    $file_name = time() . '_' . Str::random(10) . '.' . $extension;
                    $file->move(storage_path('images/support_ticket'), $file_name);
                    $imageData[] = [
                        'file_url' => 'images/support_ticket/' . $file_name,
                        'support_ticket_id' => $data->id,
                    ];
                }
            }

            SupportTicketFile::insert($imageData);

            \DB::commit();

            return response()->json(['message' => 'Ticket Created Successfully'], 200);
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return response()->json(['message' => 'Something went to wrong'], 401);
        }


    }

    public function show(Request $request, $id)
    {

        $supportTicket = SupportTicket::with(
            'user',
            'deny',
            'assign',
            'cancel',
            'completed',
            'permissionSeeker',
            'supportTicketFiles',
            'supportTicketReplies',
            'supportTicketReplies.user',
            'supportTicketReplies.user.relDepartment',
            'supportTicketReplies.user.relDesignation',
            'supportTicketReplies.supportTicketReplyFiles'
        )->where([
            'created_by' => $request->auth->ID,
            'id' => $id
        ])->first();

        SupportTicketReply::where([
            'support_ticket_id' => $id,
            'status' => 'unseen',
        ])->whereNotNull('created_by')->update(['status' => 'seen']);

        return new SupportTicketResource($supportTicket);
    }

    public function reply(Request $request)
    {
        $this->validate($request, [
            'ticketId' => 'required|integer',
            'reply' => 'required|string',
            'file.*' => ['nullable', 'mimes:doc,docx,pdf,jpeg,jpg,png', 'max:1024'], // 1024 = 1MB
        ]);

        $supportTicketReply = new SupportTicketReply();
        $supportTicketReply->support_ticket_id = $request->ticketId;
        $supportTicketReply->reply_text = $request->reply;
        $supportTicketReply->reply_date_time = Carbon::now();
        $supportTicketReply->save();

        $files = $request->file('file');
        $imageData = [];
        if ($files) {
            foreach ($files as $key => $file) {
                $extension = $file->getClientOriginalExtension();
                $file_name = time() . '_' . Str::random(10) . '.' . $extension;
                $file->move(storage_path('images/support_ticket_reply'), $file_name);
                $imageData[] = [
                    'file_url' => 'images/support_ticket_reply/' . $file_name,
                    'support_ticket_replies_id' => $supportTicketReply->id,
                ];
            }
        }

        SupportTicketReplyFile::insert($imageData);

        return response()->json(['message' => 'Reply Created Successfully'], 200);
    }

    public function status(Request $request)
    {
//        dump(\Log::error(print_r($request->all(), true)));

        $this->validate($request, [
            'ticketId' => 'required|integer',
        ]);

        $supportTicket = SupportTicket::where([
            'id' => $request->ticketId,
            'created_by' => $request->auth->ID,
        ])->first();

        $supportTicket->status = $request->status;

        if ($request->status == 'canceled') {
            $supportTicket->canceled_by = null;
            $supportTicket->cancel_date_time = Carbon::now();
        }

        if ($request->status == 'active') {
            $supportTicket->completed_by = null;
            $supportTicket->completed_date_time = null;
        }

        $supportTicket->save();

        return response()->json(['message' => 'Support Ticket status changed successfully'], 200);

    }


    public function studentSupportTicketDepartment()
    {
        return SupportTicketDepartments::pluck('department_name','id');
    }

}
