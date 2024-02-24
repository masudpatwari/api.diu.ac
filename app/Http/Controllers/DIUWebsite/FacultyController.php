<?php

namespace App\Http\Controllers\DIUWebsite;

use App\Traits\DiuAcTraits;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DIUWebsite\WebsiteProgramFaculty;

class FacultyController extends Controller
{
    use DiuAcTraits;

    public function show($website_program_id)
    {
        $websiteProgramFaculty = WebsiteProgramFaculty::whereWebsiteProgramId($website_program_id)->first();

        if (!$websiteProgramFaculty) {
            return null;
        }

        return $websiteProgramFaculty;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'website_program_id' => 'required|integer',
            'short_position_ids.*' => 'required|integer',
        ]);

        $websiteProgramFaculty = WebsiteProgramFaculty::whereWebsiteProgramId($request->website_program_id)->first();

        $this->cacheClear();

        if ($websiteProgramFaculty) {
            $websiteProgramFaculty->update($request->all());
            return response()->json(['message' => 'Faculty member short position updated successfully'], 200);
        }

        WebsiteProgramFaculty::create($request->all());

        return response()->json(['message' => 'Faculty member short position created successfully'], 200);
    }

}
