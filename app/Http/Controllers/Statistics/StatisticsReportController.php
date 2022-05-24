<?php

namespace App\Http\Controllers\Statistics;

use App\Employee;
use App\Models\STD\StaffsServiceCategory;
use App\Models\STD\TeacherServiceCategory;
use Carbon\Carbon;
use App\Models\RMS\WpEmpRms;
use App\Traits\RmsApiTraits;
use Illuminate\Http\Request;
use App\Rules\CheckValidDate;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeResource;
use App\Models\STD\StaffServiceFeedback;
use App\Models\STD\TeacherServiceFeedback;
use App\Models\STD\StaffsServiceInfoFeedbacks;
use App\Http\Resources\StudentServiceFeedbackResource;
use App\Http\Resources\TeacherServiceFeedbackResource;
use App\Http\Resources\StaffServiceInfoFeedbackResource;

class StatisticsReportController extends Controller
{
    use RmsApiTraits;

    public function studentPurposeStatistics(Request $request)
    {
        $this->validate($request, [
            'start_date' => ['required', 'date', new CheckValidDate],
            'end_date' => ['required', 'date', new CheckValidDate],
            'purpose_pay_id' => 'required|integer',
        ]);

        $data = [];
        $data['start_date'] = Carbon::parse($request->start_date)->format('Y/m/d');
        $data['end_date'] = Carbon::parse($request->end_date)->format('Y/m/d');
        $data['purpose_pay_id'] = $request->purpose_pay_id;
        return $this->scholarshipReport($data);
    }

    //employee start
    public function employeeLists(Request $request)
    {

        $type = 'faculty';

        $employees = Employee::with('relDesignation', 'relDepartment', 'relCampus')
            ->where('groups', 'not like', '%' . $type . '%')
            ->orWhereNull('groups')
            ->get();

        $data = [];

        foreach ($employees as $employee) {

            $details = $this->ratingDetails($employee->id);

            $data[] = [
                'id' => $employee->id,
                'name' => $employee->name,
                'designation' => $employee->relDesignation->name,
                'department' => $employee->relDepartment->name,
                'campus' => $employee->relCampus->name,
                'ratingDetails' => $details
            ];

        }

//        $employee = EmployeeResource::collection($employees);


        return $data;
    }

    public function employeeFeedbackDetails($employeeId)
    {
        return StaffServiceInfoFeedbackResource::collection(StaffsServiceInfoFeedbacks::with(
            'staffServiceFeedback',
            'staffServiceFeedback.student',
            'staffServiceFeedback.student.relDepartment',
            'staffServiceInfoFeedbackDetails',
            'staffServiceInfoFeedbackDetails.category'
        )->withCount([
            'staffServiceInfoFeedbackDetails AS totalPoint' => function ($query) {
                $query->select(\DB::raw("SUM(point)"));
            }
        ])->whereEmployeeId($employeeId)->orderByDesc('id')->paginate(50));

    }

//    public function employeeFeedbackDetailsFilter($employeeId)
//    {
//        return StaffServiceInfoFeedbackResource::collection(StaffsServiceInfoFeedbacks::with(
//            'staffServiceFeedback',
//            'staffServiceFeedback.student',
//            'staffServiceFeedback.student.relDepartment',
//            'staffServiceInfoFeedbackDetails',
//            'staffServiceInfoFeedbackDetails.category'
//        )->withCount([
//            'staffServiceInfoFeedbackDetails AS totalPoint' => function ($query) {
//                $query->select(\DB::raw("SUM(point)"));
//            }
//        ])->whereEmployeeId($employeeId)->orderByDesc('id')->paginate(50));
//
//    }

