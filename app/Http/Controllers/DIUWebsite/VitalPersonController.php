<?php

namespace App\Http\Controllers\DIUWebsite;

use App\Models\DIUWebsite\VitalPerson;
use App\Traits\DiuAcTraits;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VitalPersonController extends Controller
{
    use DiuAcTraits;

    public function index()
    {
        return VitalPerson::with('vitalPersonType')->typeAcending()->get();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'vital_person_type_id' => 'required|integer',
            'name' => 'required|string',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'file' => 'required|mimes:jpeg,jpg,png|max:500', // 500 = 500KB
        ]);

        try {

            \DB::transaction(function () use ($request) {

                $files = $request->file('file');
                $extension = $files->getClientOriginalExtension();
                $file_name = time() . '_' . Str::random(10) . '.' . $extension;
                $files->move(storage_path('images/diuac/vitalPersion'), $file_name);
                $image_url = env('APP_URL') . "/images/diuac/vitalPersion/{$file_name}";

                VitalPerson::create([
                    'vital_person_type_id' => $request->vital_person_type_id,
                    'name' => $request->name,
                    'title' => $request->title,
                    'description' => $request->description,
                    'image_url' => $image_url,
                    'status' => $request->status,
                ]);

                $this->cacheClear();

            });

            return response()->json(['message' => 'Vital Person Created Successfully'], 200);

        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return response()->json(['message' => 'Something went to wrong'], 401);
        }
    }

    public function edit($id)
    {
        $vitalPerson = VitalPerson::find($id);

        if (!$vitalPerson) {
            abort(404);
        }

        return $vitalPerson;
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'vital_person_type_id' => 'required|integer',
            'name' => 'required|string',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'file' => 'nullable|mimes:jpeg,jpg,png|max:500', // 500 = 500KB
        ]);

        try {

            \DB::transaction(function () use ($request, $id) {

                $files = $request->file('file');
                $image_url = $request->image_url ?? '';

                if ($files) {
                    $extension = $files->getClientOriginalExtension();
                    $file_name = time() . '_' . Str::random(10) . '.' . $extension;
                    $files->move(storage_path('images/diuac/vitalPersion'), $file_name);
                    $image_url = env('APP_URL') . "/images/diuac/vitalPersion/{$file_name}";
                }

                VitalPerson::find($id)->update([
                    'vital_person_type_id' => $request->vital_person_type_id,
                    'name' => $request->name,
                    'title' => $request->title,
                    'description' => $request->description,
                    'image_url' => $image_url,
                    'status' => $request->status,
                ]);

                $this->cacheClear();

            });

            return response()->json(['message' => 'Vital Person Updated Successfully'], 200);

        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return response()->json(['message' => 'Something went to wrong'], 401);
        }
    }

}