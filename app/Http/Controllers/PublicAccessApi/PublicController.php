<?php

namespace App\Http\Controllers\PublicAccessApi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Faculty;
use App\Program;
use App\Http\Resources\TuitionFeeResource;

class PublicController extends Controller
{
    public function tuition_fee()
    {

        $tuition_fees = Faculty::with('relPrograms')
            ->orderBy('id', 'asc')
            ->get();

        if (!empty($tuition_fees)) {
            return TuitionFeeResource::collection($tuition_fees);
        }
        return response()->json(NULL, 404);
    }

    public function get_all_course_fee()
    {
        // Program::where('id', 23)->update(['tuition_fee' => 165000]);
        // return Program::active()->get();
        $course_fee = Program::select('name', 'short_name', 'duration', 'credit', 'semester', 'shift', 'type', 'admission_fee', 'tuition_fee')
            ->groupBy('name', 'short_name', 'duration', 'credit', 'semester', 'shift', 'type', 'admission_fee', 'tuition_fee')
            ->orderBy('type')
            ->active()
            ->get();

        if (!empty($course_fee)) {
            return response()->json($course_fee);
        }
        return response()->json(NULL, 404);
    }

    public function faculty_tuition_fee($faculty)
    {
        $tuition_fees = Faculty::where('short_name', 'like', '%' . $faculty . '%')->first();
        if (!empty($tuition_fees)) {
            return new TuitionFeeResource($tuition_fees);
        }
        return response()->json(NULL, 404);
    }

    public function international_tuition_fee()
    {
//        return Faculty::with('relPrograms')->get();
        $tuition_fees = Faculty::with(['relPrograms' => function ($query) {
        }])->orderBy('id', 'asc')->get();
        if (!empty($tuition_fees)) {
            return TuitionFeeResource::collection($tuition_fees);
        }
        return response()->json(NULL, 404);
    }

    public function international_tuition_fee_hons()
    {
//        return Faculty::with('relPrograms')->get();
        $tuition_fees = Faculty::with(['relPrograms' => function ($query) {
            $query->whereIn('shift', ['First Shift', 'Friday/Saturday'])->where('type', 'Hons');
        }])->orderBy('id', 'asc')->get();
        if (!empty($tuition_fees)) {
            return TuitionFeeResource::collection($tuition_fees);
        }
        return response()->json(NULL, 404);
    }

    public function international_faculty_tuition_fee($faculty)
    {
        $tuition_fees = Faculty::with(['relPrograms' => function ($query) {
            $query->whereIn('shift', ['Day']);
        }])->where('short_name', 'like', '%' . $faculty . '%')->first();
        if (!empty($tuition_fees)) {
            return new TuitionFeeResource($tuition_fees);
        }
        return response()->json(NULL, 404);
    }
}