    public function staffsFeedbackShortDetails($employeeId)
    {

        $employee = new EmployeeResource(Employee::find($employeeId));

        $taffsServiceInfoFeedbacks = StaffsServiceInfoFeedbacks::withCount([
            'staffServiceInfoFeedbackDetails AS totalPoint' => function ($query) {
                $query->select(\DB::raw("SUM(point)"));
            }
        ])->whereEmployeeId($employeeId)->orderByDesc('id')->get();

        $totalCategory = $taffsServiceInfoFeedbacks->sum('total_category');
        $totalRatingProvider = count($taffsServiceInfoFeedbacks);
        $totalPoint = $taffsServiceInfoFeedbacks->sum('totalPoint');

        $totalNumberCategory = 0.00;
        if (!($totalCategory == 0 && $totalRatingProvider == 0)) {
            $totalNumberCategory = $totalCategory / $totalRatingProvider;
        }

        $totalNumberPoint = 0.00;
        if (!($totalPoint == 0 && $totalRatingProvider == 0)) {
            $totalNumberPoint = $totalPoint / $totalRatingProvider;
        }

        $averageRating = 0.00;
        if (!($totalNumberPoint == 0 && $totalNumberCategory == 0)) {
            $averageRating = number_format($totalNumberPoint / $totalNumberCategory, 2);
        }

        $data = [
            'employee' => $employee,
            'totalRatingProvider' => $totalRatingProvider,
            'totalNumberCategory' => number_format($totalNumberCategory),
            'totalNumberPoint' => number_format($totalNumberPoint * $totalRatingProvider, 2),
            'averageRating' => number_format($averageRating, 2),

        ];

        return $data;

    }

    public function staffsFeedbackShortDetailsFilter(Request $request, $employeeId)
    {
        $employee = new EmployeeResource(Employee::find($employeeId));

        $start_date = $request->start_date;
        if (!isset($request->end_date)) {
            $end_date = date('Y-m-d');
        } else {
            $end_date = $request->end_date;
        }


        $taffsServiceInfoFeedbacks = StaffsServiceInfoFeedbacks::withCount([
            'staffServiceInfoFeedbackDetails AS totalPoint' => function ($query) use ($start_date) {
                $query->select(\DB::raw("SUM(point)"));
            }
        ])->whereBetween('created_at', [$start_date, $end_date])
            ->whereEmployeeId($employeeId)->orderByDesc('id')
            ->get();


        $totalCategory = $taffsServiceInfoFeedbacks->sum('total_category');
        $totalRatingProvider = count($taffsServiceInfoFeedbacks);
        $totalPoint = $taffsServiceInfoFeedbacks->sum('totalPoint');

        $totalNumberCategory = 0.00;
        if (!($totalCategory == 0 && $totalRatingProvider == 0)) {
            $totalNumberCategory = $totalCategory / $totalRatingProvider;
        }

        $totalNumberPoint = 0.00;
        if (!($totalPoint == 0 && $totalRatingProvider == 0)) {
            $totalNumberPoint = $totalPoint / $totalRatingProvider;
        }

        $averageRating = 0.00;
        if (!($totalNumberPoint == 0 && $totalNumberCategory == 0)) {
            $averageRating = number_format($totalNumberPoint / $totalNumberCategory, 2);
        }

        $data = [
            'employee' => $employee,
            'totalRatingProvider' => $totalRatingProvider,
            'totalNumberCategory' => number_format($totalNumberCategory),
            'totalNumberPoint' => number_format($totalNumberPoint * $totalRatingProvider, 2),
            'averageRating' => number_format($averageRating, 2),

        ];

        return $data;

    }

    public function staffRatingCategory()
    {
        return StaffsServiceCategory::whereStatus(1)->get();

    }

    public function categoryWiseStaffRatingPoint(Request $request)
    {
        $categoryId = $request->categoryId;

        $collections = StaffsServiceInfoFeedbacks::with('staffServiceInfoFeedbackDetails', 'staffServiceInfoFeedbackDetails.category')->withCount([
            'staffServiceInfoFeedbackDetails AS total' => function ($query) use ($categoryId) {
                $query->select(\DB::raw("SUM(point)"))->where('staffs_service_category_id', $categoryId);
            }
        ])->whereEmployeeId($request->cmsId)->get();

        return $collections->sum('total');


    }

