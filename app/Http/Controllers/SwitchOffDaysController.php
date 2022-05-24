<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OfficeTime;
use App\Employee;
use App\User;
use App\SwitchOffDay;
use App\EmployeeUpdateHistory;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\SwitchOffdayResource;
use App\Http\Resources\SwitchOffdayApproveResource;
use App\Http\Resources\SwitchOffdayEditResource;


class SwitchOffDaysController extends Controller
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

    public function index( Request $request )
    {

        $switchOffDay = SwitchOffDay::with('relSupervisorEmployee','relDeletedByEmployee')->withTrashed()->where('employee_id', $request->auth->id)->orderBy('id', 'desc')->get();

        if (!empty($switchOffDay))
        {
            return response()->json(SwitchOffdayResource::collection($switchOffDay), 200);
        }
        return response()->json(NULL, 404);

    }

    public function store(Request $request)
    {
        $this->validate($request,
            [
                'offdayDate' => 'required|date_format:Y-m-d',
                'changeToDate' => 'required|date_format:Y-m-d',
            ],
            [
                'offdayDate.required' => 'Offday Date  is required.',
                'changeToDate.required' => 'Change To Date is required.',
            ]
        );

        /**
        * check if user has any offday or not
        */
        $offdayOfficeTimes = OfficeTime::where(['employee_id' => $request->auth->id, 'offDay'=> 1])->pluck('day')->toArray();
        $offdayDateTimestamp = strtotime($request->offdayDate);
        $changeToDateTimestamp = strtotime($request->changeToDate);

        if ( count($offdayOfficeTimes) )
        {
            /*
            * has offDay
            * need to check
            * 1. offDay date is not used OR
            * 2. changeToDate is not used.
            */

            $offdayDateIsUsed = SwitchOffDay::where([
                'offdayDate'=> $offdayDateTimestamp,
                'employee_id'=> $request->auth->id
            ])->get();

            $changeToDateIsUsed = SwitchOffDay::Where([
                'changeToDate'=> $changeToDateTimestamp,
                'employee_id'=> $request->auth->id
            ])
            ->get();

            $dateUsedErrorArray = [];

            if($offdayDateIsUsed->count()){
                $dateUsedErrorArray[] = 'OffDay Date OR Changed Date is already switched';
            }

            if($changeToDateIsUsed->count()){
                $dateUsedErrorArray[] = 'OffDay Date OR Changed Date is already switched.';
            }
            if ($dateUsedErrorArray)
            {
                return response()->json([
                    'error' => implode('.',$dateUsedErrorArray)
                ], 400);
            }


            /*
            * need to check
            * 1. offDay date is really offday
            * 2. changeToDate is not really offDay.
            */
            $OffdayName = date("l", $offdayDateTimestamp );
            $changeToDateName = date("l", $changeToDateTimestamp );
            if ( in_array($OffdayName, $offdayOfficeTimes ) && !in_array( $changeToDateName, $offdayOfficeTimes ))
            {
                $switchOffDay = SwitchOffDay::create([
                    'employee_id'=> $request->auth->id,
                    'offdayDate' => $offdayDateTimestamp,
                    'changeToDate' => $changeToDateTimestamp,
                    'supervisor_id' => Employee::supervised_by($request->auth->id),
                ]);

                if (!empty($switchOffDay->id)) {
                    return response()->json($switchOffDay, 201);
                }
            }

            return response()->json(['error' => 'OffDay Date is not Offday. Or Changed Date is OffDay'], 400);
        }else {
            return response()->json(['error' => 'You Have not any OffDay.'], 400);
        }

    }

    public function update(Request $request, $id)
    {
        $this->validate($request,
            [
                'offdayDate' => 'required|date_format:Y-m-d',
                'changeToDate' => 'required|date_format:Y-m-d',
            ],
            [
                'offdayDate.required' => 'Offday Date  is required.',
                'changeToDate.required' => 'Change To Date is required.',
            ]
        );

        $isUpdateable = SwitchOffDay::where(['approvedBySupervisor'=>'1', 'id'=> $id, 'employee_id'=> $request->auth->id])->count();

        if ( $isUpdateable ) {
            return response()->json(['error' => 'Switch Offday application is approved. You cannot update.'], 400);
        }

        /**
        * check if user has any offday or not
        */
        $offdayOfficeTimes = OfficeTime::where(['employee_id' => $request->auth->id, 'offDay'=> 1])->pluck('day')->toArray();
        $offdayDateTimestamp = strtotime($request->offdayDate);
        $changeToDateTimestamp = strtotime($request->changeToDate);

        /*
        * need to check
        * 1. offDay date is not used OR
        * 2. changeToDate is not used.
        */

        $offdayDateIsUsed = SwitchOffDay::where([
            'offdayDate'=> $offdayDateTimestamp,
            'employee_id'=> $request->auth->id
        ])->where('id','<>',$id)->get();

        $changeToDateIsUsed = SwitchOffDay::Where([
            'changeToDate'=> $changeToDateTimestamp,
            'employee_id'=> $request->auth->id
        ])->where('id','<>',$id)->get();

        $dateUsedErrorArray = [];

        if($offdayDateIsUsed->count()){
            $dateUsedErrorArray[] = 'OffDay Date OR Changed Date is already switched';
        }

        if($changeToDateIsUsed->count()){
            $dateUsedErrorArray[] = 'OffDay Date OR Changed Date is already switched.';
        }
        if ($dateUsedErrorArray) {
            return response()->json(['error' => implode('.',$dateUsedErrorArray)], 400);
        }

        /*
        * need to check
        * 1. offDay date is really offday
        * 2. changeToDate is not really offDay.
        */
        $OffdayName = date("l", $offdayDateTimestamp );
        $changeToDateName = date("l", $changeToDateTimestamp );
        if ( in_array($OffdayName, $offdayOfficeTimes ) && !in_array( $changeToDateName, $offdayOfficeTimes ))
        {
            $supervisor_id = Employee::supervised_by($request->auth->id);
            $switchOffDay = SwitchOffDay::where('id',$id)->update([
                'offdayDate' => $offdayDateTimestamp,
                'changeToDate' => $changeToDateTimestamp,
            ]);

            if (!empty($switchOffDay)) {
                return response()->json([
                    SwitchOffDay::find($id)
                ], 201);
            }
        }
        else {
            return response()->json(['error' => 'OffDay Date is not Offday. Or Changed Date is OffDay'], 400);
        }
    }

    public function show(Request $request,$id)
    {
        $switchOffDay = SwitchOffDay::find($id);
        if ($switchOffDay->employee_id == $request->auth->id || $switchOffDay->supervisor_id == $request->auth->id || isSuperAdmin() || isAdmin())
        {
            return response()->json([
                $switchOffDay
            ], 200);
        }
        else
        {
            return response()->json(['error' => 'You Have No Permission to show.'], 400);
        }

    }

    public function edit(Request $request,$id)
    {
        //  trashed data will not show because we are using SoftDeletes
        $switchoffday = SwitchOffDay::where(['employee_id'=> $request->auth->id, 'approvedBySupervisor'=> '0'])->find($id);
        if (!empty($switchoffday))
        {
            return new SwitchOffdayEditResource($switchoffday);
        }
        return response()->json(NULL, 404);
    }



    public function show_pending_switchoffday( Request $request, $user_id = null )
    {

        $setUserId = $request->auth->id;
        if ( $user_id != null )
        {
            $setUserId = (int)$user_id;
        }

      $switchOffDays = SwitchOffDay::with('relSupervisorEmployee','relCreatedByEmployee')
      ->where(['approvedBySupervisor' => 0, 'supervisor_id' => $setUserId])->get();

        if ($switchOffDays->count())
        {
            return response()->json(SwitchOffdayResource::collection($switchOffDays), 200);
        }

        return response()->json(['error'=>"Not Found!"], 404);
    }

    public function show_approved_switchoffday( Request $request, $user_id = null )
    {
        $setUserId = $request->auth->id;

        if ( $user_id != null )
        {
            $setUserId = (int)$user_id;
        }

        $switchOffDays = SwitchOffDay::where(['approvedBySupervisor' => 1, 'employee_id' => $setUserId])->get();

        if ($switchOffDays->count())
        {
            return response()->json(SwitchOffdayApproveResource::collection($switchOffDays), 200);
        }

        return response()->json(['error'=>"Not Found!"], 404);
    }

    public function show_deleted_switchoffday( Request $request, $user_id = null )
    {
        $setUserId = $request->auth->id;

        if ( $user_id != null )
        {
            $setUserId = (int)$user_id;
        }

        $switchOffDays = SwitchOffDay::onlyTrashed()->where(['employee_id' => $setUserId])->get();

        if ($switchOffDays->count())
        {
            return response()->json(SwitchOffdayResource::collection($switchOffDays), 200);
        }

        return response()->json(['error'=>"Not Found!"], 404);
    }

    public function destroy( Request $request, $id = null )
    {
        $switchoffday = SwitchOffDay::find($id);
        if ($switchoffday->employee_id == $request->auth->id || $switchoffday->supervisor_id == $request->auth->id || isSuperAdmin() || isAdmin()) {
            if ($switchoffday->delete()) {
                $switchoffday->deleted_by = $request->auth->id;
                $switchoffday->save();
                return response()->json(NULL, 204);
            }
            return response()->json(['error' => 'Delete Failed.'], 400);
        }
        return response()->json(NULL, 404);
    }

    public function approve( Request $request, $id = null )
    {
        $switchoffday = SwitchOffDay::where('supervisor_id', $request->auth->id)->find($id);
        if (!empty($switchoffday)) {
            $switchoffday->approvedBySupervisor = 1;
            if (!empty($switchoffday->save())) {
                return response()->json(NULL, 204);
            }
            return response()->json(['error' => 'Approved Failed.'], 400);
        }
        return response()->json(NULL, 404);
    }
}
