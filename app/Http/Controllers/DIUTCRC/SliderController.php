<?php

namespace App\Http\Controllers\DIUTCRC;

use App\Models\Tcrc\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;


class SliderController extends Controller
{

    public function index()
    {
        return Slider::with('user:id,name')->get();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'nullable|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'file' => 'required|mimes:jpeg,jpg,png|max:1024', // 1024 = 1MB
        ]);

        \DB::transaction(function () use ($request) {
            $files = $request->file('file');
            $extension = $files->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $files->move(storage_path('images/diu_tcrc/slider'), $file_name);

            Slider::create([
                'title' => $request->title,
                'short_description' => $request->short_description,
                'created_by' => $request->auth->id,
                'image_path' => env('APP_URL') . "/images/diu_tcrc/slider/{$file_name}",
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
            'title' => 'nullable|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'file' => 'nullable|mimes:jpeg,jpg,png|max:1024', // 1024 = 1MB
        ]);

        \DB::transaction(function () use ($request, $id) {

            $files = $request->file('file');

            $image_url = $request->image_path ?? '';

            if ($files) {
                $extension = $files->getClientOriginalExtension();
                $file_name = time() . '_' . Str::random(10) . '.' . $extension;
                $files->move(storage_path('images/diu_tcrc/slider'), $file_name);

                $image_url = env('APP_URL') . "/images/diu_tcrc/slider/{$file_name}";
            }


            Slider::find($id)->update([
                'title' => $request->title,
                'short_description' => $request->short_description,
                'image_path' => $image_url,
            ]);

        });

        return response()->json(['message' => 'Slider Updated Successfully'], 200);
    }

    public function destroy($id)
    {

        $slider = Slider::destroy($id);

        if (!$slider) {
            return response()->json(['message' => 'Slider data not found'], 404);
        }
        return response()->json(['message' => 'Slider delete successfully'], 200);

    }

}
