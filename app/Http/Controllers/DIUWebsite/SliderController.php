<?php

namespace App\Http\Controllers\DIUWebsite;

use App\Traits\DiuAcTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\DIUWebsite\Slider;

class SliderController extends Controller
{
    use DiuAcTraits;

    public function index()
    {
        return Slider::all();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'apply_url' => 'nullable|url',
            'title' => 'required|string',
            'short_description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'file' => 'required|mimes:jpeg,jpg,png|max:1024', // 1024 = 1MB
        ]);

        \DB::transaction(function () use ($request) {
            $files = $request->file('file');
            $extension = $files->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $files->move(storage_path('images/diuac/slider'), $file_name);

            Slider::create([
                'title' => $request->title,
                'short_description' => $request->short_description,
                'apply_url' => $request->apply_url,
                'status' => $request->status,
                'image_url' => env('APP_URL') . "/images/diuac/slider/{$file_name}",
            ]);

            $this->cacheClear();
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
            'apply_url' => 'nullable|url',
            'title' => 'required|string',
            'short_description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'file' => 'nullable|mimes:jpeg,jpg,png|max:1024', // 1024 = 1MB
        ]);

        \DB::transaction(function () use ($request, $id) {

            $files = $request->file('file');

            $image_url = $request->image_url ?? '';

            if ($files) {
                $extension = $files->getClientOriginalExtension();
                $file_name = time() . '_' . Str::random(10) . '.' . $extension;
                $files->move(storage_path('images/diuac/slider'), $file_name);

                $image_url = env('APP_URL') . "/images/diuac/slider/{$file_name}";
            }


            Slider::find($id)->update([
                'title' => $request->title,
                'short_description' => $request->short_description,
                'apply_url' => $request->apply_url,
                'status' => $request->status,
                'image_url' => $image_url,
            ]);

            $this->cacheClear();

        });

        return response()->json(['message' => 'Slider Updated Successfully'], 200);
    }

}
