<?php

namespace App\Http\Controllers\CMS;

use Illuminate\Http\Request;
use App\Models\STD\CampusAdda;
use App\Models\STD\CampusAddaTeam;
use App\Http\Controllers\Controller;


class CampusAddaController extends Controller
{
    public function index()
    {
        $campusAdda = CampusAdda::with('campus_adda_teams', 'campus_adda_teams.student', 'student')->withCount('campus_adda_teams')->get();

        return $campusAdda;
    }

    public function memberLists($campus_adda_id)
    {
        return CampusAddaTeam::with('student')->where('campus_adda_id',$campus_adda_id)->get();
    }

}
