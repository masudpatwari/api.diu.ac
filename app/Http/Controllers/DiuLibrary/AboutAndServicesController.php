<?php

namespace App\Http\Controllers\DiuLibrary;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DiuLibrary\LibraryAboutAndServices;


class AboutAndServicesController extends Controller
{
    public function index()
    {
        return LibraryAboutAndServices::all();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'type' => 'required|in:about_us,services',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        \DB::transaction(function () use ($request) {

            LibraryAboutAndServices::create($request->all());

        });

        return response()->json(['message' => 'About And Services Created Successfully'], 200);
    }

    public function edit($id)
    {
        $libraryAboutAndServices = LibraryAboutAndServices::find($id);

        if (!$libraryAboutAndServices) {
            return abort(404);
        }
        return $libraryAboutAndServices;
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'type' => 'required|in:about_us,services',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        \DB::transaction(function () use ($request, $id) {

            LibraryAboutAndServices::find($id)->update($request->all());

        });

        return response()->json(['message' => 'About And Services Updated Successfully'], 200);
    }

    public function destroy($id)
    {
        LibraryAboutAndServices::destroy($id);
        return response()->json(['message' => 'About And Services Deleted Successfully'], 200);
    }

}
