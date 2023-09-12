<?php

namespace App\Http\Controllers\Pbx;

use Illuminate\Http\Request;
use App\Models\PBX\PbxCampaign;
use App\Http\Controllers\Controller;


class CampaignController extends Controller
{
    public function index()
    {
        return PbxCampaign::all();
    }
}
