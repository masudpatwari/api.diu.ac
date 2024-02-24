<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Employee;
use App\Holiday;
use App\AttendanceId;
use App\LeaveApplication;
use App\LeaveApplicationHistory;
use App\MachineAccessTime;
use App\Http\Resources\EmployeeShortDetailsResource;

trait ReportingFunctions
{
    public function getHolidaysArray($start_date, $end_date)
    {
        $holidays = Holiday::where(function($query) use ($start_date, $end_date){
            $query->where('start_date', '>=', $start_date)->where('end_date', '<=', $end_date);
        })->Orwhere(function($query) use ($start_date, $end_date){
            $query->where('start_date', '<=', $start_date)->where('end_date', '>=', $start_date);
        })->orwhere(function($query) use ($start_date, $end_date){
            $query->where('start_date', '<=', $end_date)->where('end_date', '>=', $end_date);
        })->orderBy('start_date', 'asc')->get();

        $holiday_array = [];
        foreach ($holidays as $key => $holiday) {

            $str_date = $holiday->start_date;
            $stop_date = $holiday->end_date;

            while ($str_date <= $stop_date) {
                $holiday_array[strtotime(date('Y-m-d', $str_date))] = 'holiday:'.$holiday->name;
                $str_date =  strtotime("+1 day", $str_date);
            }
        }

        return $holiday_array;

    }


    public function getLeaveArray($request, $employee_id, $start_date, $end_date)
    {
        $leaves = LeaveApplicationHistory::with(['relLeaveApplication' => function($query) use ($request, $employee_id){
            $query->where(['status' => 'Approved'])->where('employee_id', $employee_id);
        }])->where(function($query) use ($start_date, $end_date){
            $query->where('start_date', '>=', $start_date)->where('end_date', '<=', $end_date);
        })->Orwhere(function($query) use ($start_date, $end_date){
            $query->where('start_date', '<=', $start_date)->where('end_date', '>=', $start_date);
        })->orwhere(function($query) use ($start_date, $end_date){
            $query->where('start_date', '<=', $end_date)->where('end_date', '>=', $end_date);
        })->get();

        $leave_array = [];
        foreach ($leaves as $key => $leave) {
            if (!empty($leave->relLeaveApplication)) {
                $str_date = $leave->start_date;
                $stop_date = $leave->end_date;

                while ($str_date <= $stop_date) {
                    $leave_array[strtotime(date('Y-m-d', $str_date))] = 'leave:'.$leave->kindofleave;
                    $str_date =  strtotime("+1 day", $str_date);
                }
            }
        }

        return $leave_array;
    }

    public function getAttendanceCollection($employee_id, $attendance_str_date, $attendance_end_date)
    {

        $attendance_query = NULL;
        $today_end_time =  strtotime("+1 day", $attendance_str_date);
        $attendance_query = MachineAccessTime::selectRaw("MIN(employee_id) AS employee_id, MIN(datetime) AS min_attandance_time, MAX(datetime) AS max_attandance_time, MIN(day) AS day, MIN(type) AS type, MIN(start_time) AS office_start_time, MAX(end_time) AS office_end_time, MIN(time_duration) AS office_time_duration, MIN(offDay) AS off_day")->leftJoin('attendanceIds', 'machineAccessTimes.att_data_id', '=', 'attendanceIds.att_data_id')->whereBetween('datetime', [$attendance_str_date, ($today_end_time -1)])->where('employee_id', $employee_id);
        $attendance_str_date = $today_end_time;

        while ($attendance_str_date <= $attendance_end_date) {

            $today_end_time =  strtotime("+1 day", $attendance_str_date);

            $attendance_subQuery = MachineAccessTime::selectRaw("MIN(employee_id) AS employee_id, MIN(datetime) AS min_attandance_time, MAX(datetime) AS max_attandance_time, MIN(day) AS day, MIN(type) AS type, MIN(start_time) AS office_start_time, MAX(end_time) AS office_end_time, MIN(time_duration) AS office_time_duration, MIN(offDay) AS off_day")->leftJoin('attendanceIds', 'machineAccessTimes.att_data_id', '=', 'attendanceIds.att_data_id')->whereBetween('datetime', [$attendance_str_date, ($today_end_time -1)])->where('employee_id', $employee_id);

            $attendance_query = $attendance_query->unionAll($attendance_subQuery);
            $attendance_str_date =  strtotime("+1 day", $attendance_str_date);
        }

        return  $attendance_query->get();
    }

    public function getInOutLocation(array $att_data_id_array , $attendance )
    {
        $min_attandance_locationObj = MachineAccessTime::where('datetime',$attendance->min_attandance_time)->whereIn('att_data_id',$att_data_id_array)->first();
        $max_attandance_locationObj = MachineAccessTime::where('datetime',$attendance->max_attandance_time)->whereIn('att_data_id',$att_data_id_array)->first();

        $min_attandance_time_location = '';
        $max_attandance_time_location = '';

        if ($min_attandance_locationObj) {
            $min_attandance_time_location = $min_attandance_locationObj->location;
        }
        if ($max_attandance_locationObj) {
            $max_attandance_time_location = $max_attandance_locationObj->location;
        }

        return [
            'in' =>     $min_attandance_time_location,
            'out' => $max_attandance_time_location,
        ];
    }


