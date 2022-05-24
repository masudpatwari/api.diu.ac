<?php

namespace App\Http\Controllers\ItSupport;

use App\Http\Resources\AutoCompleteResource;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ItSupport\SupportTicket;
use App\Models\ItSupport\SupportTicketFile;
use App\Models\ItSupport\SupportTicketReply;
use App\Models\ItSupport\SupportTicketReplyFile;
use App\Http\Resources\SupportTicketResource;

class SupportTicketController extends Controller
{
    public function index(Request $request)
    {
        $auth = $request->auth->id;
        $supportTickets = SupportTicket::with('user:id,name','support_ticket_department')
            ->withCount([
                'supportTicketReplies AS totalRow' => function ($query) use ($auth) {
                    $query->select(\DB::raw('count(*)'))->whereStatus('unseen')->where('created_by', '!=', $auth);
                }
            ])
            ->whereCreatedBy($request->auth->id)
            ->paginate(50);


//        $supportTickets = SupportTicket::with('user')->whereCreatedBy($request->auth->id)->paginate(50);
        return SupportTicketResource::collection($supportTickets);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'subject' => 'required|string',
            'purpose' => 'required|string',
//            'file' => ['nullable', 'array', 'max:1024'],
            'file.*' => ['required', 'mimes:doc,docx,pdf,jpeg,jpg,png', 'max:1024'], // 1024 = 1MB
            'priority' => 'required|in:low,medium,high,urgent',
            'type' => 'required|in:student,employee',
        ]);

        try {

            \DB::beginTransaction();
            $form = $request->all();
            unset($form['file']);
            $form['status'] = 'active';
            $form['created_by'] = $request->auth->id;

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
        )->find($id);

        $auth = $request->auth->id;

        $SupportTicketReply = SupportTicketReply::where([
            'support_ticket_id' => $id,
            'status' => 'unseen',
        ])->where('created_by', '!=', $auth)
            ->update([
                'status' => 'seen'
            ]);

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
        $supportTicketReply->created_by = $request->auth->id;
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

    public function supportTicketStatus(Request $request)
    {

//        dump(\Log::error(print_r($request->all(),true)));

        $this->validate($request, [
            'ticketId' => 'required|integer',
            'status' => 'required|string',
        ]);

        $supportTicket = SupportTicket::find($request->ticketId);
        $supportTicket->status = $request->status;
        $supportTicket->canceled_by = $request->auth->id;
        $supportTicket->cancel_date_time = Carbon::now();
        $supportTicket->save();

        return response()->json(['message' => 'Support Ticket ' . $request->status . ' successfully'], 200);

    }

    public function autoComplete()
    {
        // employee ticke auto complete start
        $employeeSupportTicket = SupportTicket::has('supportTicketReplies')
            ->whereStatus('active')
            ->get();

        foreach ($employeeSupportTicket as $supportTicket) {

            $employeeSupportTicketReply = SupportTicketReply::where('support_ticket_id',$supportTicket->id)->orderByDesc('id')->first();


            if ($employeeSupportTicketReply->created_by != $supportTicket->created_by && Carbon::parse($employeeSupportTicketReply->reply_date_time)->addDay(7)->format('Y-m-d') <= Carbon::now()->format('Y-m-d')) {

                SupportTicketReply::create([
                    'support_ticket_id' => $supportTicket->id,
                    'reply_text' => 'You didn\'t reply for 7 days. So that, I assumed your problem has been solved. If it exists, please don\'t hesitate to re-open this issue again.',
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
        // employee ticke auto complete end

        // student ticket auto complete start
        $studentSupportTickets = \App\Models\STD\SupportTicket::has('supportTicketReplies')
            ->whereStatus('active')
            ->get();

        foreach ($studentSupportTickets as $supportTicket) {

            $supportTicketReply = \App\Models\STD\SupportTicketReply::where('support_ticket_id', $supportTicket->id)->orderByDesc('id')->first();

            if ($supportTicketReply->created_by && Carbon::parse($supportTicketReply->reply_date_time)->addDay(7)->format('Y-m-d') <= Carbon::now()->format('Y-m-d')) {

                \App\Models\STD\SupportTicketReply::create([
                    'support_ticket_id' => $supportTicket->id,
                    'reply_text' => 'You didn\'t reply for 7 days. So that, I assumed your problem has been solved. If it exists, please don\'t hesitate to re-open this issue again.',
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


    }
}
