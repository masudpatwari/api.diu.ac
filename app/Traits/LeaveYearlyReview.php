<?php

namespace App\Traits;

use App\LeaveApplication;
use Illuminate\Http\Request;
use App\LeaveApplicationHistory;
use App\Http\Resources\EmployeeShortDetailsResource;
use App\Employee;

trait LeaveYearlyReview
{
	public function leave_yearly_review( $employee_id )
	{
		$current_year_str = strtotime(date('Y-01-01'));
		$current_year_end = strtotime(date('Y-12-31'));
		$last_year_str = strtotime(date('Y-01-01', strtotime('-1 year')));
		$last_year_end = strtotime(date('Y-12-31', strtotime('-1 year')));

		$current_year_leaves_earned = LeaveApplicationHistory::with(['relLeaveApplication' => function($query) use ($employee_id){
		    $query->where(['status' => 'Approved', 'employee_id' => $employee_id]);
		}])->where(function($query) use ($current_year_str, $current_year_end){
		    $query->where('start_date', '>=', $current_year_str)->where('end_date', '<=', $current_year_end)->where('kindofleave', 'Earned');
		})->get();

		$current_year_total_earned = 0;
		if (!empty($current_year_leaves_earned)) {
		    foreach ($current_year_leaves_earned as $k => $v) {
		        if (!empty($v->relLeaveApplication)) {
		            $current_year_total_earned = ($current_year_total_earned + $v->number_of_days);
		        }
		    }
		}

		$last_year_leaves_earned = LeaveApplicationHistory::with(['relLeaveApplication' => function($query) use ($employee_id){
		    $query->where(['status' => 'Approved', 'employee_id' => $employee_id]);
		}])->where(function($query) use ($last_year_str, $last_year_end){
		    $query->where('start_date', '>=', $last_year_str)->where('end_date', '<=', $last_year_end)->where('kindofleave', 'Earned');
		})->get();

		$last_year_total_earned = 0;
		if (!empty($last_year_leaves_earned)) {
		    foreach ($last_year_leaves_earned as $k => $v) {
		        if (!empty($v->relLeaveApplication)) {
		            $last_year_total_earned = ($last_year_total_earned + $v->number_of_days);
		        }
		    }
		}

		$current_year_leaves_without_pay = LeaveApplicationHistory::with(['relLeaveApplication' => function($query) use ($employee_id){
		    $query->where(['status' => 'Approved', 'employee_id' => $employee_id]);
		}])->where(function($query) use ($current_year_str, $current_year_end){
		    $query->where('start_date', '>=', $current_year_str)->where('end_date', '<=', $current_year_end)->where('kindofleave', 'Without Pay');
		})->get();

		$current_year_total_without_pay = 0;
		if (!empty($current_year_leaves_without_pay)) {
		    foreach ($current_year_leaves_without_pay as $k => $v) {
		        if (!empty($v->relLeaveApplication)) {
		            $current_year_total_without_pay = ($current_year_total_without_pay + $v->number_of_days);
		        }
		    }
		}

		$last_year_leaves_without_pay = LeaveApplicationHistory::with(['relLeaveApplication' => function($query) use ($employee_id){
		    $query->where(['status' => 'Approved', 'employee_id' => $employee_id]);
		}])->where(function($query) use ($last_year_str, $last_year_end){
		    $query->where('start_date', '>=', $last_year_str)->where('end_date', '<=', $last_year_end)->where('kindofleave', 'Without Pay');
		})->get();

		$last_year_total_without_pay = 0;
		if (!empty($last_year_leaves_without_pay)) {
		    foreach ($last_year_leaves_without_pay as $k => $v) {
		        if (!empty($v->relLeaveApplication)) {
		            $last_year_total_without_pay = ($last_year_total_without_pay + $v->number_of_days);
		        }
		    }
		}

		$current_year_leaves_study = LeaveApplicationHistory::with(['relLeaveApplication' => function($query) use ($employee_id){
		    $query->where(['status' => 'Approved', 'employee_id' => $employee_id]);
		}])->where(function($query) use ($current_year_str, $current_year_end){
		    $query->where('start_date', '>=', $current_year_str)->where('end_date', '<=', $current_year_end)->where('kindofleave', 'Study');
		})->get();

		$current_year_total_study = 0;
		if (!empty($current_year_leaves_study)) {
		    foreach ($current_year_leaves_study as $k => $v) {
		        if (!empty($v->relLeaveApplication)) {
		            $current_year_total_study = ($current_year_total_study + $v->number_of_days);
		        }
		    }
		}

		$last_year_leaves_study = LeaveApplicationHistory::with(['relLeaveApplication' => function($query) use ($employee_id){
		    $query->where(['status' => 'Approved', 'employee_id' => $employee_id]);
		}])->where(function($query) use ($last_year_str, $last_year_end){
		    $query->where('start_date', '>=', $last_year_str)->where('end_date', '<=', $last_year_end)->where('kindofleave', 'Study');
		})->get();

		$last_year_total_study = 0;
		if (!empty($last_year_leaves_study)) {
		    foreach ($last_year_leaves_study as $k => $v) {
		        if (!empty($v->relLeaveApplication)) {
		            $last_year_total_study = ($last_year_total_study + $v->number_of_days);
		        }
		    }
		}

		$current_year_leaves_maternity = LeaveApplicationHistory::with(['relLeaveApplication' => function($query) use ($employee_id){
		    $query->where(['status' => 'Approved', 'employee_id' => $employee_id]);
		}])->where(function($query) use ($current_year_str, $current_year_end){
		    $query->where('start_date', '>=', $current_year_str)->where('end_date', '<=', $current_year_end)->where('kindofleave', 'Maternity');
		})->get();

		$current_year_total_maternity = 0;
		if (!empty($current_year_leaves_maternity)) {
		    foreach ($current_year_leaves_maternity as $k => $v) {
		        if (!empty($v->relLeaveApplication)) {
		            $current_year_total_maternity = ($current_year_total_maternity + $v->number_of_days);
		        }
		    }
		}

		$last_year_leaves_maternity = LeaveApplicationHistory::with(['relLeaveApplication' => function($query) use ($employee_id){
		    $query->where(['status' => 'Approved', 'employee_id' => $employee_id]);
		}])->where(function($query) use ($last_year_str, $last_year_end){
		    $query->where('start_date', '>=', $last_year_str)->where('end_date', '<=', $last_year_end)->where('kindofleave', 'Maternity');
		})->get();

		$last_year_total_maternity = 0;
		if (!empty($last_year_leaves_maternity)) {
		    foreach ($last_year_leaves_maternity as $k => $v) {
		        if (!empty($v->relLeaveApplication)) {
		            $last_year_total_maternity = ($last_year_total_maternity + $v->number_of_days);
		        }
		    }
		}

		$current_year_leaves_others = LeaveApplicationHistory::with(['relLeaveApplication' => function($query) use ($employee_id){
		    $query->where(['status' => 'Approved', 'employee_id' => $employee_id]);
		}])->where(function($query) use ($current_year_str, $current_year_end){
		    $query->where('start_date', '>=', $current_year_str)->where('end_date', '<=', $current_year_end)->where('kindofleave', 'Others');
		})->get();

		$current_year_total_others = 0;
		if (!empty($current_year_leaves_others)) {
		    foreach ($current_year_leaves_others as $k => $v) {
		        if (!empty($v->relLeaveApplication)) {
		            $current_year_total_others = ($current_year_total_others + $v->number_of_days);
		        }
		    }
		}

		$last_year_leaves_others = LeaveApplicationHistory::with(['relLeaveApplication' => function($query) use ($employee_id){
		    $query->where(['status' => 'Approved', 'employee_id' => $employee_id]);
		}])->where(function($query) use ($last_year_str, $last_year_end){
		    $query->where('start_date', '>=', $last_year_str)->where('end_date', '<=', $last_year_end)->where('kindofleave', 'Others');
		})->get();

		$last_year_total_others = 0;
		if (!empty($last_year_leaves_others)) {
		    foreach ($last_year_leaves_others as $k => $v) {
		        if (!empty($v->relLeaveApplication)) {
		            $last_year_total_others = ($last_year_total_others + $v->number_of_days);
		        }
		    }
		}

		return [
		    'current_year' => [
		        'total_earned' => $current_year_total_earned,
		        'total_without_pay' => $current_year_total_without_pay,
		        'total_study' => $current_year_total_study,
		        'total_maternity' => $current_year_total_maternity,
		        'total_others' => $current_year_total_others,
		    ],
		    'last_year' => [
		        'total_earned' => $last_year_total_earned,
		        'total_without_pay' => $last_year_total_without_pay,
		        'total_study' => $last_year_total_study,
		        'total_maternity' => $last_year_total_maternity,
		        'total_others' => $last_year_total_others,
		    ],
		];
	}

