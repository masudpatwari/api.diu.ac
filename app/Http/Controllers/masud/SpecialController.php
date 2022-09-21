<?php

namespace App\Http\Controllers\masud;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpecialController extends Controller
{

    public function local(Request $request)
    {
        $start = $request->input('start_date');
        $end = $request->input('end_date') ?? Carbon::now();

        $start_date = $this->dateFormat($start);
        $end_date = $this->dateFormat($end);


        $phone_nos = DB::connection('intl')
            ->table('local_students')
            ->where('is_admitted', 'false')
            ->when($start_date, function ($query) use($start_date){
                return $query->whereDate('created_at', '>=', $start_date);
            })
            ->when($end_date, function ($query) use($end_date){
                return $query->whereDate('created_at', '<=', $end_date);
            })
            ->pluck('mobile_no');

        return response()->json($phone_nos, 200);
    }

    private function dateFormat($date)
    {
        return Carbon::parse($date)->format('Y-m-d');
    }
}
