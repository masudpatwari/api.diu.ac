<?php

namespace App\Http\Controllers\DIUWebsite;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DIUWebsite\WebsiteProgramGallery;

class GalleryController extends Controller
{

    public function index($website_program_id)
    {
        return WebsiteProgramGallery::whereWebsiteProgramId($website_program_id)->get();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'website_program_id' => 'required|integer',
            'title' => 'required|string',
            'file' => 'required|mimes:jpeg,jpg,png|max:1024', // 1024 = 1MB
        ]);

        \DB::transaction(function () use ($request) {

            $files = $request->file('file');
            $extension = $files->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $files->move(storage_path('images/diuac/program_gallery'), $file_name);
            $image_url = env('APP_URL') . "/images/diuac/program_gallery/{$file_name}";

            WebsiteProgramGallery::create([
                'website_program_id' => $request->website_program_id,
                'title' => $request->title,
                'image_url' => $image_url,
            ]);
        });

        return response()->json(['message' => 'Gallery Created Successfully'], 200);
    }

    public function edit($id)
    {
        $websiteProgramGallery = WebsiteProgramGallery::find($id);

        if ($websiteProgramGallery) {
            return $websiteProgramGallery;
        }

        return null;
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'website_program_id' => 'required|integer',
            'title' => 'required|string',
            'file' => 'nullable|mimes:jpeg,jpg,png|max:1024', // 1024 = 1MB
        ]);

        \DB::transaction(function () use ($request, $id) {

            $files = $request->file('file');
            $image_url = $request->image_url ?? '';

            if ($files) {
                $extension = $files->getClientOriginalExtension();
                $file_name = time() . '_' . Str::random(10) . '.' . $extension;
                $files->move(storage_path('images/diuac/program_gallery'), $file_name);
                $image_url = env('APP_URL') . "/images/diuac/program_gallery/{$file_name}";
            }

            WebsiteProgramGallery::find($id)->update([
                'website_program_id' => $request->website_program_id,
                'title' => $request->title,
                'image_url' => $image_url,
            ]);
        });

        return response()->json(['message' => 'Gallery Updated Successfully'], 200);
    }

    public function destroy($id)
    {
        WebsiteProgramGallery::destroy($id);
        return response()->json(['message' => 'Gallery Deleted Successfully'], 200);
    }

}