    public function categoryWiseStaffRatingPointFilter(Request $request)
    {
        $categoryId = $request->categoryId;

        $start_date = $request->start_date;
        if (!isset($request->end_date)) {
            $end_date = date('Y-m-d');
        } else {
            $end_date = $request->end_date;
        }

        $collections = StaffsServiceInfoFeedbacks::with('staffServiceInfoFeedbackDetails', 'staffServiceInfoFeedbackDetails.category')->withCount([
            'staffServiceInfoFeedbackDetails AS total' => function ($query) use ($categoryId) {
                $query->select(\DB::raw("SUM(point)"))->where('staffs_service_category_id', $categoryId);
            }
        ])->whereBetween('created_at', [$start_date, $end_date])
            ->whereEmployeeId($request->cmsId)->get();

        return $collections->sum('total');


    }
    //employee end

    //teacher start
    public function teacherLists(Request $request)
    {
        $type = 'faculty';

        $employees = Employee::with('rmsEmployee', 'relDesignation', 'relDepartment')
            ->where('groups', 'like', '%' . $type . '%')
            ->where('supervised_by', $request->auth->id)   // supervisor list only
            ->paginate(15);


        $employees->getCollection()->transform(function ($employee){
            $details = $this->ratingDetails($employee->id);

                    return[
                        'id' => $employee->id,
                        'name' => $employee->name,
//                'office_email' => $employee->office_email,
                        'designation' => $employee->relDesignation->name,
                        'department' => $employee->relDepartment->name,
                        'campus' => $employee->relCampus->name,
                        'rmsEmployeeId' => $employee->rmsEmployee->id,
                        'ratingDetails' => $details
                    ];
        });

        return $employees;
//
//        $data = [];
//
//        foreach ($employees as $employee) {
//
//            $details = $this->ratingDetails($employee->id);
//
//            $data[] = [
//                'id' => $employee->id,
//                'name' => $employee->name,
////                'office_email' => $employee->office_email,
//                'designation' => $employee->relDesignation->name,
//                'department' => $employee->relDepartment->name,
//                'campus' => $employee->relCampus->name,
//                'rmsEmployeeId' => $employee->rmsEmployee->id,
//                'ratingDetails' => $details
//            ];
//
//        }

//        return $data;

        /*$employee = EmployeeResource::collection($employees);
        return $employee;*/
    }
    //teacher start
    public function teacherListsFilter(Request $request)
    {
        $type = 'faculty';

        $employees = Employee::with('rmsEmployee', 'relDesignation', 'relDepartment')
            ->where('groups', 'like', '%' . $type . '%')
            ->where('supervised_by', $request->auth->id)
            ->paginate(15);


        $employees->getCollection()->transform(function ($employee) use($request){
            $details = $this->ratingDetailsFilter($request ,$employee->id);

                    return[
                        'id' => $employee->id,
                        'name' => $employee->name,
//                'office_email' => $employee->office_email,
                        'designation' => $employee->relDesignation->name,
                        'department' => $employee->relDepartment->name,
                        'campus' => $employee->relCampus->name,
                        'rmsEmployeeId' => $employee->rmsEmployee->id,
                        'ratingDetails' => $details
                    ];
        });

        return $employees;
    }

    //teacher start
    public function teacherListsCheck()
    {
//        return TeacherServiceFeedback::first();
        $type = 'faculty';
        $employees = Employee::with('rmsEmployee', 'relDesignation', 'relDepartment')
            ->where('groups', 'like', '%' . $type . '%')
            ->take(10)->get();

        $data = [];

        foreach ($employees as $employee) {

            $details = $this->ratingDetails($employee->id);

            $data[] = [
                'id' => $employee->id,
                'name' => $employee->name,
//                'office_email' => $employee->office_email,
                'designation' => $employee->relDesignation->name,
                'department' => $employee->relDepartment->name,
                'campus' => $employee->relCampus->name,
                'rmsEmployeeId' => $employee->rmsEmployee->id,
                'ratingDetails' => $details
            ];

        }

        return $data;

        /*$employee = EmployeeResource::collection($employees);
        return $employee;*/
    }

    public function teacherFeedbackReportShow($rmsTeacherID)
    {
        return TeacherServiceFeedbackResource::collection(TeacherServiceFeedback::with(
            'student',
            'student.relDepartment',
            'teacherServiceFeedbackDetails',
            'teacherServiceFeedbackDetails.category'
        )->withCount([
            'teacherServiceFeedbackDetails AS totalPoint' => function ($query) {
                $query->select(\DB::raw("SUM(point)"));
            }
        ])->orderByDesc('id')->whereTeacherId($rmsTeacherID)->paginate(50));
    }

