<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\OfficeTime;
use App\Employee;
use App\Http\Resources\OfficeTimeResource;
use App\Http\Resources\OfficeTimeEditResource;
use App\Http\Resources\EmployeeShortDetailsResource;
use Illuminate\Support\Facades\DB;

class OfficeTimeController extends Controller
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
        //
    }

    public function store(Request $request)
    {
        $regexHHMMSS = 'regex:/^(0[0-9]|1[0-9]|2[0-3]|[0-9]){1}:[0-5][0-9]:[0-5][0-9]$/i';
        $regexHHMM_AMPM = 'regex:/^(0[0-9]|1[0-2]|[0-9]){1}:[0-5][0-9] ( |\+)?(AM|PM){1}( |\+)?$/i';
        $regexHHMMSSMessage = "Format must be HH:MM:SS Eg. 22:20:59";

        $this->validate($request,
            [
                'employee_id' => 'required|numeric',
                'weekly_working_hours' => 'required',
                'office_time_type_friday' => Rule::in(['fixed', 'flexible','offday']),
                'office_time_type_saturday' => Rule::in(['fixed', 'flexible','offday']),
                'office_time_type_sunday' => Rule::in(['fixed', 'flexible','offday']),
                'office_time_type_monday' => Rule::in(['fixed', 'flexible','offday']),
                'office_time_type_tuesday' => Rule::in(['fixed', 'flexible','offday']),
                'office_time_type_wednesday' => Rule::in(['fixed', 'flexible','offday']),
                'office_time_type_thursday' => Rule::in(['fixed', 'flexible','offday']),

                'office_start_time_friday' => ['required_if:office_time_type_friday,fixed', 'required_if:office_time_type_friday,offday', $regexHHMM_AMPM],
                'office_end_time_friday' => ['required_if:office_time_type_friday,fixed', 'required_if:office_time_type_friday,offday', $regexHHMM_AMPM],
                'office_time_duration_friday' => ["required_if:office_time_type_friday,flexible",$regexHHMMSS] ,

                'office_start_time_saturday' => ['required_if:office_time_type_saturday,fixed',  'required_if:office_time_type_saturday,offday', $regexHHMM_AMPM],
                'office_end_time_saturday' => ['required_if:office_time_type_saturday,fixed',  'required_if:office_time_type_saturday,offday', $regexHHMM_AMPM],
                'office_time_duration_saturday' => ['required_if:office_time_type_saturday,flexible',$regexHHMMSS] ,

                'office_start_time_sunday' => ['required_if:office_time_type_sunday,fixed',  'required_if:office_time_type_sunday,offday', $regexHHMM_AMPM],
                'office_end_time_sunday' => ['required_if:office_time_type_sunday,fixed',  'required_if:office_time_type_sunday,offday', $regexHHMM_AMPM],
                'office_time_duration_sunday' => ['required_if:office_time_type_sunday,flexible',$regexHHMMSS] ,

                'office_start_time_monday' => ['required_if:office_time_type_monday,fixed',  'required_if:office_time_type_monday,offday', $regexHHMM_AMPM],
                'office_end_time_monday' => ['required_if:office_time_type_monday,fixed',  'required_if:office_time_type_monday,offday', $regexHHMM_AMPM],
                'office_time_duration_monday' => ['required_if:office_time_type_monday,flexible',$regexHHMMSS],

                'office_start_time_tuesday' => ['required_if:office_time_type_tueday,fixed',  'required_if:office_time_type_tueday,offday', $regexHHMM_AMPM],
                'office_end_time_tuesday' => ['required_if:office_time_type_tueday,fixed',  'required_if:office_time_type_tueday,offday', $regexHHMM_AMPM],
                'office_time_duration_tuesday' => ['required_if:office_time_type_tueday,flexible',$regexHHMMSS] ,

                'office_start_time_wednesday' => ['required_if:office_time_type_wedday,fixed',  'required_if:office_time_type_wedday,offday', $regexHHMM_AMPM],
                'office_end_time_wednesday' => ['required_if:office_time_type_wedday,fixed',  'required_if:office_time_type_wedday,offday', $regexHHMM_AMPM],
                'office_time_duration_wednesday' => ['required_if:office_time_type_wedday,flexible',$regexHHMMSS] ,

                'office_start_time_thursday' => ['required_if:office_time_type_thuday,fixed',  'required_if:office_time_type_thuday,offday', $regexHHMM_AMPM],
                'office_end_time_thursday' => ['required_if:office_time_type_thuday,fixed',  'required_if:office_time_type_thuday,offday', $regexHHMM_AMPM],
                'office_time_duration_thursday' => ['required_if:office_time_type_thuday,flexible',$regexHHMMSS] ,
            ],
            [
                'office_time_duration_friday.regex'=> $regexHHMMSSMessage,
                'office_time_duration_saturday.regex'=> $regexHHMMSSMessage,
                'office_time_duration_sunday.regex'=> $regexHHMMSSMessage,
                'office_time_duration_monday.regex'=> $regexHHMMSSMessage,
                'office_time_duration_tuesday.regex'=> $regexHHMMSSMessage,
                'office_time_duration_wednesday.regex'=> $regexHHMMSSMessage,
                'office_time_duration_thursday.regex'=> $regexHHMMSSMessage
            ]
        );
        $employee_id = $request->input('employee_id');

        $ost_fri = $request->input('office_start_time_friday');
        $oet_fri = $request->input('office_end_time_friday');
        $otd_fri = $request->input('office_time_duration_friday');
        $ottype_fri = $request->input('office_time_type_friday');

        $ost_sat = $request->input('office_start_time_saturday');
        $oet_sat = $request->input('office_end_time_saturday');
        $otd_sat = $request->input('office_time_duration_saturday');
        $ottype_sat = $request->input('office_time_type_saturday');

        $ost_sun = $request->input('office_start_time_sunday');
        $oet_sun = $request->input('office_end_time_sunday');
        $otd_sun = $request->input('office_time_duration_sunday');
        $ottype_sun = $request->input('office_time_type_sunday');

        $ost_mon = $request->input('office_start_time_monday');
        $oet_mon = $request->input('office_end_time_monday');
        $otd_mon = $request->input('office_time_duration_monday');
        $ottype_mon = $request->input('office_time_type_monday');

        $ost_tue = $request->input('office_start_time_tuesday');
        $oet_tue = $request->input('office_end_time_tuesday');
        $otd_tue = $request->input('office_time_duration_tuesday');
        $ottype_tue = $request->input('office_time_type_tuesday');

        $ost_wed = $request->input('office_start_time_wednesday');
        $oet_wed = $request->input('office_end_time_wednesday');
        $otd_wed = $request->input('office_time_duration_wednesday');
        $ottype_wed = $request->input('office_time_type_wednesday');

        $ost_thu = $request->input('office_start_time_thursday');
        $oet_thu = $request->input('office_end_time_thursday');
        $otd_thu = $request->input('office_time_duration_thursday');
        $ottype_thu = $request->input('office_time_type_thursday');

        $fri_start_time = (empty($ost_fri)) ? NULL : time_to_timestamp($ost_fri);
        $fri_end_time = (empty($oet_fri)) ? NULL : time_to_timestamp($oet_fri);
        $fri_time_duration = (empty($otd_fri)) ? NULL : time_to_timestamp($otd_fri);
        $fri_is_offday = ($ottype_fri == "offday") ? 1 : 0;
        $sat_start_time = (empty($ost_sat)) ? NULL : time_to_timestamp($ost_sat);
        $sat_end_time = (empty($oet_sat)) ? NULL : time_to_timestamp($oet_sat);
        $sat_time_duration = (empty($otd_sat)) ? NULL : time_to_timestamp($otd_sat);
        $sat_is_offday = ($ottype_sat == "offday") ? 1 : 0;
        $sun_start_time = (empty($ost_sun)) ? NULL : time_to_timestamp($ost_sun);
        $sun_end_time = (empty($oet_sun)) ? NULL : time_to_timestamp($oet_sun);
        $sun_time_duration = (empty($otd_sun)) ? NULL : time_to_timestamp($otd_sun);
        $sun_is_offday = ($ottype_sun == "offday") ? 1 : 0;
        $mon_start_time = (empty($ost_mon)) ? NULL : time_to_timestamp($ost_mon);
        $mon_end_time = (empty($oet_mon)) ? NULL : time_to_timestamp($oet_mon);
        $mon_time_duration = (empty($otd_mon)) ? NULL : time_to_timestamp($otd_mon);
        $mon_is_offday = ($ottype_mon == "offday") ? 1 : 0;
        $tue_start_time = (empty($ost_tue)) ? NULL : time_to_timestamp($ost_tue);
        $tue_end_time = (empty($oet_tue)) ? NULL : time_to_timestamp($oet_tue);
        $tue_time_duration = (empty($otd_tue)) ? NULL : time_to_timestamp($otd_tue);
        $tue_is_offday = ($ottype_tue == "offday") ? 1 : 0;
        $wed_start_time = (empty($ost_wed)) ? NULL : time_to_timestamp($ost_wed);
        $wed_end_time = (empty($oet_wed)) ? NULL : time_to_timestamp($oet_wed);
        $wed_time_duration = (empty($otd_wed)) ? NULL : time_to_timestamp($otd_wed);
        $wed_is_offday = ($ottype_wed == "offday") ? 1 : 0;
        $thu_start_time = (empty($ost_thu)) ? NULL : time_to_timestamp($ost_thu);
        $thu_end_time = (empty($oet_thu)) ? NULL : time_to_timestamp($oet_thu);
        $thu_time_duration = (empty($otd_thu)) ? NULL : time_to_timestamp($otd_thu);
        $thu_is_offday = ($ottype_thu == "offday") ? 1 : 0;

        $fri_array = [
            'employee_id' => $employee_id,
            'day' => 'Friday',
            'type' => $ottype_fri,
            'start_time' => $fri_start_time,
            'end_time' => $fri_end_time,
            'time_duration' => $fri_time_duration,
            'offDay' => $fri_is_offday,
            'created_by' => $request->auth->id,
            'updated_by' => $request->auth->id,
        ];

        $sat_array = [
            'employee_id' => $employee_id,
            'day' => 'Saturday',
            'type' => $ottype_sat,
            'start_time' => $sat_start_time,
            'end_time' => $sat_end_time,
            'time_duration' => $sat_time_duration,
            'offDay' => $sat_is_offday,
            'created_by' => $request->auth->id,
            'updated_by' => $request->auth->id,
        ];

        $sun_array = [
            'employee_id' => $employee_id,
            'day' => 'Sunday',
            'type' => $ottype_sun,
            'start_time' => $sun_start_time,
            'end_time' => $sun_end_time,
            'time_duration' => $sun_time_duration,
            'offDay' => $sun_is_offday,
            'created_by' => $request->auth->id,
            'updated_by' => $request->auth->id,
        ];

        $mon_array = [
            'employee_id' => $employee_id,
            'day' => 'Monday',
            'type' => $ottype_mon,
            'start_time' => $mon_start_time,
            'end_time' => $mon_end_time,
            'time_duration' => $mon_time_duration,
            'offDay' => $mon_is_offday,
            'created_by' => $request->auth->id,
            'updated_by' => $request->auth->id,
        ];

        $tue_array = [
            'employee_id' => $employee_id,
            'day' => 'Tuesday',
            'type' => $ottype_tue,
            'start_time' => $tue_start_time,
            'end_time' => $tue_end_time,
            'time_duration' => $tue_time_duration,
            'offDay' => $tue_is_offday,
            'created_by' => $request->auth->id,
            'updated_by' => $request->auth->id,
        ];

        $wed_array = [
            'employee_id' => $employee_id,
            'day' => 'Wednesday',
            'type' => $ottype_wed,
            'start_time' => $wed_start_time,
            'end_time' => $wed_end_time,
            'time_duration' => $wed_time_duration,
            'offDay' => $wed_is_offday,
            'created_by' => $request->auth->id,
            'updated_by' => $request->auth->id,
        ];

        $thu_array = [
            'employee_id' => $employee_id,
            'day' => 'Thursday',
            'type' => $ottype_thu,
            'start_time' => $thu_start_time,
            'end_time' => $thu_end_time,
            'time_duration' => $thu_time_duration,
            'offDay' => $thu_is_offday,
            'created_by' => $request->auth->id,
            'updated_by' => $request->auth->id,
        ];

        $weekly_working_hours_array = [
            'weekly_working_hours' => $request->input('weekly_working_hours'),
        ];

        $check_exists = OfficeTime::where('employee_id', $employee_id)->exists();

        if ($check_exists) {
            try {
                DB::beginTransaction();

                $fri_replicate = OfficeTime::where(['employee_id' => $employee_id, 'day' => 'Friday'])->first();
                $fri_old = $fri_replicate->type.''.$fri_replicate->start_time.''.$fri_replicate->end_time.''.$fri_replicate->time_duration;
                $fri_new = $ottype_fri.''.$fri_start_time.''.$fri_end_time.''.$fri_time_duration;
                if ($fri_old != $fri_new) {
                    $fri_replicated = $fri_replicate->replicate();
                    $fri_replicated->deleted_by = $request->auth->id;
                    $fri_replicated->push();
                    $fri_replicated->delete();

                    unset($fri_array['employee_id']);
                    unset($fri_array['day']);
                    unset($fri_array['created_by']);
                    OfficeTime::where(['employee_id' => $employee_id, 'day' => 'Friday'])->update($fri_array);
                }


                $sat_replicate = OfficeTime::where(['employee_id' => $employee_id, 'day' => 'Saturday'])->first();
                $sat_old = $sat_replicate->type.''.$sat_replicate->start_time.''.$sat_replicate->end_time.''.$sat_replicate->time_duration;
                $sat_new = $ottype_sat.''.$sat_start_time.''.$sat_end_time.''.$sat_time_duration;
                if ($sat_old != $sat_new) {
                    $sat_replicated = $sat_replicate->replicate();
                    $sat_replicated->deleted_by = $request->auth->id;
                    $sat_replicated->push();
                    $sat_replicated->delete();

                    unset($sat_array['employee_id']);
                    unset($sat_array['day']);
                    unset($sat_array['created_by']);
                    OfficeTime::where(['employee_id' => $employee_id, 'day' => 'Saturday'])->update($sat_array);
                }


                $sun_replicate = OfficeTime::where(['employee_id' => $employee_id, 'day' => 'Sunday'])->first();
                $sun_old = $sun_replicate->type.''.$sun_replicate->start_time.''.$sun_replicate->end_time.''.$sun_replicate->time_duration;
                $sun_new = $ottype_sun.''.$sun_start_time.''.$sun_end_time.''.$sun_time_duration;
                if ($sun_old != $sun_new) {
                    $sun_replicated = $sun_replicate->replicate();
                    $sun_replicated->deleted_by = $request->auth->id;
                    $sun_replicated->push();
                    $sun_replicated->delete();

                    unset($sun_array['employee_id']);
                    unset($sun_array['day']);
                    unset($sun_array['created_by']);
                    OfficeTime::where(['employee_id' => $employee_id, 'day' => 'Sunday'])->update($sun_array);
                }


                $mon_replicate = OfficeTime::where(['employee_id' => $employee_id, 'day' => 'Monday'])->first();
                $mon_old = $mon_replicate->type.''.$mon_replicate->start_time.''.$mon_replicate->end_time.''.$mon_replicate->time_duration;
                $mon_new = $ottype_mon.''.$mon_start_time.''.$mon_end_time.''.$mon_time_duration;
                if ($mon_old != $mon_new) {
                    $mon_replicated = $mon_replicate->replicate();
                    $mon_replicated->deleted_by = $request->auth->id;
                    $mon_replicated->push();
                    $mon_replicated->delete();

                    unset($mon_array['employee_id']);
                    unset($mon_array['day']);
                    unset($mon_array['created_by']);
                    OfficeTime::where(['employee_id' => $employee_id, 'day' => 'Monday'])->update($mon_array);
                }


                $tue_replicate = OfficeTime::where(['employee_id' => $employee_id, 'day' => 'Tuesday'])->first();
                $tue_old = $tue_replicate->type.''.$tue_replicate->start_time.''.$tue_replicate->end_time.''.$tue_replicate->time_duration;
                $tue_new = $ottype_tue.''.$tue_start_time.''.$tue_end_time.''.$tue_time_duration;
                if ($tue_old != $tue_new) {
                    $tue_replicated = $tue_replicate->replicate();
                    $tue_replicated->deleted_by = $request->auth->id;
                    $tue_replicated->push();
                    $tue_replicated->delete();

                    unset($tue_array['employee_id']);
                    unset($tue_array['day']);
                    unset($tue_array['created_by']);
                    OfficeTime::where(['employee_id' => $employee_id, 'day' => 'Tuesday'])->update($tue_array);
                }


                $wed_replicate = OfficeTime::where(['employee_id' => $employee_id, 'day' => 'Wednesday'])->first();
                $wed_old = $wed_replicate->type.''.$wed_replicate->start_time.''.$wed_replicate->end_time.''.$wed_replicate->time_duration;
                $wed_new = $ottype_wed.''.$wed_start_time.''.$wed_end_time.''.$wed_time_duration;
                if ($wed_old != $wed_new) {
                    $wed_replicated = $wed_replicate->replicate();
                    $wed_replicated->deleted_by = $request->auth->id;
                    $wed_replicated->push();
                    $wed_replicated->delete();

                    unset($wed_array['employee_id']);
                    unset($wed_array['day']);
                    unset($wed_array['created_by']);
                    OfficeTime::where(['employee_id' => $employee_id, 'day' => 'Wednesday'])->update($wed_array);
                }


                $thu_replicate = OfficeTime::where(['employee_id' => $employee_id, 'day' => 'Thursday'])->first();
                $thu_old = $thu_replicate->type.''.$thu_replicate->start_time.''.$thu_replicate->end_time.''.$thu_replicate->time_duration;
                $thu_new = $ottype_thu.''.$thu_start_time.''.$thu_end_time.''.$thu_time_duration;
                if ($thu_old != $thu_new) {
                    $tue_replicated = $thu_replicate->replicate();
                    $tue_replicated->deleted_by = $request->auth->id;
                    $tue_replicated->push();
                    $tue_replicated->delete();

                    unset($tue_array['employee_id']);
                    unset($tue_array['day']);
                    unset($tue_array['created_by']);
                    OfficeTime::where(['employee_id' => $employee_id, 'day' => 'Thursday'])->update($thu_array);
                }

                Employee::where(['id' => $employee_id])->update($weekly_working_hours_array);
                DB::commit();
                return response()->json(NULL, 200);
            } catch (\PDOException $e) {
                DB::rollBack();
                return response()->json(['error' => 'Update Failed.'], 400);
            }
        }

        try {
            DB::beginTransaction();
            OfficeTime::create($fri_array);
            OfficeTime::create($sat_array);
            OfficeTime::create($sun_array);
            OfficeTime::create($mon_array);
            OfficeTime::create($tue_array);
            OfficeTime::create($wed_array);
            OfficeTime::create($thu_array);
            Employee::where(['id' => $employee_id])->update($weekly_working_hours_array);
            DB::commit();
            return response()->json(NULL, 200);
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(['error' => 'Insert Failed.'], 400);
        }
    }

    public function edit($id)
    {
        $office_times = Employee::find($id);
        if (!empty($office_times))
        {
            return response()->json(new OfficeTimeResource($office_times));
        }
        return response()->json(NULL, 404);
    }

    public function show($id)
    {
        $office_times = Employee::find($id);
        if (!empty($office_times))
        {
            return new OfficeTimeResource($office_times);
        }
        return response()->json(NULL, 404);
    }
}
