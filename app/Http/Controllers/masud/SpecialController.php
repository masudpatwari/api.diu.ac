<?php

namespace App\Http\Controllers\masud;

use App\Http\Controllers\Controller;
use App\Models\Exam\Questions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Exam\Settings;


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

    public function examSettings()
    {
        $data['settings'] = Settings::first()->per_ques_time ?? 10;
        $data['questions'] = Questions::get();
        return $data;
    }

    public function questionUpdate(Request $request)
    {
        \Validator::make($request->input('questions'),
        [
            '*.id'      => 'required|number',
            '*.question'   => 'nullable|string',
            '*.title'   => 'nullable|string',
            '*.sub_title'   => 'nullable|string',
        ]);

        $infos = $request->input('questions');
        $time = $request->input('time');

        try {
            foreach ($infos as $info)
            {
                Questions::find($info['id'])->update($info);
            }

            $settings = Settings::first();

            if($time) {
                $settings->update([
                    'per_ques_time' => $time
                ]);
            }

            return response('Questions updated successfully', 200);

        }catch (\Exception $exception){
            return response($exception->getMessage(), 400);
        }
    }
}
