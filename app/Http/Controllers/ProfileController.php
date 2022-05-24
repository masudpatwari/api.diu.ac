<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Models\RMS\WpEmpRms;
use App\Models\STD\StaffsServiceCategory;
use App\Models\STD\TeacherServiceCategory;
use Illuminate\Http\Request;
use App\EmployeeUpdateHistory;
use App\Models\STD\SupportTicket;
use Illuminate\Support\Facades\DB;
use App\Rules\CheckValidPhoneNumber;
use App\Models\STD\TeacherServiceFeedback;
use App\Models\STD\StaffsServiceInfoFeedbacks;
use App\Http\Resources\EmployeeProfileResource;
use App\Http\Resources\ProfileTeacherServiceFeedbackResource;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
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

    public function update(Request $request)
    {
        $id = $request->auth->id;
        $this->validate($request,
            [
                'employee_name_slug' => 'unique:employees,slug_name,' . $id,
                'private_email' => 'required|email|unique:employees,private_email,' . $id,
                'home_phone' => [new CheckValidPhoneNumber],
                'personal_phone' => ['required', 'unique:employees,personal_phone_no,' . $id, new CheckValidPhoneNumber],
                'alternative_phone' => [new CheckValidPhoneNumber],
                'spous_phone' => [new CheckValidPhoneNumber],
                'parents_phone' => [new CheckValidPhoneNumber],
                'gurdian_phone' => [new CheckValidPhoneNumber],
            ]
        );

        $slug = str_replace([".", " ", "(", ")"], ["."], strtolower($request->input('employee_name_slug')));
        $employee_array = [
            'slug_name' => $slug,
            'private_email' => $request->input('private_email'),
            'home_phone_no' => $request->input('home_phone'),
            'personal_phone_no' => $request->input('personal_phone'),
            'alternative_phone_no' => $request->input('alternative_phone'),
            'spous_phone_no' => $request->input('spous_phone'),
            'parents_phone_no' => $request->input('parents_phone'),
            'gurdian_phone_no' => $request->input('gurdian_phone'),
            'other_phone_no' => $request->input('other_phone'),
            'overview' => $request->input('overview'),
        ];

        try {
            DB::beginTransaction();

            $old_employee = Employee::where('id', $id)->first();
            Employee::where('id', $id)->update($employee_array);
            $updated_employee = Employee::where('id', $id)->first();

            $diff_result = array_diff($old_employee->toArray(), $updated_employee->toArray());
            unset($diff_result['updated_at']);
            if (!empty($diff_result)) {
                EmployeeUpdateHistory::create([
                    'prev_row' => json_encode($diff_result),
                    'created_by' => $request->auth->id,
                ]);
            }

            DB::commit();
            return response()->json($diff_result, 200);
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(['error' => 'Update Failed.'], 400);
        }
    }

    public function show(Request $request)
    {
        $employees = Employee::find($request->auth->id);
        if (!empty($employees)) {
            return new EmployeeProfileResource($employees);
        }
        return response()->json(NULL, 404);
    }

    public function profile($id)
    {
        if (is_numeric($id)) {
            $employees = Employee::find($id);
        } else {
            $employees = Employee::where('slug_name', $id)->first();
        }
        if (!empty($employees)) {
            return new EmployeeProfileResource($employees);
        }
        return response()->json(NULL, 404);
    }


    public function ticketAssignNotification(Request $request)
    {

        $data = [
            'studentSupportTicket' => \App\Models\STD\SupportTicket::whereAssaignTo($request->auth->id)->where('status', 'active')->count(),
            'employeeSupportTicket' => \App\Models\ItSupport\SupportTicket::whereAssaignTo($request->auth->id)->where('status', 'active')->count(),
        ];

        return $data;
    }

    public function rating(Request $request)
    {

        //        try {
                    $type = 'faculty';

                    $authId = $request->auth->id;
                    //        $authId = '362';

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
                    ])->whereEmployeeId($request->auth->id)->get();

                    $totalRatingProvider = StaffsServiceInfoFeedbacks::whereEmployeeId($request->auth->id)->count();
                    $totalCategory = StaffsServiceInfoFeedbacks::whereEmployeeId($request->auth->id)->sum('total_category');


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
        //        }catch (\Exception $exception)
        //        {
        //
        //            $type = 'faculty';
        //
        //            $authId = $request->auth->id;
        //            //        $authId = '362';
        //
        //            $employee = Employee::where('id', $authId)->where('groups', 'like', '%' . $type . '%')->first();
        //            Storage::disk('attendance_info')->append('info_employee', $employee);
        //            return response()->json(['error' => $exception->getMessage()], 400);
        //        }


    }

    public function rattingCount(Request $request)
    {

        $type = 'faculty';

        $authId = $request->auth->id;

        $employee = Employee::where('id', $authId)->where('groups', 'like', '%' . $type . '%')->first();

        if ($employee) {
            $wpEmpRms = WpEmpRms::whereEmail1($employee->office_email)->first();

            $allCollections = TeacherServiceFeedback::with('teacherServiceFeedbackDetails', 'teacherServiceFeedbackDetails.category')
                ->withCount([
                    'teacherServiceFeedbackDetails AS totalPoint' => function ($query) {
                        $query->select(\DB::raw("SUM(point)"));
                    }
                ])->whereTeacherId($wpEmpRms->id)->get();

            $data = [
                'totalNumberOfPoint' => $allCollections->sum('totalPoint'),
                'totalRatingProvider' => count($allCollections)
            ];

            return $data;
        }

        $allCollections = StaffsServiceInfoFeedbacks::with('staffServiceInfoFeedbackDetails', 'staffServiceInfoFeedbackDetails.category')->withCount([
            'staffServiceInfoFeedbackDetails AS totalPoint' => function ($query) {
                $query->select(\DB::raw("SUM(point)"));
            }
        ])->whereEmployeeId($authId)->get();

        $data = [
            'totalNumberOfPoint' => $allCollections->sum('totalPoint'),
            'totalRatingProvider' => count($allCollections)
        ];

        return $data;
    }


    // now

    public function ratingCategory(Request $request)
    {
        $type = 'faculty';
        $authId = $request->auth->id;
//        $authId='362';

        $employee = Employee::where('id', $authId)->where('groups', 'like', '%' . $type . '%')->first();

        if ($employee) {
            return TeacherServiceCategory::whereStatus(1)->get();
        }

        return StaffsServiceCategory::whereStatus(1)->get();


    }

    public function ratingDetails(Request $request)
    {

        $type = 'faculty';

        $authId = $request->auth->id;
        $categoryId = $request->categoryId;
//        $authId='362';

        $employee = Employee::where('id', $authId)->where('groups', 'like', '%' . $type . '%')->first();

        if ($employee) {
            $wpEmpRms = WpEmpRms::whereEmail1($employee->office_email)->first();

            $teacherServiceFeedback = TeacherServiceFeedback::with('teacherServiceFeedbackDetails', 'teacherServiceFeedbackDetails.category')
                ->withCount([
                    'teacherServiceFeedbackDetails AS total' => function ($query) use ($categoryId) {
                        $query->select(\DB::raw("SUM(point)"))->where('teacher_service_category_id', $categoryId);
                    }
                ])->whereTeacherId($wpEmpRms->id)->get();

            return $teacherServiceFeedback->sum('total');

        }

        $collections = StaffsServiceInfoFeedbacks::with('staffServiceInfoFeedbackDetails', 'staffServiceInfoFeedbackDetails.category')->withCount([
            'staffServiceInfoFeedbackDetails AS total' => function ($query) use ($categoryId) {
                $query->select(\DB::raw("SUM(point)"))->where('staffs_service_category_id', $categoryId);
            }
        ])->whereEmployeeId($authId)->get();

        return $collections->sum('total');

    }

    public function skillTips(Request $request)
    {

        $authId = $request->auth->id;
//        $authId = '362'; //based sir

        $employee = Employee::where('id', $authId)->first();
        $wpEmpRms = WpEmpRms::whereEmail1($employee->office_email)->first();

        $teacherServiceFeedbacks = ProfileTeacherServiceFeedbackResource::collection(TeacherServiceFeedback::whereTeacherId($wpEmpRms->id)->paginate(50));
        return $teacherServiceFeedbacks;

    }

  
    


}
