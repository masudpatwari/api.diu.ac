<?php

namespace App\Http\Controllers\HMS;


use App\Http\Controllers\Controller;
use App\Models\HMS\Rent;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RentController extends Controller
{
    function index()
    {
        $rents = Rent::get();
        return  response()->json($rents);
    }

    function store(Request $request)
    {
        $data = $this->validate($request,
            [
                'bed_type'      => 'required',
                'monthly_fee'   => 'required',
                'start_date'    => 'required',
            ]);

        $data['created_by'] = $request->auth->id;

        $rent = Rent::where('bed_type', $request->bed_type)->whereNull('end_date')->first();

        if($rent)
        {
            $end_date = Carbon::createFromFormat('Y-m-d', $request->start_date)
                ->subMonth()
                ->endOfMonth()
                ->format('Y-m-d');

            $rent->update(['end_date' => $end_date]);
        }

        $rent = Rent::create($data);

        if (!empty($rent->id)) {
            return response()->json($rent, 201);
        }
        return response()->json(['error' => 'Insert Failed.'], 400);
    }

    public function show($id)
    {
        $rent = Rent::find($id);
        return  response()->json($rent);
    }

    public function update(Request $request, $id)
    {
        $data  = $this->validate($request,
            [
                'bed_type'      => 'required|string',
                'monthly_fee'   => 'required|numeric',
                'start_date'    => 'required',
            ],
            [
                'monthly_fee.required'      => 'Monthly Rent is required.',
                'monthly_fee.number'        => 'Monthly Rent must be number',
                'bed_type.required'         => 'Bed Type is required.',
                'bed_type.string'           => 'Bed Type is required.',
                'start_date.required'       => 'Effected Date is required.',
            ]
        );

        $rent = Rent::find($id);

        $data['created_by'] = $rent->created_by;
        $data['updated_by'] = $request->auth->id;

        $rent->update($data);

        if (!empty($rent->id)) {
            return response()->json($rent, 201);
        }
        return response()->json(['error' => 'Update Failed.'], 400);

    }

    public function destroy($id)
    {
        $rent = Rent::find($id);
        if (!empty($rent)) {
            if ($rent->delete()) {
                return response()->json(NULL, 204);
            }
            return response()->json(['error' => 'Delete Failed.'], 400);
        }
        return response()->json(NULL, 404);
    }
}