    public function getOffdayArray( int $abs_str_date, int $abs_end_date, array $att_data_id_array)
    {
        $abs_data_objs = MachineAccessTime::selectRaw("employee_id,datetime,day,type,start_time AS office_start_time,end_time AS office_end_time, time_duration AS office_time_duration, offDay AS off_day")
            ->leftJoin('attendanceIds', 'machineAccessTimes.att_data_id', '=', 'attendanceIds.att_data_id')
            ->whereBetween('datetime', [$abs_str_date, $abs_end_date])
            ->where('machineAccessTimes.created_by','=','-1')
            ->whereIn('machineAccessTimes.att_data_id', $att_data_id_array)
            ->get();

        $abs_date_array = [];

        foreach ($abs_data_objs as $abs_data_obj) {
            $abs_date_array []= date("Y-m-d",$abs_data_obj->datetime);
        }

        return $abs_date_array;
    }

    public function generatedAttendanceArray($attendance)
    {
        $min_datetime = strtotime(date('Y-m-d', $attendance->min_attandance_time));
        $ofcentrytime = strtotime(date('H:i:s', $attendance->min_attandance_time));
        $ofcouttime = strtotime(date('H:i:s', $attendance->max_attandance_time));
        $ofcstrtime = strtotime(date('H:i:s', $attendance->office_start_time));
        $ofcendtime = strtotime(date('H:i:s', $attendance->office_end_time));

        if($attendance->type == 'offday')
        {
            $worked_have_todo = abs($ofcstrtime - $ofcendtime);
            $worked_has_done = abs($ofcentrytime - $ofcouttime);
        }

        if($attendance->type == 'fixed')
        {
            $worked_have_todo = abs($ofcstrtime - $ofcendtime);
            $worked_has_done = abs($ofcentrytime - $ofcouttime);

            $attendance_array = [
                'attendance_type' => $attendance->type,
                'office_entry_time' => date('H:i:s', $ofcentrytime),
                'office_out_time' => date('H:i:s', $ofcouttime),
                'worked_have_todo' => date('H:i:s', $worked_have_todo),
                'worked_has_done' => gmdate('H:i:s', $worked_has_done),
                'late_in_time' => ($ofcentrytime > $ofcstrtime) ? gmdate('H:i:s', abs($ofcentrytime - $ofcstrtime)) : NULL,
                'early_leave_time' => ($ofcouttime < $ofcendtime) ? gmdate('H:i:s', abs($ofcouttime - $ofcendtime)) : NULL,
                'working_diffrent' => gmdate('H:i:s', abs($worked_have_todo - $worked_has_done)),
                'working_diffrent_sign' => ($worked_have_todo > $worked_has_done) ? '-' : '+',
                'variable_worked_have_todo' => $worked_have_todo,
                'variable_worked_has_done' => $worked_has_done,
            ];
        }

        if($attendance->type == 'flexible')
        {
            $worked_have_todo = $attendance->office_time_duration;
            $worked_has_done = abs($ofcentrytime - $ofcouttime);
            $worked_has_done_diff = strtotime(date('Y-m-d', $worked_have_todo)) + $worked_has_done;

            $attendance_array = [
                'attendance_type' => $attendance->type,
                'office_entry_time' => date('H:i:s', $ofcentrytime),
                'office_out_time' => date('H:i:s', $ofcouttime),
                'worked_have_todo' => date('H:i:s', $worked_have_todo),
                'worked_has_done' => gmdate('H:i:s', $worked_has_done),
                'working_diffrent' => gmdate('H:i:s', abs($worked_have_todo - $worked_has_done_diff)),
                'working_diffrent_sign' => ($worked_have_todo > $worked_has_done_diff) ? '-' : '+',
                'variable_worked_have_todo' => $worked_have_todo,
                'variable_worked_has_done' => $worked_has_done,
                'variable_worked_has_done_diff' => $worked_has_done_diff,
            ];
        }

        if (($attendance['off_day'] == 1 || $attendance['type'] == 'offday') && ($min_datetime != $attendance->min_attandance_time))
        {
            $attendance_array = [
                'attendance_type' => $attendance->type,
                'office_entry_time' => date('H:i:s', $ofcentrytime),
                'office_out_time' => date('H:i:s', $ofcouttime),
                'worked_have_todo' => date('H:i:s', $worked_have_todo),
                'worked_has_done' => gmdate('H:i:s', $worked_has_done),
                'late_in_time' => ($ofcentrytime > $ofcstrtime) ? gmdate('H:i:s', abs($ofcentrytime - $ofcstrtime)) : NULL,
                'early_leave_time' => ($ofcouttime < $ofcendtime) ? gmdate('H:i:s', abs($ofcouttime - $ofcendtime)) : NULL,
                'working_diffrent' => gmdate('H:i:s', abs($worked_have_todo - $worked_has_done)),
                'working_diffrent_sign' => ($worked_have_todo > $worked_has_done) ? '-' : '+',
                'is_off_day' => 'offday:'.$attendance->day,
                'variable_worked_have_todo' => $worked_have_todo,
                'variable_worked_has_done' => $worked_has_done,
            ];
        }
        return $attendance_array;
    }

