<?php

namespace App\Http\Controllers\DIUWebsite;

use App\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DIUWebsite\WebsiteProgramBasicInfo;

class ProgramsDataController extends Controller
{
    public function show($website_program_id)
    {
        $websiteProgramBasicInfo = WebsiteProgramBasicInfo::whereWebsiteProgramId($website_program_id)->first();

        if (!$websiteProgramBasicInfo) {
            return null;
        }

        return $websiteProgramBasicInfo;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'website_program_id' => 'required|integer',
            'introduction' => 'required|string',
            'mission' => 'required|string',
            'vission' => 'required|string',
            'department_head_speach' => 'required|string',
            'department_chairman_id' => 'required|integer',
        ]);

        $websiteProgramBasicInfo = WebsiteProgramBasicInfo::whereWebsiteProgramId($request->website_program_id)->first();

        if ($websiteProgramBasicInfo) {
            $websiteProgramBasicInfo->update($request->all());
            return response()->json(['message' => 'Basic info Updated Successfully'], 200);
        }

        WebsiteProgramBasicInfo::create($request->all());

        return response()->json(['message' => 'Basic info Created Successfully'], 200);
    }

    public function facultyMembers()
    {
        /*$employee = Employee::where('groups', 'like', '%' . 'faculty' . '%')
            ->select('id', 'name')
            ->get();*/

        $employee = Employee::select('id', 'name')
            ->get();

        return $employee;
    }

}