	public function leave_yearly_review_date_range( $employee_id, $str_date, $end_date )
	{
		$current_year_str = strtotime($str_date);
		$current_year_end = strtotime($end_date);

		$current_year_leaves_earned = LeaveApplicationHistory::with(['relLeaveApplication' => function($query) use ($employee_id){
		    $query->where(['status' => 'Approved', 'employee_id' => $employee_id]);
		}])->where(function($query) use ($current_year_str, $current_year_end){
		    $query->where('start_date', '>=', $current_year_str)->where('end_date', '<=', $current_year_end)->where('kindofleave', 'Earned');
		})->get();

		$current_year_total_earned = 0;
		if (!empty($current_year_leaves_earned)) {
		    foreach ($current_year_leaves_earned as $k => $v) {
		        if (!empty($v->relLeaveApplication)) {
		            $current_year_total_earned = ($current_year_total_earned + $v->number_of_days);
		        }
		    }
		}

		$current_year_leaves_without_pay = LeaveApplicationHistory::with(['relLeaveApplication' => function($query) use ($employee_id){
		    $query->where(['status' => 'Approved', 'employee_id' => $employee_id]);
		}])->where(function($query) use ($current_year_str, $current_year_end){
		    $query->where('start_date', '>=', $current_year_str)->where('end_date', '<=', $current_year_end)->where('kindofleave', 'Without Pay');
		})->get();

		$current_year_total_without_pay = 0;
		if (!empty($current_year_leaves_without_pay)) {
		    foreach ($current_year_leaves_without_pay as $k => $v) {
		        if (!empty($v->relLeaveApplication)) {
		            $current_year_total_without_pay = ($current_year_total_without_pay + $v->number_of_days);
		        }
		    }
		}

		$current_year_leaves_study = LeaveApplicationHistory::with(['relLeaveApplication' => function($query) use ($employee_id){
		    $query->where(['status' => 'Approved', 'employee_id' => $employee_id]);
		}])->where(function($query) use ($current_year_str, $current_year_end){
		    $query->where('start_date', '>=', $current_year_str)->where('end_date', '<=', $current_year_end)->where('kindofleave', 'Study');
		})->get();

		$current_year_total_study = 0;
		if (!empty($current_year_leaves_study)) {
		    foreach ($current_year_leaves_study as $k => $v) {
		        if (!empty($v->relLeaveApplication)) {
		            $current_year_total_study = ($current_year_total_study + $v->number_of_days);
		        }
		    }
		}

		$current_year_leaves_maternity = LeaveApplicationHistory::with(['relLeaveApplication' => function($query) use ($employee_id){
		    $query->where(['status' => 'Approved', 'employee_id' => $employee_id]);
		}])->where(function($query) use ($current_year_str, $current_year_end){
		    $query->where('start_date', '>=', $current_year_str)->where('end_date', '<=', $current_year_end)->where('kindofleave', 'Maternity');
		})->get();

		$current_year_total_maternity = 0;
		if (!empty($current_year_leaves_maternity)) {
		    foreach ($current_year_leaves_maternity as $k => $v) {
		        if (!empty($v->relLeaveApplication)) {
		            $current_year_total_maternity = ($current_year_total_maternity + $v->number_of_days);
		        }
		    }
		}

		$current_year_leaves_others = LeaveApplicationHistory::with(['relLeaveApplication' => function($query) use ($employee_id){
		    $query->where(['status' => 'Approved', 'employee_id' => $employee_id]);
		}])->where(function($query) use ($current_year_str, $current_year_end){
		    $query->where('start_date', '>=', $current_year_str)->where('end_date', '<=', $current_year_end)->where('kindofleave', 'Others');
		})->get();

		$current_year_total_others = 0;
		if (!empty($current_year_leaves_others)) {
		    foreach ($current_year_leaves_others as $k => $v) {
		        if (!empty($v->relLeaveApplication)) {
		            $current_year_total_others = ($current_year_total_others + $v->number_of_days);
		        }
		    }
		}

		return [
			'employee' => new EmployeeShortDetailsResource(Employee::find($employee_id)),
		    'review' => [
		        'total_earned' => $current_year_total_earned,
		        'total_without_pay' => $current_year_total_without_pay,
		        'total_study' => $current_year_total_study,
		        'total_maternity' => $current_year_total_maternity,
		        'total_others' => $current_year_total_others,
		    ]
		];
	}

