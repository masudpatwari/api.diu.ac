<?php

namespace App\Http\Controllers\CMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admission\EmailProvider;
use App\Models\Admission\EmailCampaign;
use App\Models\Admission\EmailCampaignBcc;
use App\Models\Admission\EmailCampaignDetail;


class EmailController extends Controller
{
    public function index()
    {
        $emailProviders = EmailProvider::all();
        return $emailProviders;
    }

    public function store(Request $request)
    {

//        dump(\Log::error(print_r($request->all(),true)));

        $this->validate($request,
            [
                'driver' => 'required|string',
                'host' => 'required|string',
                'port' => 'required|integer',
                'encryption' => 'required|string',
                'sender_name' => 'required|email',
                'username' => 'required|string',
                'sender_email' => 'required|email|unique:intl.email_providers,sender_email',
                'password' => 'required',
                'status' => 'required',
            ]
        );
        try {

            EmailProvider::create($request->all());

            return response()->json(['message' => 'Email Provider Created Successfully'], 200);

        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

            return response()->json(['message' => 'Something went to wrong'], 401);
        }
    }

    public function edit($id)
    {
        $emailProviders = EmailProvider::find($id);

        return $emailProviders;
    }

    public function update(Request $request, $id)
    {

        $this->validate($request,
            [
                'driver' => 'required|string',
                'host' => 'required|string',
                'port' => 'required|integer',
                'encryption' => 'required|string',
                'sender_name' => 'required|email',
                'username' => 'required|string',
//                'sender_email' => 'required|email|unique:mysql.email_providers,sender_email,' . $emailProvider->id,
//                'password' => 'required',
                'status' => 'required',
            ]
        );

        try {

            $emailProvider = EmailProvider::find($id);

            $emailProvider->update($request->all());

            return response()->json(['message' => 'Email Provider Updated Successfully'], 200);

        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return response()->json(['message' => 'Something went to wrong'], 401);
        }
    }

    public function send(Request $request)
    {
//        dump(\Log::error(print_r($request->all(), true)));

        $this->validate($request,
            [
                'name' => 'required|string',
                'to_email' => 'required|email',
                'emails' => 'required',
                'subject' => 'required|string',
                'message' => 'required',
                'interval' => 'required|integer',
                'date_time' => 'required|date',
            ]
        );

        try {

            \DB::beginTransaction();

            $emailsArray = explode(',', $request->emails);
            $countEmails = count($emailsArray);

            if ($countEmails == 1) {
                return response()->json(['message' => 'Email Text Must be comma(,) separated multiple email'], 400);
            }

            if ($countEmails > 401) {
                return response()->json(['message' => 'Max 400 email supported.'], 400);
            }

            $date = strtotime($request->date_time);

            //queue available time check start
            $topTimeInQueue = EmailCampaignDetail::whereStatus('new')->max('available_at');
            if ($topTimeInQueue >= $date) {
                return response()->json(['message' => 'Email Queue already full till ' . date("Y-m-d h:i:s a", $topTimeInQueue)], 400);
            }
            //queue available time check end

            $previousDateTime = strtotime(date('Y-m-d H:i:s', strtotime('-1 day', $date)));

            $fromEmailCount = EmailCampaignDetail::whereStatus('new')
                ->whereFromEmail($request->from_email)
                ->where('available_at', '>=', $previousDateTime)
                ->get();

            if (count($fromEmailCount) > 2) {

                return response()->json(['message' => 'Daily email sending limit over.Please Try next day'], 400);

            }


            $emailCampaign = EmailCampaign::whereName($request->name)->first();

            if ($emailCampaign) {
                //email Campaign email quantity update
                $emailCampaign->count_email_account += 1;
                $emailCampaign->save();
            } else {

                //email Campaign add
                $emailCampaign = EmailCampaign::create([
                    'name' => $request->name,
                    'message' => $request->message,
                    'count_email_account' => 1,
                    'created_by' => $request->auth->id,
                ]);

            }

            // Email Campaign Detail store
            $mailCampaignDetail = EmailCampaignDetail::create([
                'email_campaign_id' => $emailCampaign->id,
                'from_email' => $request->from_email,
                'subject' => $request->subject,
                'to_email' => $request->to_email,
                'message' => $request->message,
                'available_at' => $date + $request->interval,
//                'available_at' => $date + $request->interval,
                'created_by' => $request->auth->id,
            ]);

            // Email Campaign bcc store
            $emailsArrayData = [];
            foreach ($emailsArray as $email) {
                $emailsArrayData[] = [
                    'email_campaign_detail_id' => $mailCampaignDetail->id,
                    'email' => trim($email),
                ];
            }
            EmailCampaignBcc::insert($emailsArrayData);

            \DB::commit();
            return response()->json(['message' => 'Email Campaign Created Successfully'], 200);


        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return response()->json(['message' => 'Something went to wrong'], 401);
        }

    }


    public function activeEmailProvider()
    {
        $emailProviders = EmailProvider::active()->get();

        return $emailProviders;
    }


    /*public function send(Request $request)
    {
        dump(\Log::error(print_r($request->all(), true)));

        $this->validate($request,
            [
                'name' => 'required|string|unique:intl.email_campaigns,name',
                'to_email' => 'required|email',
                'emails' => 'required',
                'subject' => 'required|string',
                'message' => 'required',
                'interval' => 'required|integer',
                'date_time' => 'required|date',
            ]
        );

        try {


            \DB::beginTransaction();

            $providerArray = EmailProvider::pluck('sender_email')->toArray();
            $providerCount = count($providerArray);
            $providerCounter = 0;

            $emailsArray = explode(',', $request->emails);

            $countEmails = count($emailsArray);

            if ($countEmails == 1) {
                return response()->json(['message' => 'Email Text Must be comma(,) separated multiple email'], 400);
            }

            if ($countEmails > 450) {
                return response()->json(['message' => 'Max 450 email supported.'], 400);
            }

            $message = $request->message;
            $interval = $request->interval;
            $date = strtotime($request->date_time);


            $topTimeInQueue = (EmailCampaignDetail::whereStatus('new')->max('available_at'));


            if ($topTimeInQueue > $date) {
                return response()->json(['message' => 'Email Queue already full till ' . date("Y-m-d H:i:s", $topTimeInQueue)], 400);
            }

            $emailsCounter = 0;

            //email Campaign add
            $emailCampaign = EmailCampaign::create([
                'name' => $request->name,
                'message' => $request->message,
                'count_email_accout' => $countEmails,
                'subject' => $request->subject,
                'created_by' => $request->auth->id,
            ]);

            $emailCampaignDetails = [];

            foreach ($emailsArray as $email) {

                if ($providerCounter > $providerCount - 1) {
                    $providerCounter = 0;
                }

                $delayTime = $date + ($interval * $emailsCounter);

                $emailCampaignDetails[] = [
                    'email_campaign_id' => $emailCampaign->id,
                    'from_email' => $providerArray[$providerCounter],
                    'subject' => $request->subject,
                    'to_email' => trim($email),
                    'message' => $request->message,
                    'available_at' => $delayTime,
                ];

                $providerCounter++;
                $emailsCounter++;

            }

            //campaign data insert
            EmailCampaignDetail::insert($emailCampaignDetails);

            \DB::commit();

            return response()->json(['message' => 'Email Campaign Created Successfully'], 200);

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return response()->json(['message' => 'Something went to wrong'], 401);
        }

    }*/

}