    public function teacherFeedbackShortDetails($rmsTeacherID)
    {
        $teacher = WpEmpRms::find($rmsTeacherID);

//        return
        $teacherServiceFeedback = TeacherServiceFeedback::withCount([
            'teacherServiceFeedbackDetails AS totalPoint' => function ($query) {
                $query->select(\DB::raw("SUM(point)"));
            }
        ])->whereTeacherId($rmsTeacherID)->get();

        $totalCategory = $teacherServiceFeedback->sum('total_category');
        $totalRatingProvider = count($teacherServiceFeedback);
        $totalPoint = $teacherServiceFeedback->sum('totalPoint');

        $totalNumberCategory = 0.00;
        if (!($totalCategory == 0 && $totalRatingProvider == 0)) {
            $totalNumberCategory = $totalCategory / $totalRatingProvider;
        }

        $totalNumberPoint = 0.00;
        if (!($totalPoint == 0 && $totalRatingProvider == 0)) {
            $totalNumberPoint = $totalPoint / $totalRatingProvider;
        }

        $averageRating = 0.00;
        if (!($totalNumberPoint == 0 && $totalNumberCategory == 0)) {
            $averageRating = number_format($totalNumberPoint / $totalNumberCategory, 2);
        }

        $data = [
            'teacher' => $teacher,
            'totalRatingProvider' => $totalRatingProvider,
            'totalNumberCategory' => number_format($totalNumberCategory),
            'totalNumberPoint' => number_format($totalNumberPoint * $totalRatingProvider, 2),
            'averageRating' => number_format($averageRating, 2),

        ];

        return $data;
    }

    public function teacherFeedbackShortDetailsFilter(Request $request, $rmsTeacherID)
    {
        $teacher = WpEmpRms::find($rmsTeacherID);

        $start_date = $request->start_date;

        if (!isset($request->end_date)) {
            $end_date = date('Y-m-d');
        } else {
            $end_date = $request->end_date;
        }


        $teacherServiceFeedback = TeacherServiceFeedback::withCount([
            'teacherServiceFeedbackDetails AS totalPoint' => function ($query) {
                $query->select(\DB::raw("SUM(point)"));
            }
        ])->whereBetween('created_at', [$start_date, $end_date])
            ->whereTeacherId($rmsTeacherID)->get();

        $totalCategory = $teacherServiceFeedback->sum('total_category');
        $totalRatingProvider = count($teacherServiceFeedback);
        $totalPoint = $teacherServiceFeedback->sum('totalPoint');

        $totalNumberCategory = 0.00;
        if (!($totalCategory == 0 && $totalRatingProvider == 0)) {
            $totalNumberCategory = $totalCategory / $totalRatingProvider;
        }

        $totalNumberPoint = 0.00;
        if (!($totalPoint == 0 && $totalRatingProvider == 0)) {
            $totalNumberPoint = $totalPoint / $totalRatingProvider;
        }

        $averageRating = 0.00;
        if (!($totalNumberPoint == 0 && $totalNumberCategory == 0)) {
            $averageRating = number_format($totalNumberPoint / $totalNumberCategory, 2);
        }

        $data = [
            'teacher' => $teacher,
            'totalRatingProvider' => $totalRatingProvider,
            'totalNumberCategory' => number_format($totalNumberCategory),
            'totalNumberPoint' => number_format($totalNumberPoint * $totalRatingProvider, 2),
            'averageRating' => number_format($averageRating, 2),

        ];

        return $data;
    }

