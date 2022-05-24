<?php

namespace App\Http\Controllers\GOIP;

use Illuminate\Http\Request;
use App\Models\GOIP\GoipReceive;
use App\Models\GOIP\ReceivedMessage;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReceiveMessageResource;

class ReceiveMessageController extends Controller
{
    public function receiveMessageIndex()
    {

        $goipReceive = GoipReceive::max('id') ?? 0;

        $allReceivedMessages = ReceivedMessage::with('goip.providers')->where('id', '>', $goipReceive)->get();

        $inserData = [];

        foreach ($allReceivedMessages as $row) {

            $inserData = [
                'id' => $row->id,
                'srcnum' => $row->srcnum,
                'provid' => $row->provid,
                'msg' =>  $row->msg,
                'time' => $row->time,
                'goipid' => $row->goipid,
                'goipname' => $row->goipname,
                'srcid' => $row->srcid,
                'srcname' => $row->srcname,
                'srclevel' => $row->srclevel,
                'status' => $row->status,
                'smscnum' => $row->smscnum,
                'senttime' => $row->senttime,
                'provider_number' => $row->goip->providers->prov ?? '',
            ];
            try{

               GoipReceive::create($inserData);
            }
            catch( \Exception $ex){

                $inserData['msg'] = "Unreadable Message. You May call";
                GoipReceive::create($inserData);   
            }
        }

        $receivedMessages = GoipReceive::OrderDesc()->whereNull('action_status')->paginate(1000);

        return ReceiveMessageResource::collection($receivedMessages);

    }

    public function actionStatus(Request $request)
    {
        $this->validate($request, [
            'actionStatus' => 'required|in:done,delete',
            'id' => 'required|integer',
        ]);

        $goipReceive = GoipReceive::find($request->id);
        $goipReceive->action_status = $request->actionStatus;
        $goipReceive->created_by = $request->auth->id ?? '0';
        $goipReceive->save();
        return response()->json(['msg' => 'Action Status Change Successfully'], 200);
    }

    public function receiveMessageDone()
    {
        $receivedMessages = GoipReceive::OrderDesc()->where('action_status', 'done')->paginate(1000);
        return ReceiveMessageResource::collection($receivedMessages);
    }

    public function receiveMessageDelete()
    {
        $receivedMessages = GoipReceive::OrderDesc()->where('action_status', 'delete')->paginate(1000);
        return ReceiveMessageResource::collection($receivedMessages);
    }
}
