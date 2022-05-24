<?php

namespace App\Http\Controllers\DIUWebsite;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DIUWebsite\WebsiteProgramFacility;

class FacilitiesController extends Controller
{

    public function index($website_program_id)
    {
        return WebsiteProgramFacility::whereWebsiteProgramId($website_program_id)->get();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'website_program_id' => 'required|integer',
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        WebsiteProgramFacility::create($request->all());

        return response()->json(['message' => 'Facility Created Successfully'], 200);
    }

    public function edit($id)
    {
        $websiteProgramFacility = WebsiteProgramFacility::find($id);

        if ($websiteProgramFacility) {
            return $websiteProgramFacility;
        }

        return null;
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'website_program_id' => 'required|integer',
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        WebsiteProgramFacility::find($id)->update($request->all());

        return response()->json(['message' => 'Facility Updated Successfully'], 200);
    }

    public function destroy($id)
    {
        WebsiteProgramFacility::destroy($id);
        return response()->json(['message' => 'Facility Deleted Successfully'], 200);
    }

}
