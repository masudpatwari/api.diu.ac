<?php

namespace App\Http\Controllers\DIUWebsite;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DIUWebsite\VitalPersonType;

class VitalPersonTypeController extends Controller
{
    public function index()
    {
        return VitalPersonType::active()->get();
    }

}