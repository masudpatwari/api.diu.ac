<?php

namespace App\Http\Controllers\DIUWebsite;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NoticeEventResource;
use App\Models\DIUWebsite\WebsiteNoticeEvent;
use App\Models\DIUWebsite\WebsiteNoticeEventFile;

class NoticeEventController extends Controller
{
    public function index(Request $request)
    {
        return NoticeEventResource::collection(WebsiteNoticeEvent::whereType($request->type)->decending()->paginate(10));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'title' => 'required|string',
            'type' => 'required|in:notice,event',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'file.*' => 'nullable|mimes:pdf,jpeg,jpg,png|max:1024', // 1024 = 1MB
        ]);

        \DB::transaction(function () use ($request) {

            $websiteNoticeEvent = WebsiteNoticeEvent::create([
                'title' => $request->title,
                'type' => $request->type,
                'slug' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
                'created_by' => $request->auth->id,
            ]);

            $files = $request->file('file');
            if ($files) {
                $data = [];

                foreach ($files as $key => $file) {
                    $extension = $file->getClientOriginalExtension();

                    $file_name = time() . '_' . Str::random(10) . '.' . $extension;

                    $file->move(storage_path('images/diuac/notice'), $file_name);
                    $file_url = env('APP_URL') . "/images/diuac/notice/{$file_name}";

                    $file_name = str_replace(['pdf', 'jpeg', 'jpg', 'png', 'gif', '.'], '', $file->getClientOriginalName());

                    $data[] = [
                        'website_notice_event_id' => $websiteNoticeEvent['id'],
                        'file_url' => $file_url,
                        'file_name' => $file_name
                    ];
                };

                WebsiteNoticeEventFile::insert($data);
            }
        });

        return response()->json(['message' => 'Notice Created Successfully'], 200);
    }

    public function edit($id)
    {
        $websiteNotice = WebsiteNoticeEvent::find($id);

        if (!$websiteNotice) {
            return abort(404);
        }
        return $websiteNotice;
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'status' => 'required|in:active,inactive',
        ]);

        WebsiteNoticeEvent::find($id)->update([
            'status' => $request->status == 'active' ? 'inactive' : 'active'
        ]);
        return response()->json(['message' => 'Status Change Successfully'], 200);
    }

    public function destroy($id)
    {
        WebsiteNoticeEvent::destroy($id);
        WebsiteNoticeEventFile::where('website_notice_event_id', $id)->delete();
        return response()->json(['message' => 'Notice Deleted Successfully'], 200);
    }

}
