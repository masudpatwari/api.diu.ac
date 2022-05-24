<?php

namespace App\Http\Controllers;

use App\Models\GOIP\Goip;
use App\Models\GOIP\Provider;
use App\Models\STD\ApiKey;
use App\Models\STD\AttendanceData;
use App\Models\STD\Student;
use App\Models\Tolet\ToLet;
use App\Models\Tolet\ToletRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ToLetController extends Controller
{

    public function test(Request $request)
    {
        $tolets = ToLet::where("status", "=", 1)
            ->orderBy('id', 'desc')
            ->get();


        //        $toletAll = $tolets->map(function($tolet) use($tolets){
        //            $tolet['id'] = (string)$tolet['id'];
        //            $tolet['rent'] = (string)$tolet['rent'];
        //            $tolet['available_seat'] = (string)$tolet['available_seat'];
        //            $tolet['creater_id'] = (string)$tolet['creater_id'];
        //            $tolet['phone'] = (string)$tolet['phone'];
        //            $tolet['person_per_room'] = (string)$tolet['person_per_room'];
        //            $tolet['status'] = (string)$tolet['status'];
        //            return $tolet;
        //        });

        return $tolets;
        //        return Goip::query()->update(['gsm_status' => 'LOGIN']);

        //        return Goip::all();
        return
            $deletable_ids = AttendanceData::where('employee_id', '=', '635')
            ->whereBetween('date', ['2022-03-13', '2022-04-17'])
            //            ->doesntHave('relAttendanceReport')
            ->has('relAttendanceReport')
            //            ->pluck('id');
            ->count();

        //        AttendanceData::whereIn('id', $deletable_ids)->delete();

    }


    public function store(Request $request)
    {
        $date = date('m/d/Y');
        $this->validate($request, [
            'type' => 'required',
            'gender' => 'required',
            'campus' => 'required',
            'details' => 'required',
            'address' => 'required',
            'rent' => ['required', 'numeric', 'min:0'],
            'available_seat' => ['required', 'numeric', 'min:1'],
            'available_from' => ['required', 'date', "after_or_equal:$date"],
            'bathroom_type' => 'required',
            'room_type' => 'required',
            'wifi' => 'required',
            'maid' => 'required',
            'fridge' => 'required',
            'person_per_room' => ['required', 'numeric', 'min:1', 'max:4'],
        ]);

        try {

            $data = new ToLet;
            $data->created_by = $request->created_by;
            $data->creater_id = $request->creater_id;
            $data->phone = $request->phone ?? 0124545;
            $data->email = $request->email;
            $data->type = $request->type;
            $data->gender = $request->gender;
            $data->campus = $request->campus;
            $data->details = $request->details;
            $data->address = $request->address;
            $data->rent = $request->rent;
            $data->available_seat = $request->available_seat;
            $data->available_from = $request->available_from;
            $data->bathroom_type = $request->bathroom_type;
            $data->room_type = $request->room_type;
            $data->person_per_room = $request->person_per_room;
            $data->wifi = $request->wifi;
            $data->maid = $request->maid;
            $data->fridge = $request->fridge;
            $data->status = 1;
            $data->save();
            return $data;
        } catch (\Exception $e) {

            return response([
                'status' => $e->getCode(),
                'error' => $e->getMessage()

            ], 400);
        }
    }
    public function toletPublish(Request $request)
    {
        $token = trim($request->get('token'));

        $date = date('m/d/Y');
        $this->validate($request, [
            'type' => 'required',
            'gender' => 'required',
            'campus' => 'required',
            'details' => 'required',
            'address' => 'required',
            'rent' => ['required', 'numeric', 'min:0'],
            'available_seat' => ['required', 'numeric', 'min:1'],
            'available_from' => ['required', 'date', "after_or_equal:$date"],
            'bathroom_type' => 'required',
            'room_type' => 'required',
            'wifi' => 'required',
            'maid' => 'required',
            'fridge' => 'required',
            'person_per_room' => ['required', 'numeric', 'min:1', 'max:4'],
        ]);

        if (!$token) {
            // Unauthorized response if token not there
            return response()->json([
                'error' => 'Token not provided.'
            ], 401);
        }

        try {

            $key = ApiKey::where('apiKey', $token)->withTrashed()->first();
            $user = Student::find($key->student_id);

            $data = new ToLet;
            $data->created_by = $user->NAME;
            $data->creater_id = $user->ID;
            $data->phone = $user->PHONE_NO;
            $data->email = $user->EMAIL;
            $data->type = $request->type;
            $data->gender = $request->gender;
            $data->campus = $request->campus;
            $data->details = $request->details;
            $data->address = $request->address;
            $data->rent = $request->rent;
            $data->available_seat = $request->available_seat;
            $data->available_from = $request->available_from;
            $data->bathroom_type = $request->bathroom_type;
            $data->room_type = $request->room_type;
            $data->person_per_room = $request->person_per_room;
            $data->wifi = $request->wifi;
            $data->maid = $request->maid;
            $data->fridge = $request->fridge;
            $data->status = 1;
            $data->save();
            return response(['success' => 'To-let Publish successfully'], 200);
        } catch (\Exception $e) {
            return response('error', 400);
        }
    }



    public function show()
    {
        return ToLet::where("status", "=", 1)
            ->orderBy('id', 'desc')
            ->paginate(15);
    }

    public function details($id)
    {
        return ToLet::where("id", "=", $id)->get();
    }


    public function search($item)
    {
        return ToLet::where(function ($query) use ($item) {
            $query->where('campus', 'LIKE', "%" . $item . "%")
                ->orWhere('address', 'LIKE', "%" . $item . "%");
        })->where("status", "=", 1)->get();
    }


    public function searchGender($gender)
    {

        return ToLet::where("status", "=", 1)
            ->where("gender", "=", $gender)
            ->orderBy('id', 'desc')
            ->paginate(15);
    }


    public function request(Request $request)
    {
        $this->validate($request, [

            'seat' => ['required', 'numeric'],
        ]);

        $data = new ToletRequest;
        $data->requested_by = $request->requested_by;
        $data->phone = $request->phone;
        $data->email = $request->email;
        $data->requester_id = $request->requester_id;
        $data->seat = $request->seat;
        $data->publish_id = $request->publish_id;
        $data->status = 0;
        $data->creater_id = $request->creater_id;
        $data->save();

        return "data inserted";
    }

    public function toletRequest(Request $request)
    {
        $token = trim($request->get('token'));

        $this->validate($request, [

            'seat' => ['required', 'numeric'],
            'tolet_no' => ['exists:tolet.to_lets,id']
        ]);

        $data = new ToletRequest;

        if (!$token) {
            // Unauthorized response if token not there
            return response()->json([
                'error' => 'Token not provided.'
            ], 401);
        }

        try {
            $key = ApiKey::where('apiKey', $token)->withTrashed()->first();
            $user = Student::find($key->student_id);
            $tolet = ToLet::find($request->tolet_no);

            $data->seat = $request->seat;
            $data->requested_by = $user->NAME;
            $data->phone = $user->PHONE_NO;
            $data->email = $user->EMAIL;
            $data->requester_id = $key->student_id;
            $data->publish_id = $tolet->id;
            $data->status = 0;
            $data->creater_id = $tolet->creater_id;
            $data->save();
            return response(['success' => 'To-let request created successfully'], 200);
        } catch (\Exception $e) {
            return response('error', 400);
        }
    }


    public function getRequestById(Request $request)
    {
        $token = trim($request->get('token'));

        if (!$token) {
            // Unauthorized response if token not there
            return response()->json([
                'error' => 'Token not provided.'
            ], 401);
        }

        try {
            $key = ApiKey::where('apiKey', $token)->withTrashed()->first();
            $student_id = $key->student_id;
            $tolets = ToletRequest::where("creater_id", $student_id)->orWhere("requester_id", $student_id)->get();

            if ($tolets->count() > 0) {
                $tolets[0]['student_id'] = $student_id;
            }
            return response()->json($tolets, 200);
        } catch (\Exception $e) {
            return response('error', 400);
        }
    }


    public function getrequest($id)
    {
        return ToletRequest::where("creater_id", "=", $id)->orWhere("requester_id", "=", $id)->get();
    }


    public function requestAccept(Request $request, $id)
    {

        $data = ToLet::find($id);
        $seat = $data->available_seat - $request->seat;
        return response()->json($seat, 200);
        if ($seat == 0) {
            $data->available_seat = $seat;
            $data->status = 0;
        } else {
            $data->available_seat = $seat;
        }

        $data->save();
        $req_id = $request->request_id;

        $data1 = ToletRequest::find($req_id);
        $data1->status = 1;
        $data1->save();
        return response()->json('To-let accepted successfully', 200);
    }
    public function toletAccept(Request $request, $id)
    {
        $tolet_request = ToletRequest::find($id);
        $tolet = ToLet::find($tolet_request->publish_id);
        $seat = $tolet->available_seat - $tolet_request->seat;

        if ($seat == 0) {
            $tolet->available_seat = $seat;
            $tolet->status = 0;
        } else {
            $tolet->available_seat = $seat;
        }

        $tolet->save();
        $tolet_request->status = 1;
        $tolet_request->save();
        return response()->json('To-let accepted successfully', 200);
    }



    public function requestReject(Request $request, $id)
    {

        $data = ToletRequest::find($id);
        $data->status = 2;
        $data->save();
        return response()->json('To-let rejected successfully', 200);
    }



    public function destroy(ToLet $toLet)
    {
        //
    }
}
