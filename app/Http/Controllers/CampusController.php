<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Campus;
use App\Http\Resources\CampusResource;

class CampusController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        $campus = Campus::orderBy('id', 'asc')->get();
        if (!empty($campus)) {
            return CampusResource::collection($campus);
        }
        return response()->json(NULL, 404);
    }
}
