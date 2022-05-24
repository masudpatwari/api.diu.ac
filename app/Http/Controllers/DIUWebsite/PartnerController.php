<?php

namespace App\Http\Controllers\DIUWebsite;

use App\Models\DIUWebsite\Partner;
use App\Traits\DiuAcTraits;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class PartnerController extends Controller
{
    use DiuAcTraits;
    public function index()
    {
        return Partner::all();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'file' => 'required|mimes:jpeg,jpg,png|max:1024', // 1024 = 1MB
        ]);

        \DB::transaction(function () use ($request) {

            $files = $request->file('file');
            $extension = $files->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $files->move(storage_path('images/diuac/partner'), $file_name);
            $image_url = env('APP_URL') . "/images/diuac/partner/{$file_name}";

            Partner::create([
                'title' => $request->title,
                'status' => $request->status,
                'image_url' => $image_url,
            ]);

            $this->cacheClear();
        });

        return response()->json(['message' => 'Partner Created Successfully'], 200);
    }

    public function edit($id)
    {
        $partner = Partner::find($id);

        if (!$partner) {
            return abort(404);
        }
        return $partner;
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'file' => 'nullable|mimes:jpeg,jpg,png|max:1024', // 1024 = 1MB
        ]);

        \DB::transaction(function () use ($request, $id) {

            $files = $request->file('file');

            $image_url = $request->image_url ?? '';

            if ($files) {
                $files = $request->file('file');
                $extension = $files->getClientOriginalExtension();
                $file_name = time() . '_' . Str::random(10) . '.' . $extension;
                $files->move(storage_path('images/diuac/partner'), $file_name);
                $image_url = env('APP_URL') . "/images/diuac/partner/{$file_name}";
            }


            Partner::find($id)->update([
                'title' => $request->title,
                'status' => $request->status,
                'image_url' => $image_url,
            ]);

            $this->cacheClear();

        });

        return response()->json(['message' => 'Partner Updated Successfully'], 200);
    }

}
