<?php

namespace App\Http\Controllers\STD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Models\STD\AttendanceData;
use App\Models\STD\AttendanceReport;
use App\Http\Resources\StudentsAttendanceReportResource;
use App\Http\Resources\StudentsAttendanceResource;
use Illuminate\Support\Facades\DB;
use Ixudra\Curl\Facades\Curl;
use Carbon\Carbon;

class StudentsiteAttendanceController extends Controller
{

	public function getCourse(Request $request)
	{
		$studentId = $request->auth->ID;


//		$studentId = 15493;
		
		$attedanceDataRow = AttendanceReport::with('relAttendanceData')
			->orderBy('id','desc')
			->where('student_id', $studentId)->first();

		if (! $attedanceDataRow) {
			return response()->json('No Attedance Found!', 400);
		}

		//getting present batch 
		$batchId = $attedanceDataRow->relAttendanceData->batch_id;
		//getting present semester 
		$semester = $attedanceDataRow->relAttendanceData->semester;

		if( $request->has('semester') ){
			$semester = $request->semester;
		}


		$courses = AttendanceData::where('batch_id', $batchId)
			->where('semester', $semester)
			->orderBy('course_name')
			->get()
			->unique('course_id');

        $data = [];
        foreach ($courses  as $key => $value) {
            $data[] = $value;
        }

		return response()->json($data, 200);

	}

    public function getCourseAttendance(Request $request, int $courseId)
    {
        $studentId = $request->auth->ID;
//		$studentId = 15493;

		
		$attedanceDataRow = AttendanceReport::with('relAttendanceData')
			->orderBy('id','desc')
			->where('student_id', $studentId)->first();

		if (! $attedanceDataRow) {
			return response()->json('No Attendance Found!', 400);
		}

		//getting present batch 
		$batchId = $attedanceDataRow->relAttendanceData->batch_id;
		//getting present semester 
		$semester = $attedanceDataRow->relAttendanceData->semester;


		if( $request->has('semester') ){
			$semester = $request->semester;
		}


		$attandanceTotalClasses = AttendanceData::where('batch_id', $batchId)
		->where('semester', $semester)
		->where('course_id', $courseId)
		->get();

		//->sum('no_of_attendance');
		//dd( $attandanceTotalClasses );

		$classHappendArray = [];
		$classHappendCount = 0;

		foreach ($attandanceTotalClasses as $attandanceTotalClass) {
			$classHappendArray [$attandanceTotalClass->date]= 'A';
			$classHappendCount += $attandanceTotalClass->no_of_attendance;
		}

		$attandance = AttendanceData::
		// whereHas('relAttendanceReport')
		with(['relAttendanceReport'=> function($q) use($studentId){
			$q->where('student_id', $studentId);
		}])
		->where('batch_id', $batchId)
		->where('semester', $semester)
		->where('course_id', $courseId)
		->get();

		// dd($attandanceTotalClasses, $attandance);

		$totalAttendanceCount = 0;

		foreach ($attandance as $row) {
			if ( ! isset($row->relAttendanceReport[0])) {
				continue;
			}
			$date = $row->date;
			// dump($row, $date);
			$classHappendArray[$date] = 'P';
			$classAttandanceArray[$date] = 'P';
			$totalAttendanceCount += $row->no_of_attendance;
		}

		return response()->json([
			'classHappendCount' => $classHappendCount,
			// 'classAttandanceArray' => $classAttandanceArray,
			'totalAttendanceCount' => $totalAttendanceCount,
			'attendance'=> $classHappendArray
		], 200);

    }

}
