<?php

namespace App\Http\Controllers\DIUWebsite;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DIUWebsite\WebsiteProgramSyllabus;

class SyllabusController extends Controller
{

    public function index($website_program_id)
    {
        return WebsiteProgramSyllabus::whereWebsiteProgramId($website_program_id)->get();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'website_program_id' => 'required|integer',
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        WebsiteProgramSyllabus::create($request->all());

        return response()->json(['message' => 'Syllabus Created Successfully'], 200);
    }

    public function edit($id)
    {
        $websiteProgramSyllabus = WebsiteProgramSyllabus::find($id);

        if ($websiteProgramSyllabus) {
            return $websiteProgramSyllabus;
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

        WebsiteProgramSyllabus::find($id)->update($request->all());

        return response()->json(['message' => 'Syllabus Updated Successfully'], 200);
    }

    public function destroy($id)
    {
        WebsiteProgramSyllabus::destroy($id);
        return response()->json(['message' => 'Syllabus Deleted Successfully'], 200);
    }

}
