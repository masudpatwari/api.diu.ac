<?php

namespace App\Http\Controllers\DiuLibrary;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DiuLibrary\Slider;
use App\Http\Controllers\Controller;


class SliderController extends Controller
{
    public function index()
    {
        return Slider::all();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'file' => 'required|mimes:jpeg,jpg,png|max:1024', // 1024 = 1MB
        ]);

        \DB::transaction(function () use ($request) {

            $files = $request->file('file');
            $extension = $files->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $files->move(storage_path('images/diuLibrary/slider'), $file_name);

            Slider::create([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
                'image_url' => env('APP_URL') . "/images/diuLibrary/slider/{$file_name}",
            ]);

        });

        return response()->json(['message' => 'Slider Created Successfully'], 200);
    }

    public function edit($id)
    {
        $slider = Slider::find($id);

        if (!$slider) {
            return abort(404);
        }
        return $slider;
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'file' => 'nullable|mimes:jpeg,jpg,png|max:1024', // 1024 = 1MB
        ]);

        \DB::transaction(function () use ($request, $id) {

            $files = $request->file('file');

            $image_url = $request->image_url ?? '';

            if ($files) {
                $extension = $files->getClientOriginalExtension();
                $file_name = time() . '_' . Str::random(10) . '.' . $extension;
                $files->move(storage_path('images/diuLibrary/slider'), $file_name);

                $image_url = env('APP_URL') . "/images/diuLibrary/slider/{$file_name}";
            }

            Slider::find($id)->update([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
                'image_url' => $image_url,
            ]);

        });

        return response()->json(['message' => 'Slider Updated Successfully'], 200);
    }

    public function destroy($id)
    {
        Slider::destroy($id);
        return response()->json(['message' => 'Library Slider Deleted Successfully'], 200);
    }

}
