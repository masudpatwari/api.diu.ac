<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Division;
use App\Http\Resources\DivisionResource;

class DivisionController extends Controller
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
        $division = Division::orderBy('id', 'asc')->get();
        if (!empty($division)) {
            return DivisionResource::collection($division);
        }
        return response()->json(NULL, 404);
    }
}
