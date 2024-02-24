<?php

namespace App\Http\Controllers\ItSupport;

use App\Employee;
use App\Models\ItSupport\SupportTicketAssignHistory;
use App\Models\ItSupport\SupportTicketReplyFile;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\SupportPermissionMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Models\ItSupport\SupportTicket;
use App\Models\ItSupport\SupportTicketFile;
use App\Models\ItSupport\SupportTicketReply;
use App\Http\Resources\SupportTicketResource;
use App\Mail\UserSupportTicketNotificationMail;
use App\Http\Resources\EmployeeResource;

class SupportTicketActionController extends Controller
{
    public function index(Request $request)
    {

        $this->validate($request, [
            'status' => 'required|string',
        ]);

        $auth = $request->auth->id;

        $supportTickets = SupportTicket::with('user:id,name', 'supportTicketFiles:id,support_ticket_id,file_url', 'support_ticket_department')
            ->withCount([
                'supportTicketReplies AS totalRow' => function ($query) use ($auth) {
                    $query->select(\DB::raw('count(*)'))->whereStatus('unseen')->where('created_by', '!=', $auth);
                }
            ])->where('status', $request->status)
            ->paginate(50);
        return SupportTicketResource::collection($supportTickets);
    }

    public function show($id)
    {

//        return SupportTicket::with('ticketAssignBy')->find($id);

        $supportTicket = new SupportTicketResource(SupportTicket::with(
            'user',
            'deny',
            'assign',
            'cancel',
            'completed',
            'ticketAssignBy',
            'permissionSeekBy',
            'permissionSeeker',
            'user.relDepartment',
            'supportTicketFiles',
            'user.relDesignation',
            'supportTicketReplies',
            'supportTicketReplies.user',
            'supportTicketReplies.user.relDepartment',
            'supportTicketReplies.user.relDesignation',
            'supportTicketReplies.supportTicketReplyFiles'
        )->find($id));

//        $employeeOthersTickets = SupportTicketResource::collection(SupportTicket::all());
        $employeeOthersTickets = SupportTicketResource::collection(SupportTicket::whereCreatedBy($supportTicket->user->id)->orderByDesc('id')->get());

        $data = [
            'supportTicket' => $supportTicket,
            'employeeOthersTickets' => $employeeOthersTickets,
        ];

        return $data;
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

    public function requestForPermission(Request $request)
    {
        try {

            $this->validate($request, [
                'ticketId' => 'required|integer',
                'permissionDetails' => 'nullable|string',
            ]);

            $supportTicket = SupportTicket::with('user', 'user.relDesignation', 'supportTicketReplies', 'supportTicketReplies.user')->find($request->ticketId);
            $supportTicket->permission_seeker_date_time = Carbon::now();
            $supportTicket->permission_details = $request->permissionDetails;
            $supportTicket->permission_seek_by = $request->auth->id ?? '';
            $supportTicket->save();


            $employee = Employee::with('relDesignation', 'relDepartment')->find($request->auth->id);


            $emailArray = explode(',', env('SUPPORT_PERMISSION_EMAILS'));

            foreach ($emailArray as $email) {
                $data = [];
                $data['permissionDetails'] = $request->permissionDetails;
                $data['yesToken'] = encrypt($email . '.0.0.0.0.' . $request->ticketId . '.0.0.0.0.' . 'yes');
                $data['noToken'] = encrypt($email . '.0.0.0.0.' . $request->ticketId . '.0.0.0.0.' . 'no');

                Mail::to($email)->send(
                    new SupportPermissionMail($data, $supportTicket, $employee)
                );
            }

            //Send mail confirmation code..
            Mail::to($supportTicket->user->office_email)->send(
                new UserSupportTicketNotificationMail($supportTicket, $employee)
            );

            return response()->json(['message' => 'Permission Request send Successfully'], 200);

        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

            return response()->json(['message' => 'Something went to wrong'], 401);
        }

    }

    public function getPermission(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
        ]);

        $explode_by = '.0.0.0.0.';
        try {
            $tokenArray = explode($explode_by, decrypt($request->token));
        } catch (\Exception $exception) {
            \Log::error($exception);
            return view('supportTicketMessage', ['message' => 'Token Invalid.', 'code' => '401']);
        }


        $email = $tokenArray[0];
        $supportTicketId = $tokenArray[1];
        $permissionValue = $tokenArray[2];

        $employer = Employee::wherePrivateEmail($email)->first();

        if (!$employer || !in_array($email, explode(',', env('SUPPORT_PERMISSION_EMAILS'))) || !in_array($permissionValue, ['yes', 'no'])) {

            return view('supportTicketMessage', ['message' => 'Token Invalid.', 'code' => '401']);

        }

        $supportTicket = SupportTicket::find($supportTicketId);