    public function employee_attendance_report(Request $request, $employee_id)
    {
        $start_date = strtotime($request->str_date);
        $end_date = strtotime($request->end_date);

        $att_data_id_array = AttendanceId::withTrashed()->where('employee_id',$employee_id)->get()->pluck('att_data_id')->toArray();

        // $holidays = Holiday::where(function($query) use ($start_date, $end_date){
        //     $query->where('start_date', '>=', $start_date)->where('end_date', '<=', $end_date);
        // })->Orwhere(function($query) use ($start_date, $end_date){
        //     $query->where('start_date', '<=', $start_date)->where('end_date', '>=', $start_date);
        // })->orwhere(function($query) use ($start_date, $end_date){
        //     $query->where('start_date', '<=', $end_date)->where('end_date', '>=', $end_date);
        // })->orderBy('start_date', 'asc')->get();
        //
        // $holiday_array = [];
        // foreach ($holidays as $key => $holiday) {
        //
        //     $str_date = $holiday->start_date;
        //     $stop_date = $holiday->end_date;
        //
        //     while ($str_date <= $stop_date) {
        //         $holiday_array[strtotime(date('Y-m-d', $str_date))] = 'holiday:'.$holiday->name;
        //         $str_date =  strtotime("+1 day", $str_date);
        //     }
        // }

        //
        // $leaves = LeaveApplicationHistory::with(['relLeaveApplication' => function($query) use ($request, $employee_id){
        //     $query->where(['status' => 'Approved'])->where('employee_id', $employee_id);
        // }])->where(function($query) use ($start_date, $end_date){
        //     $query->where('start_date', '>=', $start_date)->where('end_date', '<=', $end_date);
        // })->Orwhere(function($query) use ($start_date, $end_date){
        //     $query->where('start_date', '<=', $start_date)->where('end_date', '>=', $start_date);
        // })->orwhere(function($query) use ($start_date, $end_date){
        //     $query->where('start_date', '<=', $end_date)->where('end_date', '>=', $end_date);
        // })->get();
        //
        // $leave_array = [];
        // foreach ($leaves as $key => $leave) {
        //     if (!empty($leave->relLeaveApplication)) {
        //         $str_date = $leave->start_date;
        //         $stop_date = $leave->end_date;
        //
        //         while ($str_date <= $stop_date) {
        //             $leave_array[strtotime(date('Y-m-d', $str_date))] = 'leave:'.$leave->kindofleave;
        //             $str_date =  strtotime("+1 day", $str_date);
        //         }
        //     }
        // }

        $holiday_array = $this->getHolidaysArray($start_date,$end_date );

        $leave_array = $this->getLeaveArray($request, $employee_id, $start_date, $end_date);

        $attendance_str_date = $start_date;
        $attendance_end_date = $end_date;

        $attendance_query = $this->getAttendanceCollection($employee_id, $attendance_str_date, $attendance_end_date);
        //
        // $attendance_query = NULL;
        // $today_end_time =  strtotime("+1 day", $attendance_str_date);
        // $attendance_query = MachineAccessTime::selectRaw("MIN(employee_id) AS employee_id, MIN(datetime) AS min_attandance_time, MAX(datetime) AS max_attandance_time, MIN(day) AS day, MIN(type) AS type, MIN(start_time) AS office_start_time, MAX(end_time) AS office_end_time, MIN(time_duration) AS office_time_duration, MIN(offDay) AS off_day")->leftJoin('attendanceIds', 'machineAccessTimes.att_data_id', '=', 'attendanceIds.att_data_id')->whereBetween('datetime', [$attendance_str_date, ($today_end_time -1)])->where('employee_id', $employee_id)->where('machineAccessTimes.created_by','<>','-1');
        //
        // while ($attendance_str_date <= $attendance_end_date) {
        //
        //     $today_end_time =  strtotime("+1 day", $attendance_str_date);
        //
        //     $attendance_subQuery = MachineAccessTime::selectRaw("MIN(employee_id) AS employee_id, MIN(datetime) AS min_attandance_time, MAX(datetime) AS max_attandance_time, MIN(day) AS day, MIN(type) AS type, MIN(start_time) AS office_start_time, MAX(end_time) AS office_end_time, MIN(time_duration) AS office_time_duration, MIN(offDay) AS off_day")->leftJoin('attendanceIds', 'machineAccessTimes.att_data_id', '=', 'attendanceIds.att_data_id')->whereBetween('datetime', [$attendance_str_date, ($today_end_time -1)])->where('employee_id', $employee_id)->where('machineAccessTimes.created_by','<>','-1');
        //
        //     $attendance_query = $attendance_query->unionAll($attendance_subQuery);
        //     $attendance_str_date =  strtotime("+1 day", $attendance_str_date);
        // }
        // $attendance_query = $attendance_query->get();

        $worked_have_todo_array = NULL;
        $worked_has_done_array = NULL;
        $avarage_worked_has_done_per_day = NULL;
        $attendance_array = NULL;


        foreach ($attendance_query as $key => $attendance) {
            if (!empty($attendance['employee_id'])) {
                $min_datetime = strtotime(date('Y-m-d', $attendance->min_attandance_time));
                $ofcentrytime = strtotime(date('H:i:s', $attendance->min_attandance_time));
                $ofcouttime = strtotime(date('H:i:s', $attendance->max_attandance_time));
                $ofcstrtime = strtotime(date('H:i:s', $attendance->office_start_time));
                $ofcendtime = strtotime(date('H:i:s', $attendance->office_end_time));

                /*if($attendance->type == 'fixed')
                {
                    $worked_have_todo = abs($ofcstrtime - $ofcendtime);
                    $worked_has_done = abs($ofcentrytime - $ofcouttime);
                }*/
                /*if($attendance->type == 'offday')
                {
                    $worked_have_todo = abs($ofcstrtime - $ofcendtime);
                    $worked_has_done = abs($ofcentrytime - $ofcouttime);
                }*/
                /*if($attendance->type == 'flexible')
                {
                    $worked_have_todo = $attendance->office_time_duration;
                    $worked_has_done = abs($ofcentrytime - $ofcouttime);
                    $worked_has_done_diff = strtotime(date('Y-m-d', $worked_have_todo)) + $worked_has_done;
                }*/



//                if (($attendance['off_day'] == 1))
//                {
//                    return [$attendance , $min_datetime, date("Y-m-d H:i:s",$attendance->min_attandance_time)];
//                }
                if (($attendance['off_day'] == 1) && ($ofcstrtime == $ofcendtime)) {
                    $attendance_array[$min_datetime] = 'offday:'.$attendance->day;
                    continue;
                }

                $attendance_array[$min_datetime] = $this->generatedAttendanceArray($attendance);

                /*if($attendance->type == 'fixed')
                {
                    $worked_have_todo = abs($ofcstrtime - $ofcendtime);
                    $worked_has_done = abs($ofcentrytime - $ofcouttime);

                    $attendance_array[$min_datetime] = [
                        'attendance_type' => $attendance->type,
                        'office_entry_time' => date('H:i:s', $ofcentrytime),
                        'office_out_time' => date('H:i:s', $ofcouttime),
                        'worked_have_todo' => date('H:i:s', $worked_have_todo),
                        'worked_has_done' => gmdate('H:i:s', $worked_has_done),
                        'late_in_time' => ($ofcentrytime > $ofcstrtime) ? gmdate('H:i:s', abs($ofcentrytime - $ofcstrtime)) : NULL,
                        'early_leave_time' => ($ofcouttime < $ofcendtime) ? gmdate('H:i:s', abs($ofcouttime - $ofcendtime)) : NULL,
                        'working_diffrent' => gmdate('H:i:s', abs($worked_have_todo - $worked_has_done)),
                        'working_diffrent_sign' => ($worked_have_todo > $worked_has_done) ? '-' : '+',
                    ];
                }

                if($attendance->type == 'flexible')
                {
                    $worked_have_todo = $attendance->office_time_duration;
                    $worked_has_done = abs($ofcentrytime - $ofcouttime);
                    $worked_has_done_diff = strtotime(date('Y-m-d', $worked_have_todo)) + $worked_has_done;

                    $attendance_array[$min_datetime] = [
                        'attendance_type' => $attendance->type,
                        'office_entry_time' => date('H:i:s', $ofcentrytime),
                        'office_out_time' => date('H:i:s', $ofcouttime),
                        'worked_have_todo' => date('H:i:s', $worked_have_todo),
                        'worked_has_done' => gmdate('H:i:s', $worked_has_done),
                        'working_diffrent' => gmdate('H:i:s', abs($worked_have_todo - $worked_has_done_diff)),
                        'working_diffrent_sign' => ($worked_have_todo > $worked_has_done_diff) ? '-' : '+',
                    ];
                }

                if (($attendance['off_day'] == 1 || $attendance['type'] == 'offday') && ($min_datetime != $attendance->min_attandance_time))
                {
                    $attendance_array[$min_datetime] = [
                        'attendance_type' => $attendance->type,
                        'office_entry_time' => date('H:i:s', $ofcentrytime),
                        'office_out_time' => date('H:i:s', $ofcouttime),
                        'worked_have_todo' => date('H:i:s', $worked_have_todo),
                        'worked_has_done' => gmdate('H:i:s', $worked_has_done),
                        'late_in_time' => ($ofcentrytime > $ofcstrtime) ? gmdate('H:i:s', abs($ofcentrytime - $ofcstrtime)) : NULL,
                        'early_leave_time' => ($ofcouttime < $ofcendtime) ? gmdate('H:i:s', abs($ofcouttime - $ofcendtime)) : NULL,
                        'working_diffrent' => gmdate('H:i:s', abs($worked_have_todo - $worked_has_done)),
                        'working_diffrent_sign' => ($worked_have_todo > $worked_has_done) ? '-' : '+',
                        'is_off_day' => 'offday:'.$attendance->day,
                    ];
                }*/

                // $min_attandance_locationObj = MachineAccessTime::where('datetime',$attendance->min_attandance_time)->whereIn('att_data_id',$att_data_id_array)->first();
                // $max_attandance_locationObj = MachineAccessTime::where('datetime',$attendance->max_attandance_time)->whereIn('att_data_id',$att_data_id_array)->first();
                //
                // $min_attandance_time_location = '';
                // $max_attandance_time_location = '';
                //
                // if ($min_attandance_locationObj) {
                //     $min_attandance_time_location = $min_attandance_locationObj->location;
                // }
                // if ($max_attandance_locationObj) {
                //     $max_attandance_time_location = $max_attandance_locationObj->location;
                // }
                //
                // $attendance_array[$min_datetime] ['location']= [
                //     'in' =>     $min_attandance_time_location,
                //     'out' => $max_attandance_time_location,
                // ];

                $attendance_array[$min_datetime]['location'] = $this->getInOutLocation($att_data_id_array, $attendance);

                if (!empty($leave_array[$min_datetime]))
                {
                    $attendance_array[$min_datetime]['is_leave'] = $leave_array[$min_datetime];
                }
                else
                {
                    if($attendance->type == 'fixed')
                    {
                        $worked_have_todo_array[$min_datetime] = gmdate('H:i:s', $attendance_array[$min_datetime]['variable_worked_have_todo']);
                        $worked_has_done_array[$min_datetime] = gmdate('H:i:s', $attendance_array[$min_datetime]['variable_worked_has_done']);
                    }
                    if($attendance->type == 'flexible')
                    {
                        $worked_have_todo_array[$min_datetime] = date('H:i:s', $attendance_array[$min_datetime]['variable_worked_have_todo']);
                        $worked_has_done_array[$min_datetime] = gmdate('H:i:s', $attendance_array[$min_datetime]['variable_worked_has_done']);
                    }
                    if($attendance->type == 'offday')
                    {
                        $worked_have_todo_array[$min_datetime] = gmdate('H:i:s', $attendance_array[$min_datetime]['variable_worked_have_todo']);
                    }

                    
                }
            }
        }
//\Log::error($worked_has_done_array);

/*
        foreach($worked_has_done_array as $key=>$value){
            if($value=='00:00:00') unset($worked_has_done_array[$key]);
        }
//*/        
        $offday_str_date = $start_date;
        $offday_end_date = strtotime( date("Y-m-d", $end_date) ." 23:59:59");
        $offday_date_array = $this->getOffdayArray($offday_str_date, $offday_end_date, $att_data_id_array );




        $collection['attendance'] = [];
        while ($start_date <= $end_date) {
            $x = strtotime(date('Y-m-d', $start_date));


//            echo date('Y-m-d', $start_date) , $x;

            $collection['attendance'][date('Y-m-d', $start_date)] = 'Absence';

            if (array_key_exists($x, $leave_array)) {
                $collection['attendance'][date('Y-m-d', $start_date)] = $leave_array[$x];
            }

            if ( ! is_array($attendance_array) )
            {
                throw new \Exception('No Attendance Data Found:EID' . $employee_id);
            }
//            if (!empty($attendance_array)) {
                if (array_key_exists($x, $attendance_array)) {
                    $collection['attendance'][date('Y-m-d', $start_date)] = $attendance_array[$x];
                }
//            }

            if (array_key_exists($x, $holiday_array)) {
                $collection['attendance'][date('Y-m-d', $start_date)] = $holiday_array[$x];
            }
//**************************
            $start_date =  strtotime("+1 day", $start_date);
        }

        /**
         *   à¦•à§‡à¦“ à¦¯à¦¦à¦¿ à¦…à¦«à¦¡à§‡-à¦¤à§‡ à¦…à¦«à¦¿à¦¸ à¦•à¦°à§‡ à¦¤à¦¾à¦¹à¦²à§‡ à¦…à§à¦¯à¦¾à¦Ÿà§‡à¦¨à¦¡à§‡à¦¨à§à¦¸ à¦ à¦…à§à¦¯à¦¾à¦Ÿà§‡à¦¨à¦¡à§‡à¦¨à§à¦¸ à¦¡à¦¾à¦Ÿà¦¾ à¦à¦° à¦¸à¦¾à¦¥à§‡ à¦…à¦¬à¦¸à§‡à¦¨à§à¦¸ à¦“ à¦¦à§‡à¦–à¦¾à¦¬à§‡.
         */

        foreach ($offday_date_array as  $date) {
            if (isset($collection['attendance'][$date]) ) {
                if(isset($collection['attendance'][$date]['office_entry_time'] )) {
                    if ($collection['attendance'][$date]['office_entry_time'] == $collection['attendance'][$date]['office_out_time'])
//                return $collection['attendance'][$date];
                        $collection['attendance'][$date] = "offday";
                }
                else  {
                    if( isset($collection['attendance'][$date]['attendance_type'])){
                        $collection['attendance'][$date]['attendance_type']='offday';
                    }
                }

            }

        }


        $count_worked_has_done_array = is_array($worked_has_done_array) ? count($worked_has_done_array) : 0;
        $total_worked_have_todo = calculate_total_hour_minute_second($worked_have_todo_array);
        $total_worked_has_done = calculate_total_hour_minute_second($worked_has_done_array);
        $avarage_worked_has_done = per_day_worked_have_done_from_hour_minute_second($total_worked_has_done, $count_worked_has_done_array);
        $collection['total'] = [
            'total_worked_have_todo' => ($total_worked_have_todo == false) ? '0:0:0' : $total_worked_have_todo,
            'total_worked_has_done' => ($total_worked_has_done == false) ? '0:0:0' : $total_worked_has_done,
            'total_worked_day' => $count_worked_has_done_array,
            'avarage_worked_has_done_per_day' => ($avarage_worked_has_done == false) ? '0:0:0' : $avarage_worked_has_done,
        ];
        return $collection;
    }