    protected function ratingDetails($cmsEmployeeID)
    {

        $type = 'faculty';

        $authId = $cmsEmployeeID;

        $employee = Employee::where('id', $authId)->where('groups', 'like', '%' . $type . '%')->first();


        if ($employee) {

            $wpEmpRms = WpEmpRms::whereEmail1($employee->office_email)->first();

            $teacherServiceFeedback = TeacherServiceFeedback::with('teacherServiceFeedbackDetails')
                ->withCount([
                    'teacherServiceFeedbackDetails AS totalPoint' => function ($query) {
                        $query->select(\DB::raw("SUM(point)"));
                    }
                ])->whereTeacherId($wpEmpRms->id)->get();


            $totalRatingProvider = TeacherServiceFeedback::whereTeacherId($wpEmpRms->id)->count();
            $totalCategory = TeacherServiceFeedback::whereTeacherId($wpEmpRms->id)->sum('total_category');


            $totalNumberCategory = 0.00;
            if (!($totalCategory == 0 && $totalRatingProvider == 0)) {
                $totalNumberCategory = $totalCategory / $totalRatingProvider;
            }

            $totalNumberPoint = 0.00;
            if (!($teacherServiceFeedback->sum('totalPoint') == 0 && $totalRatingProvider == 0)) {
                $totalNumberPoint = $teacherServiceFeedback->sum('totalPoint') / $totalRatingProvider;
            }

            $averageRating = 0.00;
            if (!($totalNumberPoint == 0 && $totalNumberCategory == 0)) {
                $averageRating = number_format($totalNumberPoint / $totalNumberCategory, 2);
            }

            $data = [

                'totalRatingProvider' => $totalRatingProvider,
                'totalNumberCategory' => number_format($totalNumberCategory),
                'totalNumberPoint' => number_format($totalNumberPoint * $totalRatingProvider, 2),
                'averageRating' => number_format($averageRating, 2),

            ];

            return $data;

        }

        // all staffs rating start
        $staffDetails = StaffsServiceInfoFeedbacks::withCount([
            'staffServiceInfoFeedbackDetails AS totalPoint' => function ($query) {
                $query->select(\DB::raw("SUM(point)"));
            }
        ])->whereEmployeeId($cmsEmployeeID)->get();

        $totalRatingProvider = StaffsServiceInfoFeedbacks::whereEmployeeId($cmsEmployeeID)->count();
        $totalCategory = StaffsServiceInfoFeedbacks::whereEmployeeId($cmsEmployeeID)->sum('total_category');


        $totalNumberCategory = 0.00;
        if (!($totalCategory == 0 && $totalRatingProvider == 0)) {
            $totalNumberCategory = $totalCategory / $totalRatingProvider;
        }


        $totalNumberPoint = 0.00;
        if (!($staffDetails->sum('totalPoint') == 0 && $totalRatingProvider == 0)) {
            $totalNumberPoint = $staffDetails->sum('totalPoint') / $totalRatingProvider;
        }

        $averageRating = 0.00;
        if (!($totalNumberPoint == 0 && $totalNumberCategory == 0)) {
            $averageRating = number_format($totalNumberPoint / $totalNumberCategory, 2);
        }
        // all staffs rating end


        $data = [

            'totalRatingProvider' => $totalRatingProvider,
            'totalNumberCategory' => number_format($totalNumberCategory),
            'totalNumberPoint' => number_format($totalNumberPoint * $totalRatingProvider, 2),
            'averageRating' => number_format($averageRating, 2),

        ];

        return $data;
    }