        if (($supportTicket->permission_status != null) || ($supportTicket->permission_seeker_feedback_date_time != null)) {
            return view('supportTicketMessage', ['message' => 'Permission already given.', 'code' => '402']);
        }

        $supportTicket->permission_status = $permissionValue;
        $supportTicket->permission_seeker_id = $employer->id;
        $supportTicket->permission_seeker_feedback_date_time = Carbon::now();
        $supportTicket->save();

        return view('supportTicketMessage', ['message' => 'Permission successfully completed.', 'code' => '200']);

    }

    public function supportTicketStatus(Request $request)
    {
        $this->validate($request, [
            'ticketId' => 'required|integer',
            'status' => 'required|string',
        ]);

        $supportTicket = SupportTicket::find($request->ticketId);
        $supportTicket->status = $request->status;

        if ($request->status == 'deny') {

            $supportTicket->deny_by = $request->auth->id;
            $supportTicket->deny_date_time = Carbon::now();
            $supportTicket->deny_reason = $request->deny_reason;


        } elseif ($request->status == 'canceled') {

            $supportTicket->canceled_by = $request->auth->id;
            $supportTicket->cancel_date_time = Carbon::now();

        } elseif ($request->status == 'solved') {

            $supportTicket->completed_by = $request->auth->id;
            $supportTicket->completed_date_time = Carbon::now();

        }

        $supportTicket->save();

        return response()->json(['message' => 'Status update successfully'], 200);

    }

    public function employeeLists()
    {
//        return  Employee::where('activestatus', '1')->get();

        $employees = Employee::with('relDesignation', 'relDepartment')->where('activestatus', '1')->get();
        return EmployeeResource::collection($employees);
    }

    public function supportTicketAssign(Request $request)
    {

        $this->validate($request, [
            'ticketId' => 'required|integer',
            'employeeId' => 'required|integer',
        ]);


        try {

            \DB::begintransaction();
            $supportTicket = SupportTicket::find($request->ticketId);

            if ($supportTicket->assign_by && $supportTicket->assign_by == 1) {

                SupportTicketAssignHistory::create([
                    'support_ticket_id' => $supportTicket->id,
                    'assign_by' => $supportTicket->assign_by,
                    'assign_to' => $supportTicket->assaign_to,
                    'assign_date_time' => $supportTicket->assign_date_time,
                ]);

            }

            $supportTicket->assaign_to = $request->employeeId;
            $supportTicket->assign_date_time = Carbon::now();
            $supportTicket->assign_by = $request->auth->id ?? '';
            $supportTicket->save();

            SupportTicketAssignHistory::create([
                'support_ticket_id' => $supportTicket->id,
                'assign_by' => $request->auth->id ?? '',
                'assign_to' => $request->employeeId,
                'assign_date_time' => Carbon::now(),
            ]);
            \DB::commit();

            return response()->json(['message' => 'Assign successfully'], 200);
        } catch (\Exception $e) {

            return response()->json(['message' => $e->getMessage()], 200);

        }


    }

    public function assignIndex(Request $request)
    {

        $this->validate($request, [
            'status' => 'required|string',
        ]);

        $auth = $request->auth->id;

        $supportTicket = SupportTicket::with('user')
            ->where([
                'assaign_to' => $request->auth->id,
                'status' => $request->status,
            ])->withCount([
                'supportTicketReplies AS totalRow' => function ($query) use ($auth) {
                    $query->select(\DB::raw('count(*)'))->whereStatus('unseen')->where('created_by', '!=', $auth);
                }
            ])->paginate(50);

        return SupportTicketResource::collection($supportTicket);
    }

    public function assignShow(Request $request, $id)
    {

        $auth = $request->auth->id;

        $supportTicket = new SupportTicketResource(SupportTicket::with(
            'user',
            'deny',
            'assign',
            'cancel',
            'completed',
            'permissionSeeker',
            'user.relDepartment',
            'supportTicketFiles',
            'user.relDesignation',
            'supportTicketReplies',
            'supportTicketReplies.user',
            'supportTicketReplies.user.relDepartment',
            'supportTicketReplies.user.relDesignation',
            'supportTicketReplies.supportTicketReplyFiles'
        )->find($id));

        $SupportTicketReply = SupportTicketReply::where([
            'support_ticket_id' => $id,
            'status' => 'unseen',
        ])->where('created_by', '!=', $auth)
            ->update([
                'status' => 'seen'
            ]);

        $employeeOthersTickets = SupportTicketResource::collection(SupportTicket::whereCreatedBy($supportTicket->user->id)->orderByDesc('id')->get());
        $data = [
            'supportTicket' => $supportTicket,
            'employeeOthersTickets' => $employeeOthersTickets,
        ];

        return $data;
    }


    public function supportTicketAssignHistory($support_ticket_id)
    {
        return SupportTicketAssignHistory::with('assignBy:id,name','assignTo:id,name')
            ->whereSupportTicketId($support_ticket_id)
            ->get();
    }
}