    public function salary_report(Request $request, $employee_id)
    {
        $start_date = strtotime($request->str_date);
        $end_date = strtotime($request->end_date);

        /*$holidays = Holiday::where(function($query) use ($start_date, $end_date){
            $query->where('start_date', '>=', $start_date)->where('end_date', '<=', $end_date);
        })->Orwhere(function($query) use ($start_date, $end_date){
            $query->where('start_date', '<=', $start_date)->where('end_date', '>=', $start_date);
        })->orwhere(function($query) use ($start_date, $end_date){
            $query->where('start_date', '<=', $end_date)->where('end_date', '>=', $end_date);
        })->orderBy('start_date', 'asc')->get();

        $holiday_array = [];
        foreach ($holidays as $key => $holiday) {

            $str_date = $holiday->start_date;
            $stop_date = $holiday->end_date;

            while ($str_date <= $stop_date) {
                $holiday_array[strtotime(date('Y-m-d', $str_date))] = 'holiday:'.$holiday->name;
                $str_date =  strtotime("+1 day", $str_date);
            }
        }*/

        $holiday_array = $this->getHolidaysArray($start_date,$end_date );

        /*$leaves = LeaveApplicationHistory::with(['relLeaveApplication' => function($query) use ($request, $employee_id){
            $query->where(['status' => 'Approved'])->where('employee_id', $employee_id);
        }])->where(function($query) use ($start_date, $end_date){
            $query->where('start_date', '>=', $start_date)->where('end_date', '<=', $end_date);
        })->Orwhere(function($query) use ($start_date, $end_date){
            $query->where('start_date', '<=', $start_date)->where('end_date', '>=', $start_date);
        })->orwhere(function($query) use ($start_date, $end_date){
            $query->where('start_date', '<=', $end_date)->where('end_date', '>=', $end_date);
        })->get();

        $leave_array = [];
        foreach ($leaves as $key => $leave) {
            if (!empty($leave->relLeaveApplication)) {
                $str_date = $leave->start_date;
                $stop_date = $leave->end_date;

                while ($str_date <= $stop_date) {
                    $leave_array[strtotime(date('Y-m-d', $str_date))] = 'leave:'.$leave->kindofleave;
                    $str_date =  strtotime("+1 day", $str_date);
                }
            }
        }*/
        $leave_array = $this->getLeaveArray($request, $employee_id, $start_date, $end_date);

        $attendance_str_date = $start_date;
        $attendance_end_date = $end_date;

        /*$attendance_query = NULL;
        $today_end_time =  strtotime("+1 day", $attendance_str_date);
        $attendance_query = MachineAccessTime::selectRaw("MIN(employee_id) AS employee_id, MIN(datetime) AS min_attandance_time, MAX(datetime) AS max_attandance_time, MIN(day) AS day, MIN(type) AS type, MIN(start_time) AS office_start_time, MAX(end_time) AS office_end_time, MIN(time_duration) AS office_time_duration, MIN(offDay) AS off_day")->leftJoin('attendanceIds', 'machineAccessTimes.att_data_id', '=', 'attendanceIds.att_data_id')->whereBetween('datetime', [$attendance_str_date, ($today_end_time -1)])->where('employee_id', $employee_id);

        while ($attendance_str_date <= $attendance_end_date) {

            $today_end_time =  strtotime("+1 day", $attendance_str_date);

            $attendance_subQuery = MachineAccessTime::selectRaw("MIN(employee_id) AS employee_id, MIN(datetime) AS min_attandance_time, MAX(datetime) AS max_attandance_time, MIN(day) AS day, MIN(type) AS type, MIN(start_time) AS office_start_time, MAX(end_time) AS office_end_time, MIN(time_duration) AS office_time_duration, MIN(offDay) AS off_day")->leftJoin('attendanceIds', 'machineAccessTimes.att_data_id', '=', 'attendanceIds.att_data_id')->whereBetween('datetime', [$attendance_str_date, ($today_end_time -1)])->where('employee_id', $employee_id);

            $attendance_query = $attendance_query->unionAll($attendance_subQuery);
            $attendance_str_date =  strtotime("+1 day", $attendance_str_date);
        }
        $attendance_query = $attendance_query->get();*/
        $attendance_query = $this->getAttendanceCollection($employee_id, $attendance_str_date, $attendance_end_date);

        $worked_have_todo_array = NULL;
        $worked_has_done_array = NULL;
        $avarage_worked_has_done_per_day = NULL;
        $attendance_array = NULL;
        foreach ($attendance_query as $key => $attendance) {
            if (!empty($attendance['employee_id'])) {
                $min_datetime = strtotime(date('Y-m-d', $attendance->min_attandance_time));
                $ofcentrytime = strtotime(date('H:i:s', $attendance->min_attandance_time));
                $ofcouttime = strtotime(date('H:i:s', $attendance->max_attandance_time));
                $ofcstrtime = strtotime(date('H:i:s', $attendance->office_start_time));
                $ofcendtime = strtotime(date('H:i:s', $attendance->office_end_time));

                /*if($attendance->type == 'fixed')
                {
                    $worked_have_todo = abs($ofcstrtime - $ofcendtime);
                    $worked_has_done = abs($ofcentrytime - $ofcouttime);
                }
                if($attendance->type == 'offday')
                {
                    $worked_have_todo = abs($ofcstrtime - $ofcendtime);
                    $worked_has_done = abs($ofcentrytime - $ofcouttime);
                }
                if($attendance->type == 'flexible')
                {
                    $worked_have_todo = $attendance->office_time_duration;
                    $worked_has_done = abs($ofcentrytime - $ofcouttime);
                    $worked_has_done_diff = strtotime(date('Y-m-d', $worked_have_todo)) + $worked_has_done;
                }*/

                if (($attendance['off_day'] == 1) && ($min_datetime == $attendance->min_attandance_time)) {
                    $attendance_array[$min_datetime] = 'offday:'.$attendance->day;
                    continue;
                }

                /*if($attendance->type == 'fixed')
                {
                    $attendance_array[$min_datetime] = [
                        'attendance_type' => $attendance->type,
                        'office_entry_time' => date('H:i:s', $ofcentrytime),
                        'office_out_time' => date('H:i:s', $ofcouttime),
                        'worked_have_todo' => date('H:i:s', $worked_have_todo),
                        'worked_has_done' => gmdate('H:i:s', $worked_has_done),
                        'late_in_time' => ($ofcentrytime > $ofcstrtime) ? gmdate('H:i:s', abs($ofcentrytime - $ofcstrtime)) : NULL,
                        'early_leave_time' => ($ofcouttime < $ofcendtime) ? gmdate('H:i:s', abs($ofcouttime - $ofcendtime)) : NULL,
                        'working_diffrent' => gmdate('H:i:s', abs($worked_have_todo - $worked_has_done)),
                        'working_diffrent_sign' => ($worked_have_todo > $worked_has_done) ? '-' : '+',
                    ];
                }

                if($attendance->type == 'flexible')
                {
                    $attendance_array[$min_datetime] = [
                        'attendance_type' => $attendance->type,
                        'office_entry_time' => date('H:i:s', $ofcentrytime),
                        'office_out_time' => date('H:i:s', $ofcouttime),
                        'worked_have_todo' => date('H:i:s', $worked_have_todo),
                        'worked_has_done' => gmdate('H:i:s', $worked_has_done),
                        'working_diffrent' => gmdate('H:i:s', abs($worked_have_todo - $worked_has_done_diff)),
                        'working_diffrent_sign' => ($worked_have_todo > $worked_has_done_diff) ? '-' : '+',
                    ];
                }

                if (($attendance['off_day'] == 1) && ($min_datetime != $attendance->min_attandance_time))
                {
                    $attendance_array[$min_datetime] = [
                        'attendance_type' => $attendance->type,
                        'office_entry_time' => date('H:i:s', $ofcentrytime),
                        'office_out_time' => date('H:i:s', $ofcouttime),
                        'worked_have_todo' => date('H:i:s', $worked_have_todo),
                        'worked_has_done' => gmdate('H:i:s', $worked_has_done),
                        'late_in_time' => ($ofcentrytime > $ofcstrtime) ? gmdate('H:i:s', abs($ofcentrytime - $ofcstrtime)) : NULL,
                        'early_leave_time' => ($ofcouttime < $ofcendtime) ? gmdate('H:i:s', abs($ofcouttime - $ofcendtime)) : NULL,
                        'working_diffrent' => gmdate('H:i:s', abs($worked_have_todo - $worked_has_done)),
                        'working_diffrent_sign' => ($worked_have_todo > $worked_has_done) ? '-' : '+',
                        'is_off_day' => 'offday:'.$attendance->day,
                    ];
                }*/

                $attendance_array[$min_datetime] = $this->generatedAttendanceArray($attendance);

                if (!empty($leave_array[$min_datetime]))
                {
                    $attendance_array[$min_datetime]['is_leave'] = $leave_array[$min_datetime];
                }
                else
                {
                    if($attendance->type == 'fixed')
                    {
                        $worked_have_todo_array[$min_datetime] = gmdate('H:i:s', $attendance_array[$min_datetime]['variable_worked_have_todo']);
                        $worked_has_done_array[$min_datetime] = gmdate('H:i:s', $attendance_array[$min_datetime]['variable_worked_has_done']);
                    }
                    if($attendance->type == 'flexible')
                    {
                        $worked_have_todo_array[$min_datetime] = date('H:i:s', $attendance_array[$min_datetime]['variable_worked_have_todo']);
                        $worked_has_done_array[$min_datetime] = gmdate('H:i:s', $attendance_array[$min_datetime]['variable_worked_has_done']);
                    }
                    if($attendance->type == 'offday')
                    {
                        $worked_have_todo_array[$min_datetime] = gmdate('H:i:s', $attendance_array[$min_datetime]['variable_worked_have_todo']);
                    }

                    
                }
            }
        }

        $collection['late_in_time'] = NULL;
        $collection['early_leave_time'] = NULL;
        $collection['absence'] = NULL;
        $collection['working_diffrent'] = NULL;
        while ($start_date <= $end_date) {
            $x = strtotime(date('Y-m-d', $start_date));

            if (!empty($attendance_array)) {
                if (array_key_exists($x, $attendance_array)) {

                    if (is_array($attendance_array[$x])) {

                        if ($attendance_array[$x]['attendance_type'] == 'fixed') {
                            if (!empty($attendance_array[$x]['late_in_time'])) {
                                $collection['late_in_time'][date('Y-m-d', $start_date)] = $attendance_array[$x]['late_in_time'];
                            }

                            if (!empty($attendance_array[$x]['early_leave_time'])) {
                                $collection['early_leave_time'][date('Y-m-d', $start_date)] = $attendance_array[$x]['early_leave_time'];
                            }
                        }
                        if ($attendance_array[$x]['attendance_type'] == 'flexible') {
                            if (!empty($attendance_array[$x]['working_diffrent']) && $attendance_array[$x]['working_diffrent_sign']=='-' ) {
                                $collection['working_diffrent'][date('Y-m-d', $start_date)] = $attendance_array[$x]['working_diffrent_sign']."".$attendance_array[$x]['working_diffrent'];
                            }
                        }
                    }
                }
                else
                {
                    $collection['absence'][date('Y-m-d', $start_date)] = date('Y-m-d', $start_date);
                }
            }

            if (array_key_exists($x, $holiday_array)) {
                unset($collection['absence'][date('Y-m-d', $start_date)]);
            }
            if (array_key_exists($x, $leave_array)) {
                unset($collection['absence'][date('Y-m-d', $start_date)]);
            }

            $start_date =  strtotime("+1 day", $start_date);
        }

        $array_count_values = array_count_values($leave_array);
        $count_worked_has_done_array = is_array($worked_has_done_array) ? count($worked_has_done_array) : 0;
        $total_worked_have_todo = calculate_total_hour_minute_second($worked_have_todo_array);
        $total_worked_has_done = calculate_total_hour_minute_second($worked_has_done_array);
        $per_day_worked_have_done_from_hour_minute_second = per_day_worked_have_done_from_hour_minute_second($total_worked_has_done, $count_worked_has_done_array);


        $collection['total'] = [
            'total_worked_have_todo' => ($total_worked_have_todo == false) ? '0:0:0' : $total_worked_have_todo,
            'total_worked_has_done' => ($total_worked_has_done == false) ? '0:0:0' : $total_worked_has_done,
            'total_worked_day' => $count_worked_has_done_array,
            'avarage_worked_has_done_per_day' => ($per_day_worked_have_done_from_hour_minute_second == false) ? '0:0:0' : $per_day_worked_have_done_from_hour_minute_second,
            'total_leave_without_pay' => (!empty($array_count_values['leave:Without Pay'])) ? $array_count_values['leave:Without Pay'] : 0,
            'total_leave_with_pay' => (!empty($array_count_values['leave:Earned'])) ? $array_count_values['leave:Earned'] : 0,
        ];

        $collection['employee'] = new EmployeeShortDetailsResource(Employee::find($employee_id));
        return $collection;
    }
}
