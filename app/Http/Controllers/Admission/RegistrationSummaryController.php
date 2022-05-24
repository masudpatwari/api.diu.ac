<?php

namespace App\Http\Controllers\Admission;

use App\Rules\CheckValidDate;
use App\Traits\RmsApiTraits;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RegistrationSummaryController extends Controller
{
    use RmsApiTraits;

    public function index(Request $request)
    {
        $this->validate($request, [
            'start_date' => ['required', 'date', new CheckValidDate],
            'end_date' => ['required', 'date', new CheckValidDate],
        ]);

        $data = [];
        $data['start_date'] = Carbon::parse($request->start_date)->format('Y/m/d');
        $data['end_date'] =  Carbon::parse($request->end_date)->addDay()->format('Y/m/d');
//        $data['end_date'] = Carbon::parse($request->end_date)->format('Y/m/d')->addDay();

        $admissionSummeries = $this->admissionSummery($data);


        $date['start_date'] = str_replace('/', '-', $data['start_date']);
        $date['end_date'] = str_replace('/', '-', $data['end_date']);

        $admissionSummery = collect($admissionSummeries)->reject(function ($value, $key) use($date){
            return ($value->student->adm_date < $date['start_date'] || $value->student->adm_date > $date['end_date']);
        });

        return $admissionSummery->values();

//        return $admissionSummery;

    }

}

