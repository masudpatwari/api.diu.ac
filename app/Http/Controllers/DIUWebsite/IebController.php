<?php

namespace App\Http\Controllers\DIUWebsite;

use App\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DIUWebsite\WebsiteProgramIeb;

class IebController extends Controller
{
    public function show($website_program_id)
    {

        $websiteProgramIeb = WebsiteProgramIeb::whereWebsiteProgramId($website_program_id)->first();

        if (!$websiteProgramIeb) {
            return null;
        }

        return $websiteProgramIeb;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'website_program_id' => 'required|integer',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'youtube_url' => 'required',
            'status' => 'required|in:active,inactive',
        ]);

        $websiteProgramIeb = WebsiteProgramIeb::whereWebsiteProgramId($request->website_program_id)->first();

        if ($websiteProgramIeb) {
            $websiteProgramIeb->update($request->all());
            return response()->json(['message' => 'IEB membership updated successfully'], 200);
        }

        WebsiteProgramIeb::create($request->all());

        return response()->json(['message' => 'IEB membership created successfully'], 200);
    }

}
