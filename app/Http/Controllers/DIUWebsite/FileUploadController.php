<?php

namespace App\Http\Controllers\DIUWebsite;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DIUWebsite\WebsiteNoticeEventEditorFile;

class FileUploadController extends Controller
{
    public function index()
    {
        return WebsiteNoticeEventEditorFile::decending()->get();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'file.*' => 'required|mimes:jpeg,jpg,png|max:1024', // 1024 = 1MB
        ]);

        \DB::transaction(function () use ($request) {

            $files = $request->file('file');
            if ($files) {
                $data = [];

                foreach ($files as $key => $file) {
                    $extension = $file->getClientOriginalExtension();

                    $file_name = time() . '_' . Str::random(10) . '.' . $extension;

                    $file->move(storage_path('images/diuac/editorImage'), $file_name);
                    $file_url = env('APP_URL') . "/images/diuac/editorImage/{$file_name}";

                    $file_name = str_replace(['jpeg', 'jpg', 'png', 'gif', '.'], '', $file->getClientOriginalName());

                    $data[] = [
                        'file_url' => $file_url,
                        'title' => $file_name,
                        'created_by' => $request->auth->id
                    ];
                };

                WebsiteNoticeEventEditorFile::insert($data);
            }

        });

        return response()->json(['message' => 'File Upload Successfully'], 200);
    }

}