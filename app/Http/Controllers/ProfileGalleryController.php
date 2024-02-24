<?php

namespace App\Http\Controllers;

use App\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProfileGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Gallery::whereEmployeeId($request->auth->id)->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:400',
            'file' => 'required|mimes:jpeg,jpg,png|max:1024', // 1024 = 1MB
        ]);

        $gallery = Gallery::whereEmployeeId($request->auth->id)->count();
        if ($gallery >= 6) {
            return response()->json(['message' => 'Maximum 6 Media Gallery Allowed'], 401);
        }

        \DB::transaction(function () use ($request) {
            $files = $request->file('file');
            $extension = $files->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $files->move(storage_path('images/profile/gallery'), $file_name);

            Gallery::create([
                'title' => $request->title,
                'employee_id' => $request->auth->id,
                'created_by' => $request->auth->id,
                'img_file' => env('APP_URL') . "images/profile/gallery/{$file_name}",
            ]);
        });

        return response()->json(['message' => 'Media Gallery Created Successfully'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        Gallery::where([
            'employee_id' => $request->auth->id,
            'id' => $id
        ])->delete();

        return response()->json(['message' => 'Media Gallery Delete Successfully'], 200);

    }
}
