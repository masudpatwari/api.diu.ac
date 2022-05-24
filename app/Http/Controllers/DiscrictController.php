<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\District;
use App\Http\Resources\DistrictResource;

class DiscrictController extends Controller
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

    public function index( $division_id )
    {
        $district = District::where('division_id', $division_id)->orderBy('id', 'asc')->get();
        if (!empty($district)) {
            return DistrictResource::collection($district);
        }
        return response()->json(NULL, 404);
    }
}
