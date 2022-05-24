<?php

namespace App\Http\Controllers\DiuLibrary;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DiuLibrary\LibraryDocument;


class DocumentController extends Controller
{
    public function index()
    {
        return LibraryDocument::all();
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
            $files->move(storage_path('images/diuLibrary/document'), $file_name);

            LibraryDocument::create([
                'title' => $request->title,
                'status' => $request->status,
                'file_url' => env('APP_URL') . "/images/diuLibrary/document/{$file_name}",
            ]);

        });

        return response()->json(['message' => 'Document Created Successfully'], 201);
    }

    public function edit($id)
    {
        $libraryDocument = LibraryDocument::find($id);

        if (!$libraryDocument) {
            return abort(404);
        }
        return $libraryDocument;
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
                $files->move(storage_path('images/diuLibrary/document'), $file_name);

                $image_url = env('APP_URL') . "/images/diuLibrary/document/{$file_name}";
            }

            LibraryDocument::find($id)->update([
                'title' => $request->title,
                'status' => $request->status,
                'file_url' => $image_url,
            ]);

        });

        return response()->json(['message' => 'Document Updated Successfully'], 200);
    }

    public function destroy($id)
    {
        LibraryDocument::destroy($id);
        return response()->json(['message' => 'Document Deleted Successfully'], 200);
    }

}
