<?php

namespace App\Http\Controllers\DIUWebsite;


use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DIUWebsite\Convocation;
use App\Models\DIUWebsite\ConvocationImage;
use App\Models\ItSupport\SupportTicketFile;

class ConvocationController extends Controller
{
    public function index()
    {
        return Convocation::with('convoctionImages')->decending()->get();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'short_description' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'file.*' => 'required|mimes:jpeg,jpg,png|max:1024', // 1024 = 1MB
        ]);

        try {

            \DB::transaction(function () use ($request) {

                $convocation = Convocation::create([
                    'title' => $request->title,
                    'short_description' => $request->short_description,
                    'description' => $request->description,
                    'status' => $request->status,
                ]);

                $files = $request->file('file');
                $imageData = [];

                if ($files) {
                    foreach ($files as $key => $file) {
                        $extension = $file->getClientOriginalExtension();
                        $file_name = time() . '_' . Str::random(10) . '.' . $extension;
                        $file->move(storage_path('images/diuac/convocation'), $file_name);
                        $image_url = env('APP_URL') . "/images/diuac/convocation/{$file_name}";

                        $imageData[] = [
                            'image_url' => $image_url,
                            'convocation_id' => $convocation->id,
                        ];
                    }
                }

                ConvocationImage::insert($imageData);

            });

            return response()->json(['message' => 'Convocation Created Successfully'], 200);

        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return response()->json(['message' => 'Something went to wrong'], 401);
        }
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'status' => 'required|in:active,inactive',
        ]);

        Convocation::find($id)->update([
            'status' => $request->status == 'active' ? 'inactive' : 'active'
        ]);
        return response()->json(['message' => 'Status Change Successfully'], 200);
    }

    public function destroy($id)
    {
        Convocation::destroy($id);
        ConvocationImage::where('convocation_id', $id)->delete();
        return response()->json(['message' => 'Convocation Deleted Successfully'], 200);
    }

}