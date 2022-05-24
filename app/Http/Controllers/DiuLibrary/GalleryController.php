<?php

namespace App\Http\Controllers\DiuLibrary;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DiuLibrary\LibraryGallery;


class GalleryController extends Controller
{
    public function index()
    {
        return LibraryGallery::all();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'status' => 'required|in:active,inactive',
            'file' => 'required|mimes:jpeg,jpg,png|max:1024', // 1024 = 1MB
        ]);

        \DB::transaction(function () use ($request) {

            $files = $request->file('file');
            $extension = $files->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $files->move(storage_path('images/diuLibrary/gallery'), $file_name);

            LibraryGallery::create([
                'title' => $request->title,
                'status' => $request->status,
                'image_url' => env('APP_URL') . "/images/diuLibrary/gallery/{$file_name}",
            ]);

        });

        return response()->json(['message' => 'Gallery Image Created Successfully'], 201);
    }

    public function edit($id)
    {
        $libraryGallery = LibraryGallery::find($id);

        if (!$libraryGallery) {
            return abort(404);
        }
        return $libraryGallery;
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'status' => 'required|in:active,inactive',
            'file' => 'nullable|mimes:jpeg,jpg,png|max:1024', // 1024 = 1MB
        ]);

        \DB::transaction(function () use ($request, $id) {

            $files = $request->file('file');

            $image_url = $request->image_url ?? '';

            if ($files) {
                $extension = $files->getClientOriginalExtension();
                $file_name = time() . '_' . Str::random(10) . '.' . $extension;
                $files->move(storage_path('images/diuLibrary/gallery'), $file_name);

                $image_url = env('APP_URL') . "/images/diuLibrary/gallery/{$file_name}";
            }

            LibraryGallery::find($id)->update([
                'title' => $request->title,
                'status' => $request->status,
                'image_url' => $image_url,
            ]);

        });

        return response()->json(['message' => 'Gallery Image Updated Successfully'], 200);
    }

    public function destroy($id)
    {
        LibraryGallery::destroy($id);
        return response()->json(['message' => 'Gallery Image Deleted Successfully'], 200);
    }

}
