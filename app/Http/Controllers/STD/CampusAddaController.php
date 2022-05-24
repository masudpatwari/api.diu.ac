<?php

namespace App\Http\Controllers\STD;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\STD\CampusAdda;
use App\Models\STD\CampusAddaTeam;
use App\Http\Controllers\Controller;


class CampusAddaController extends Controller
{
    public function store(Request $request)
    {

        $this->validate($request,
            [
                'file.*' => ['required', 'mimes:jpeg,jpg,png', 'max:1024'], //  1MB
            ]
        );

        $campusAdda = CampusAdda::where('created_by', $request->auth->ID)->first();

        if ($campusAdda){
            return response()->json(['error' => 'Already you have Registered', 400]);
        }

        $teamMember = json_decode($request->teamMember, true);
        $files = $request->file('file');

        try {
            \DB::beginTransaction();

            $campusAdda = new CampusAdda();
            $campusAdda->created_by = $request->auth->ID;
            $campusAdda->status = 'new';
            $campusAdda->save();


            $new_file_name = [];

            foreach ($files as $key => $file) {
                $extension = $file->getClientOriginalExtension();
                $file_name = time() . '_' . Str::random(10) . '.' . $extension;
                $file->move(storage_path('images/campus_adda'), $file_name);
                $new_file_name[$key] = $file_name;
            }

            foreach ($teamMember as $key => $row) {

                $campusAddaTeam = new CampusAddaTeam();
                $campusAddaTeam->campus_adda_id = $campusAdda->id;
                $campusAddaTeam->student_id = $row['student_id'];
                $campusAddaTeam->fb_url = $row['fb_url'];
                $campusAddaTeam->activities = $row['member_activity'];
                $campusAddaTeam->image_url = 'images/campus_adda/' . $new_file_name[$key];
                $campusAddaTeam->save();
            }

            \DB::commit();
            return response()->json(['message' => 'Save successfully', 200]);

        } catch (\PDOException $e) {

            \DB::rollBack();
            return response()->json($e, 400);

        }

    }

    public function alreadyRegisteredCheck(Request $request)
    {
        $campusAdda = CampusAdda::where('created_by', $request->auth->ID)->first();

        if ($campusAdda) {
            return response()->json(['data' => '1', 200]);
        } else {
            return response()->json(['data' => '0', 200]);
        }

    }

}