	public function leave_yearly_reviews_date_range( $employee_id, $str_date, $end_date )
	{
		$current_year_str = strtotime($str_date);
        $current_year_end = strtotime($end_date);

        $current_year_total_earned = LeaveApplication::where('employee_id', $employee_id)
            ->where('status', 'Approved')
            ->whereHas('relLeaveApplicationHistory',function($q) use($current_year_str, $current_year_end) {
                $q  ->where('start_date', '>=', $current_year_str)
                    ->where('end_date', '<=', $current_year_end)
                    ->where('kindofleave', 'Earned');
            })
            ->get()->sum(function ($region) {
                return $region->relLeaveApplicationHistory->sum('number_of_days');
            });


        $current_year_total_without_pay = LeaveApplication::where('employee_id', $employee_id)
            ->where('status', 'Approved')
            ->whereHas('relLeaveApplicationHistory',function($q) use($current_year_str, $current_year_end) {
                $q  ->where('start_date', '>=', $current_year_str)
                    ->where('end_date', '<=', $current_year_end)
                    ->where('kindofleave', 'Without Pay');
            })
            ->get()->sum(function ($region) {
                return $region->relLeaveApplicationHistory->sum('number_of_days');
            });

        $current_year_total_study = LeaveApplication::where('employee_id', $employee_id)
            ->where('status', 'Approved')
            ->whereHas('relLeaveApplicationHistory',function($q) use($current_year_str, $current_year_end) {
                $q  ->where('start_date', '>=', $current_year_str)
                    ->where('end_date', '<=', $current_year_end)
                    ->where('kindofleave', 'Study');
            })
            ->get()->sum(function ($region) {
                return $region->relLeaveApplicationHistory->sum('number_of_days');
            });

        $current_year_total_maternity = LeaveApplication::where('employee_id', $employee_id)
            ->where('status', 'Approved')
            ->whereHas('relLeaveApplicationHistory',function($q) use($current_year_str, $current_year_end) {
                $q  ->where('start_date', '>=', $current_year_str)
                    ->where('end_date', '<=', $current_year_end)
                    ->where('kindofleave', 'Maternity');
            })
            ->get()->sum(function ($region) {
                return $region->relLeaveApplicationHistory->sum('number_of_days');
            });

        $current_year_total_others = LeaveApplication::where('employee_id', $employee_id)
            ->where('status', 'Approved')
            ->whereHas('relLeaveApplicationHistory',function($q) use($current_year_str, $current_year_end) {
                $q  ->where('start_date', '>=', $current_year_str)
                    ->where('end_date', '<=', $current_year_end)
                    ->where('kindofleave', 'Others');
            })
            ->get()->sum(function ($region) {
                return $region->relLeaveApplicationHistory->sum('number_of_days');
            });

        $employee = Employee::find($employee_id);

		return [
            'id' => $employee->id,
            'name' => $employee->name ?? '',
            'email' => $employee->office_email,
            'designation' => $employee->relDesignation->name,
            'department' => $employee->relDepartment->name,
            'total_earned' => $current_year_total_earned,
            'total_without_pay' => $current_year_total_without_pay,
            'total_study' => $current_year_total_study,
            'total_maternity' => $current_year_total_maternity,
            'total_others' => $current_year_total_others,
		];
	}
}
?>