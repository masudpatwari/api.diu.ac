<?php

namespace App\Http\Controllers\DIUTCRC;

use App\Models\Tcrc\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;


class PartnerController extends Controller
{

    public function index()
    {
        return Partner::with('user:id,name')->get();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:200',
            'url' => 'required|string|max:1000',
            'file' => 'required|mimes:jpeg,jpg,png|max:1024', // 1024 = 1MB
        ]);

        \DB::transaction(function () use ($request) {
            $files = $request->file('file');
            $extension = $files->getClientOriginalExtension();
            $file_name = time() . '_' . Str::random(10) . '.' . $extension;
            $files->move(storage_path('images/diu_tcrc/partner'), $file_name);

            Partner::create([
                'title' => $request->title,
                'url' => $request->url,
                'image_path' => env('APP_URL') . "/images/diu_tcrc/partner/{$file_name}",
                'created_by' => $request->auth->id,
            ]);
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
            'title' => 'required|string|max:200',
            'url' => 'required|string|max:1000',
            'file' => 'nullable|mimes:jpeg,jpg,png|max:1024', // 1024 = 1MB
        ]);

        \DB::transaction(function () use ($request, $id) {

            $files = $request->file('file');

            $image_url = $request->image_path ?? '';

            if ($files) {
                $extension = $files->getClientOriginalExtension();
                $file_name = time() . '_' . Str::random(10) . '.' . $extension;
                $files->move(storage_path('images/diu_tcrc/partner'), $file_name);

                $image_url = env('APP_URL') . "/images/diu_tcrc/partner/{$file_name}";
            }

            Partner::find($id)->update([
                'title' => $request->title,
                'url' => $request->url,
                'image_path' => $image_url,
            ]);

        });

        return response()->json(['message' => 'Partner Updated Successfully'], 200);
    }

    public function destroy($id)
    {

        $partner = Partner::destroy($id);

        if (!$partner) {
            return response()->json(['message' => 'Partner data not found'], 404);
        }
        return response()->json(['message' => 'Partner delete successfully'], 200);

    }

}
