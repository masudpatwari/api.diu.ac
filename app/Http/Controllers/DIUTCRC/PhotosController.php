<?php

namespace App\Http\Controllers\DIUTCRC;

use App\Models\Tcrc\Photo;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PhotosController extends Controller
{

    public function index()
    {
        return Photo::with('user:id,name')->get();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:200',
            'file' => 'required|mimes:jpeg,jpg,png|max:1024', // 1024 = 1MB
        ]);

        \DB::transaction(function () use ($request) {
            $files = $request->file('file');
            $extension = $files->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $files->move(storage_path('images/diu_tcrc/photo'), $file_name);

            Photo::create([
                'title' => $request->title,
                'image_url' => env('APP_URL') . "/images/diu_tcrc/photo/{$file_name}",
                'created_by' => $request->auth->id,
            ]);
        });

        return response()->json(['message' => 'Photo Created Successfully'], 200);
    }

    public function edit($id)
    {
        $photo = Photo::find($id);

        return $photo ?? abort(404);

    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|string|max:200',
            'file' => 'nullable|mimes:jpeg,jpg,png|max:1024', // 1024 = 1MB
        ]);

        \DB::transaction(function () use ($request, $id) {

            $files = $request->file('file');

            $image_url = $request->image_path ?? '';

            if ($files) {
                $extension = $files->getClientOriginalExtension();
                $file_name = time() . '_' . Str::random(10) . '.' . $extension;
                $files->move(storage_path('images/diu_tcrc/photo'), $file_name);

                $image_url = env('APP_URL') . "/images/diu_tcrc/photo/{$file_name}";
            }

            Photo::find($id)->update([
                'title' => $request->title,
                'image_url' => $image_url,
            ]);

        });

        return response()->json(['message' => 'Photo Updated Successfully'], 200);
    }

    public function destroy($id)
    {

        $photo = Photo::destroy($id);

        if (!$photo) {
            return response()->json(['message' => 'Photo data not found'], 404);
        }
        return response()->json(['message' => 'Photo delete successfully'], 200);

    }

}
