<?php

namespace App\Http\Controllers\DIUWebsite;

use App\Models\DIUWebsite\Publication;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class PublicationController extends Controller
{
    public function index()
    {
        return Publication::all();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'status' => 'required|in:active,inactive',
            'file' => 'required|mimes:doc,docx,pdf,jpeg,jpg,png|max:10240', // 10240 = 10MB
        ]);

        \DB::transaction(function () use ($request) {

            $files = $request->file('file');
            $extension = $files->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $files->move(storage_path('images/diuac/publication'), $file_name);
            $image_url = env('APP_URL') . "/images/diuac/publication/{$file_name}";

            Publication::create([
                'title' => $request->title,
                'status' => $request->status,
                'image_url' => $image_url,
            ]);
        });

        return response()->json(['message' => 'Publication Created Successfully'], 200);
    }

    public function edit($id)
    {
        $publication = Publication::find($id);

        if (!$publication) {
            return abort(404);
        }
        return $publication;
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'status' => 'required|in:active,inactive',
            'file' => 'nullable|mimes:doc,docx,pdf,jpeg,jpg,png|max:10240', // 10240 = 10MB
        ]);

        \DB::transaction(function () use ($request, $id) {

            $files = $request->file('file');

            $image_url = $request->image_url ?? '';

            if ($files) {
                $files = $request->file('file');
                $extension = $files->getClientOriginalExtension();
                $file_name = time() . '_' . Str::random(10) . '.' . $extension;
                $files->move(storage_path('images/diuac/publication'), $file_name);
                $image_url = env('APP_URL') . "/images/diuac/publication/{$file_name}";
            }


            Publication::find($id)->update([
                'title' => $request->title,
                'status' => $request->status,
                'image_url' => $image_url,
            ]);
        });

        return response()->json(['message' => 'Publication Updated Successfully'], 200);
    }

}
