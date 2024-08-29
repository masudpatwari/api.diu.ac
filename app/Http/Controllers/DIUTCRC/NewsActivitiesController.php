<?php

namespace App\Http\Controllers\DIUTCRC;

use App\Libraries\Slug;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tcrc\NewsActivities;
use App\Models\Tcrc\ResearchAndPublications;


class NewsActivitiesController extends Controller
{

    public function index()
    {
        return NewsActivities::with('user:id,name')->get();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'type' => 'required|in:news,activities,events,international,law-and-policies',
            'title' => 'required|string|max:1000',
            'description' => 'required|string',
            'file' => 'required|mimes:jpeg,jpg,png|max:4100', // 1024 = 1MB
        ]);

        \DB::transaction(function () use ($request) {
            $files = $request->file('file');
            $extension = $files->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $files->move(storage_path('images/diu_tcrc/newsActivities'), $file_name);

            NewsActivities::create([
                'type' => $request->type,
                'title' => $request->title,
                'description' => $request->description,
                'slug' => Slug::makeSlug($request->title) . '-' . time(),
                'created_by' => $request->auth->id,
                'image_path' => env('APP_URL') . "/images/diu_tcrc/newsActivities/{$file_name}",
            ]);
        });

        $message = "{$request->type} created successfully";
        return response()->json(['message' => $message], 200);
    }

    public function edit($id)
    {
        $newsActivities = NewsActivities::find($id);

        if (!$newsActivities) {
            return abort(404);
        }
        return $newsActivities;
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'type' => 'required|in:news,activities,events,international,law-and-policies',
            'title' => 'required|string|max:1000',
            'description' => 'required|string',
            'file' => 'nullable|mimes:jpeg,jpg,png|max:4100', // 1024 = 1MB
        ]);

        \DB::transaction(function () use ($request, $id) {

            $files = $request->file('file');

            $image_url = $request->image_path ?? '';

            if ($files) {
                $extension = $files->getClientOriginalExtension();
                $file_name = time() . '_' . Str::random(10) . '.' . $extension;
                $files->move(storage_path('images/diu_tcrc/newsActivities'), $file_name);

                $image_url = env('APP_URL') . "/images/diu_tcrc/newsActivities/{$file_name}";
            }

            NewsActivities::find($id)->update([
                'type' => $request->type,
                'title' => $request->title,
                'description' => $request->description,
                'image_path' => $image_url,
            ]);

        });

        $message = "{$request->type} updated successfully";
        return response()->json(['message' => $message], 200);

    }

    public function destroy($id)
    {
        $newsActivities = NewsActivities::destroy($id);
        if (!$newsActivities) {
            return response()->json(['message' => 'News or Activities data not found'], 404);
        }
        return response()->json(['message' => 'Delete successfully'], 200);
    }

}
