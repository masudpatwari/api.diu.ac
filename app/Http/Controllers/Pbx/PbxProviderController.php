<?php

namespace App\Http\Controllers\Pbx;

use Illuminate\Http\Request;
use App\Models\PBX\Provider;
use App\Http\Controllers\Controller;

class PbxProviderController extends Controller
{

    public function getActiveProvider()
    {
        return Provider::active()->get();
    }

    public function getInactiveProvider()
    {
        return Provider::inActive()->get();
    }

    public function getAllProvider()
    {
        return Provider::all();
    }

    public function providerStatusChange(Request $request)
    {
        $this->validate($request,
            [
                'id'        => 'required|integer',
                'status'    => 'required|in:active,inactive',
            ]
        );

        $provider = Provider::find($request->id);

        if ($request->status == 'active') {
            $provider->is_active = 1;
        } elseif ($request->status == 'inactive') {
            $provider->is_active = 0;
        }

        $provider->save();

        return response()->json(['message' => $provider->name_or_number . ' Status change successfully.'], 200);

    }

}
