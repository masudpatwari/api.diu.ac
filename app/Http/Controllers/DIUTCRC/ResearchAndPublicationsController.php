<?php

namespace App\Http\Controllers\DIUTCRC;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tcrc\ResearchAndPublications;


class ResearchAndPublicationsController extends Controller
{

    public function index()
    {
        return ResearchAndPublications::with('user:id,name')->get();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'type' => 'required|in:articles,research,publication,materials,press_release',
            'title' => 'required|string|max:500',
            'file' => 'required|mimes:jpeg,jpg,png,pdf|max:1024', // 1024 = 1MB
            'cover_file' => 'required_if:type,research|mimes:jpeg,jpg,png|max:1024', // 1024 = 1MB
        ]);

        \DB::transaction(function () use ($request) {
            $files = $request->file('file');
            $extension = $files->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $files->move(storage_path('images/diu_tcrc/researchAndPublications'), $file_name);

            $file_name_cover_file = null;
            if ($request->type == 'research') {
                $cover_file = $request->file('cover_file');
                $extension = $cover_file->getClientOriginalExtension();
                $file_name_cover_file = time() . '_' . Str::random(10) . '.' . $extension;
                $cover_file->move(storage_path('images/diu_tcrc/researchAndPublications'), $file_name_cover_file);
                $file_name_cover_file = env('APP_URL') . "/images/diu_tcrc/researchAndPublications/{$file_name_cover_file}";
            }


            ResearchAndPublications::create([
                'type' => $request->type,
                'title' => $request->title,
                'created_by' => $request->auth->id,
                'file_path' => env('APP_URL') . "/images/diu_tcrc/researchAndPublications/{$file_name}",
                'cover_file' => $file_name_cover_file,
            ]);
        });

        $message = "{$request->type} created successfully";
        return response()->json(['message' => $message], 200);
    }

    public function edit($id)
    {
        $researchAndPublications = ResearchAndPublications::find($id);

        if (!$researchAndPublications) {
            return abort(404);
        }
        return $researchAndPublications;
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'type' => 'required|in:articles,research,publication,materials,press_release',
            'title' => 'required|string|max:500',
            'file' => 'nullable|mimes:jpeg,jpg,png|max:1024', // 1024 = 1MB
            'cover_file' => 'nullable|mimes:jpeg,jpg,png|max:1024', // 1024 = 1MB
        ]);

        \DB::transaction(function () use ($request, $id) {

            $files = $request->file('file');
            $image_url = $request->image_path ?? '';
            if ($files) {
                $extension = $files->getClientOriginalExtension();
                $file_name = time() . '_' . Str::random(10) . '.' . $extension;
                $files->move(storage_path('images/diu_tcrc/researchAndPublications'), $file_name);

                $image_url = env('APP_URL') . "/images/diu_tcrc/researchAndPublications/{$file_name}";
            }

            if ($request->type == 'research') {
                $cover_file = $request->file('cover_file');
                $file_name_cover_file = $request->cover_image_path ?? null;

                if ($cover_file) {

                    $cover_file = $request->file('cover_file');
                    $extension = $cover_file->getClientOriginalExtension();
                    $file_name_cover_file = time() . '_' . Str::random(10) . '.' . $extension;
                    $cover_file->move(storage_path('images/diu_tcrc/researchAndPublications'), $file_name_cover_file);
                    $file_name_cover_file = env('APP_URL') . "/images/diu_tcrc/researchAndPublications/{$file_name_cover_file}";
                }
            }

            ResearchAndPublications::find($id)->update([
                'type' => $request->type,
                'title' => $request->title,
                'file_path' => $image_url,
                'cover_file' => $file_name_cover_file,
            ]);

        });

        $message = "{$request->type} updated successfully";
        return response()->json(['message' => $message], 200);

    }

    public function destroy($id)
    {
        $researchAndPublications = ResearchAndPublications::destroy($id);
        if (!$researchAndPublications) {
            return response()->json(['message' => 'Research And Publications data not found'], 404);
        }
        return response()->json(['message' => 'Delete successfully'], 200);
    }

}
