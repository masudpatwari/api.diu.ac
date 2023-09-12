<?php

namespace App\Http\Controllers\DIUIQAC;

use App\Models\Iqac\Video;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VideoController extends Controller
{

    public function index()
    {
        return Video::with('user:id,name')->get();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'nullable|string|max:300',
            'code' => 'required|string|max:100',
        ]);

        \DB::transaction(function () use ($request) {

            Video::create([
                'title' => $request->title,
                'code' => $request->code,
                'created_by' => $request->auth->id,
            ]);
        });

        return response()->json(['message' => 'Video Created Successfully'], 200);
    }

    public function edit($id)
    {
        $video = Video::find($id);
        return $video ?? abort(404);

    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'nullable|string|max:300',
            'code' => 'required|string|max:100',
        ]);

        \DB::transaction(function () use ($request, $id) {

            Video::find($id)->update([
                'title' => $request->title,
                'code' => $request->code,
            ]);

        });

        return response()->json(['message' => 'Video Updated Successfully'], 200);
    }

    public function destroy($id)
    {
        $video = Video::destroy($id);
        if (!$video) {
            return response()->json(['message' => 'Video data not found'], 404);
        }
        return response()->json(['message' => 'Video delete successfully'], 200);
    }

}
