<?php

namespace App\Http\Controllers\CMS;

use App\Models\STD\PhotoContests;
use Illuminate\Http\Request;
use App\Models\STD\CampusAdda;
use App\Models\STD\CampusAddaTeam;
use App\Http\Controllers\Controller;


class PhotoContestController extends Controller
{
    public function index()
    {
        $photoContests = PhotoContests::with('student','student.relDepartment')->dsc()->get();

        return $photoContests;
    }


}