    protected function ratingDetailsFilter($request, $cmsEmployeeID)
    {

        $start_date = $request->start_date;

        if (!isset($request->end_date)) {
            $end_date = date('Y-m-d');
        } else {
            $end_date = $request->end_date;
        }


        $type = 'faculty';

        $authId = $cmsEmployeeID;

        $employee = Employee::where('id', $authId)->where('groups', 'like', '%' . $type . '%')->first();


        if ($employee) {

            $wpEmpRms = WpEmpRms::whereEmail1($employee->office_email)->first();

            $teacherServiceFeedback = TeacherServiceFeedback::with('teacherServiceFeedbackDetails')
                ->withCount([
                    'teacherServiceFeedbackDetails AS totalPoint' => function ($query) {
                        $query->select(\DB::raw("SUM(point)"));
                    }
                ])->whereBetween('created_at', [$start_date, $end_date])
                ->whereTeacherId($wpEmpRms->id)->get();



            $totalRatingProvider = TeacherServiceFeedback::whereTeacherId($wpEmpRms->id)->whereBetween('created_at', [$start_date, $end_date])->count();
            $totalCategory = TeacherServiceFeedback::whereTeacherId($wpEmpRms->id)->sum('total_category');


            $totalNumberCategory = 0.00;
            if (!($totalCategory == 0 && $totalRatingProvider == 0)) {
                $totalNumberCategory = $totalCategory / $totalRatingProvider;
            }

            $totalNumberPoint = 0.00;
            if (!($teacherServiceFeedback->sum('totalPoint') == 0 && $totalRatingProvider == 0)) {
                $totalNumberPoint = $teacherServiceFeedback->sum('totalPoint') / $totalRatingProvider;
            }

            $averageRating = 0.00;
            if (!($totalNumberPoint == 0 && $totalNumberCategory == 0)) {
                $averageRating = number_format($totalNumberPoint / $totalNumberCategory, 2);
            }

            $data = [

                'totalRatingProvider' => $totalRatingProvider,
                'totalNumberCategory' => number_format($totalNumberCategory),
                'totalNumberPoint' => number_format($totalNumberPoint * $totalRatingProvider, 2),
                'averageRating' => number_format($averageRating, 2),

            ];

            return $data;

        }

        // all staffs rating start
        $staffDetails = StaffsServiceInfoFeedbacks::withCount([
            'staffServiceInfoFeedbackDetails AS totalPoint' => function ($query) {
                $query->select(\DB::raw("SUM(point)"));
            }
        ])->whereEmployeeId($cmsEmployeeID)->get();

        $totalRatingProvider = StaffsServiceInfoFeedbacks::whereEmployeeId($cmsEmployeeID)->count();
        $totalCategory = StaffsServiceInfoFeedbacks::whereEmployeeId($cmsEmployeeID)->sum('total_category');


        $totalNumberCategory = 0.00;
        if (!($totalCategory == 0 && $totalRatingProvider == 0)) {
            $totalNumberCategory = $totalCategory / $totalRatingProvider;
        }


        $totalNumberPoint = 0.00;
        if (!($staffDetails->sum('totalPoint') == 0 && $totalRatingProvider == 0)) {
            $totalNumberPoint = $staffDetails->sum('totalPoint') / $totalRatingProvider;
        }

        $averageRating = 0.00;
        if (!($totalNumberPoint == 0 && $totalNumberCategory == 0)) {
            $averageRating = number_format($totalNumberPoint / $totalNumberCategory, 2);
        }
        // all staffs rating end


        $data = [

            'totalRatingProvider' => $totalRatingProvider,
            'totalNumberCategory' => number_format($totalNumberCategory),
            'totalNumberPoint' => number_format($totalNumberPoint * $totalRatingProvider, 2),
            'averageRating' => number_format($averageRating, 2),

        ];

        return $data;
    }

    public function teacherRatingCategory()
    {
        return TeacherServiceCategory::whereStatus(1)->get();
    }

    public function categoryWiseTeacherRatingPoint(Request $request)
    {
        $categoryId = $request->categoryId;

        $teacherServiceFeedback = TeacherServiceFeedback::with('teacherServiceFeedbackDetails', 'teacherServiceFeedbackDetails.category')
            ->withCount([
                'teacherServiceFeedbackDetails AS total' => function ($query) use ($categoryId) {
                    $query->select(\DB::raw("SUM(point)"))->where('teacher_service_category_id', $categoryId);
                }
            ])->whereTeacherId($request->rmsId)->get();

        return $teacherServiceFeedback->sum('total');

    }

    public function categoryWiseTeacherRatingPointFilter(Request $request)
    {
        $categoryId = $request->categoryId;

        $start_date = $request->start_date;

        if (!isset($request->end_date)) {
            $end_date = date('Y-m-d');
        } else {
            $end_date = $request->end_date;
        }

        $teacherServiceFeedback = TeacherServiceFeedback::with('teacherServiceFeedbackDetails', 'teacherServiceFeedbackDetails.category')
            ->withCount([
                'teacherServiceFeedbackDetails AS total' => function ($query) use ($categoryId) {
                    $query->select(\DB::raw("SUM(point)"))->where('teacher_service_category_id', $categoryId);
                }
            ])->whereBetween('created_at', [$start_date, $end_date])
            ->whereTeacherId($request->rmsId)->get();

        return $teacherServiceFeedback->sum('total');

    }


    //teacher end
}
