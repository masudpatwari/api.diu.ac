<?php

namespace App\Http\Controllers\DIUWebsite;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\STD\CampusAdda;
use App\Http\Controllers\Controller;
use App\Models\DIUWebsite\WebsiteProgram;

class ProgramsController extends Controller
{
    public function index()
    {
        return WebsiteProgram::orderPosition()->get();
    }

    public function show($id)
    {
        $websiteProgram = WebsiteProgram::find($id);

        if (!$websiteProgram) {
            abort(404);
        }

        return $websiteProgram;
    }

    public function programsSerial(Request $request)
    {
        $this->validate($request, [
            'fetchPrograms' => 'required|array',
        ]);

        foreach ($request->fetchPrograms as $key => $fetchProgram) {
            WebsiteProgram::find($fetchProgram['id'])->update([
                'position' => $key
            ]);
        }

    }
}
