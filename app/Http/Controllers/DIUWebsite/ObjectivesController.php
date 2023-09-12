<?php

namespace App\Http\Controllers\DIUWebsite;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DIUWebsite\WebsiteProgramObjective;

class ObjectivesController extends Controller
{

    public function index($website_program_id)
    {
        return WebsiteProgramObjective::whereWebsiteProgramId($website_program_id)->get();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'website_program_id' => 'required|integer',
            'title' => 'nullable|string',
            'description' => 'required|string',
        ]);

        WebsiteProgramObjective::create($request->all());

        return response()->json(['message' => 'Objective Created Successfully'], 200);
    }

    public function edit($id)
    {
        $websiteProgramObjective = WebsiteProgramObjective::find($id);

        if ($websiteProgramObjective) {
            return $websiteProgramObjective;
        }

        return null;
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'website_program_id' => 'required|integer',
            'title' => 'nullable|string',
            'description' => 'required|string',
        ]);

        WebsiteProgramObjective::find($id)->update($request->all());

        return response()->json(['message' => 'Objective Updated Successfully'], 200);
    }

    public function destroy($id)
    {
        WebsiteProgramObjective::destroy($id);
        return response()->json(['message' => 'Objective Deleted Successfully'], 200);
    }

}
