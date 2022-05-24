<?php

namespace App\Http\Controllers\PhoneCall;

use Illuminate\Http\Request;
use App\Models\PhoneCall\PhoneCall;
use App\Http\Controllers\Controller;

class PhoneCallController extends Controller
{
    public function index()
    {
        dd('working');
    }

    public function search(Request $request, $response_key)
    {

//        $phone_call = PhoneCall::orderBy('id', 'desc')->where('response', $response_key)->first();
        $phone_call = PhoneCall::where('response', $response_key)->first();

//        dump(\log::error(print_r([$request->all(),$response_key],true)));

        if ($phone_call){
            $phone_call->response = 'BUSY';
            $phone_call->dial_at = \Carbon\Carbon::parse($request->call_time)->format('Y-m-d');
            $phone_call->save();
            return trim($phone_call->mobile_number);
        }else{

//            $phone_call = PhoneCall::orderBy('id', 'desc')->where('response','BUSY')->first();
            $phone_call = PhoneCall::where('response','BUSY')->first();

            if ($phone_call){
                $phone_call->response = 'REVISION';
                $phone_call->call_duration = '';
                $phone_call->dial_at = \Carbon\Carbon::parse($request->call_time)->format('Y-m-d');
                $phone_call->save();
                return trim($phone_call->mobile_number);
            }

        }
    }

    public function store(Request $request)
    {

//        dump(\log::error(print_r($request->all(),true)));

        $this->validate($request, [
            'mobile_number' => 'required|numeric',
            'response' => 'required',
            'comment' => 'nullable',
            'call_time' => 'required',
            'call_duration' => 'required',
            'user_input' => 'nullable',
        ]);


        $phone_call = PhoneCall::where([
            'mobile_number' => $request->mobile_number,
        ])->first();


        if ($phone_call) {

            $phone_call->response = $request->response;
            $phone_call->comment = $request->comment;
            $phone_call->call_time = \Carbon\Carbon::parse($request->call_time)->format('Y-m-d H:i:s');
            $phone_call->call_duration = $request->call_duration;  //second
            $phone_call->user_input = $request->user_input;
            $phone_call->save();
            return response()->json(['message' => 'Data Updated Successfully'], 200);
        }

        return response()->json(['message' => 'Data not found'], 401);


    }
}
