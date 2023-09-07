<?php

namespace App\Http\Controllers\CMS;

use App\Models\STD\PhotoContests;
use App\Models\STD\TalentHunt;
use Illuminate\Http\Request;
use App\Models\STD\CampusAdda;
use App\Models\STD\CampusAddaTeam;
use App\Http\Controllers\Controller;


class DiuTalentHuntController extends Controller
{
    public function index(Request $request)
    {
        $diuTalentHunt = TalentHunt::with('student', 'student.relDepartment')->whereCategory($request->category)->get();
        return $diuTalentHunt;
    }


}
