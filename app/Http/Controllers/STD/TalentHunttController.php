<?php

namespace App\Http\Controllers\STD;

use App\Models\STD\TalentHunt;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class TalentHunttController extends Controller
{
    public function index(Request $request)
    {
        $talentHunt = TalentHunt::where([
            'student_id' => $request->auth->ID,
        ])->get();

        return $talentHunt;
    }

    public function store(Request $request)
    {

        $this->validate($request,
            [
                'fb_url' => 'required',
                'phone_number' => 'required|max:20',
                'category' => 'required|in:first-category,second-category',
                'category_item' => 'required',
                'image_url' => ['required', 'mimes:jpeg,jpg,png', 'max:1024'], //  1MB
                'video_url' => ['required', 'mimes:mp4,mov,ogg,qt', 'max:307200'], //  300MB
            ]
        );

        $talentHunt = TalentHunt::where([
            'student_id' => $request->auth->ID,
            'category' => $request->category
        ])->first();

        if ($talentHunt) {
            return response()->json(['error' => 'Already you have Registered this category'], 400);
        }

        try {

            \DB::transaction(function () use ($request) {

                $talentHunt = new TalentHunt();

                $talentHunt->fill($request->except('student_id', 'image_url', 'video_url'));
                $talentHunt->student_id = $request->auth->ID;

                $file = $request->file('image_url');
                $extension = $file->getClientOriginalExtension();
                $file_name = $request->auth->ID . '_' . Str::random(10) . '.' . $extension;
                $file->move(storage_path('images/talentHunt/image'), $file_name);
                $talentHunt->image_url = env('APP_URL') . 'images/talentHunt/image/' . $file_name;

                $file = $request->file('video_url');
                $extension = $file->getClientOriginalExtension();
                $file_name = $request->auth->ID . '_' . Str::random(10) . '.' . $extension;
                $file->move(storage_path('images/talentHunt/video'), $file_name);
                $talentHunt->video_url = env('APP_URL') . 'images/talentHunt/video/' . $file_name;

                $talentHunt->save();
            });

            return response()->json(['message' => 'Save successfully'], 200);

        } catch (\Exception $e) {

            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return response()->json($e, 400);

        }

    }
}
