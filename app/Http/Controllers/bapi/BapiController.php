<?php

namespace App\Http\Controllers\bapi;

use App\Http\Controllers\Controller;
use App\Traits\RmsApiTraits;

class BapiController extends Controller
{
    use RmsApiTraits;

    public function index()
    {
        $bapiCache = $this->bapiCacheClear();

        if (!$bapiCache) {

            return response()->json(['error' => 'data not found'], 406);

        }

        return response()->json(['message' => 'Bapi Cache Cleaered Successfully'], 200);
    }

    
}
