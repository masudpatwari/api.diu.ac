<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Upazila;
use App\Http\Resources\UpazilaResource;

class UpazilaController extends Controller
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

    public function index( $district_id )
    {
        $upazila = Upazila::where('district_id', $district_id)->orderBy('id', 'asc')->get();
        if (!empty($upazila)) {
            return UpazilaResource::collection($upazila);
        }
        return response()->json(NULL, 404);
    }
}
