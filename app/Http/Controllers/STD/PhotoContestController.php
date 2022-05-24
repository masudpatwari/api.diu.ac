<?php

namespace App\Http\Controllers\STD;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\STD\CampusAdda;
use App\Models\STD\PhotoContests;
use App\Http\Controllers\Controller;


class PhotoContestController extends Controller
{
    public function store(Request $request)
    {

        $this->validate($request,
            [
                'fb_url' => 'required',
                'phone_number' => 'required',
                'file' => ['required', 'mimes:jpeg,jpg,png', 'max:1024'], //  1MB
            ]
        );

        $photoContests = PhotoContests::where('created_by', $request->auth->ID)->first();

        if ($photoContests) {
            return response()->json(['error' => 'Already you have Registered'], 400);
        }

        try {
            \DB::beginTransaction();

            $photoContests = new PhotoContests();
            $photoContests->fb_link = $request->fb_url;
            $photoContests->phone_number = $request->phone_number;
            $photoContests->created_by = $request->auth->ID;

            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $file_name = $request->auth->ID . '_' . Str::random(10) . '.' . $extension;
            $file->move(storage_path('images/photo_contest'), $file_name);

            $photoContests->image_url = 'images/photo_contest/' . $file_name;

            $photoContests->save();

            \DB::commit();
            return response()->json(['message' => 'Save successfully'], 200);

        } catch (\PDOException $e) {

            \DB::rollBack();
            return response()->json($e, 400);

        }

    }

    public function update(Request $request)
    {
        $this->validate($request,
            [
                'fb_url' => 'required',
                'phone_number' => 'required',
                'file' => ['nullable', 'mimes:jpeg,jpg,png', 'max:1024'], //  1MB
            ]
        );

        try {
            \DB::beginTransaction();

            $photoContests = PhotoContests::where('created_by', $request->auth->ID)->first();

            $photoContests->fb_link = $request->fb_url;
            $photoContests->phone_number = $request->phone_number;
            $photoContests->created_by = $request->auth->ID;


            if ($request->has('file')) {
                $file = $request->file('file');
                $extension = $file->getClientOriginalExtension();
                $file_name = $request->auth->ID . '_' . Str::random(10) . '.' . $extension;
                $file->move(storage_path('images/photo_contest'), $file_name);
                $photoContests->image_url = 'images/photo_contest/' . $file_name;

            }

            $photoContests->save();

            \DB::commit();
            return response()->json(['message' => 'Update successfully'], 200);

        } catch (\PDOException $e) {

            \DB::rollBack();
            return response()->json($e, 400);

        }
    }

    public function photoContestCheck(Request $request)
    {
        $photoContests = PhotoContests::whereCreatedBy($request->auth->ID)->first();

        if (!$photoContests) {
            return $photoContests;
        }

        return $photoContests;

    }

}
