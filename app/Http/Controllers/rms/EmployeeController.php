<?php

namespace App\Http\Controllers\rms;

use Illuminate\Http\Request;
use App\Models\RMS\WpEmpRms;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Resources\rms\WpEmpRmsResource;
use App\Http\Resources\EmployeeResource;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return response()->json( WpEmpRmsResource::collection(WpEmpRms::get()) , 200);
    }

    public function lockedUsers()
    {
        return response()->json( WpEmpRmsResource::collection(WpEmpRms::getLockedRmsUser()) , 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cmsSyncToRms(Request $request)
    {
        $responseText = [
            400 => [ 'type'=>'fail','title' => 'Not Found!'],
            200 => [ 'type'=>'success','title' => 'User Updated to RMS!'],
            201 => [ 'type'=>'success','title' => 'User Transfared to RMS!'],
        ];

        $this->validate($request,[
            'employee_id' => 'bail|required|integer'
        ]);

        try{

            $returnStatus = WpEmpRms::cmsSyncToRms($request->employee_id);
        }
        catch (\Exception $ex){
            return response()->json(['error'=>$ex->getMessage()], 400);
        }

        return response()->json([
            $responseText[$returnStatus]['type'] =>
            $responseText[$returnStatus]['title']
        ], $returnStatus);
    }

    public function employeeExistsInRms($cmsEmpId)
    {
        $rmsEmployee = WpEmpRms::employeeExistsInRms($cmsEmpId);
        if (! $rmsEmployee) {
                $rmsEmployee = "Not Exists In RMS!";
        }

        return response()->json(EmployeeResource::collection($rmsEmployee), 200);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ( WpEmpRms::destroy($id) ) {
            return response()->json(["success"=>"Employee In RMS now in Inactive"],200);
        }
        return response()->json(["error"=>"RMS Employee Inactive Fail"],400);
    }

    public function lockEmployee($rmsEmployeeId)
    {
        if( WpEmpRms::lockEmployeeOnRms($rmsEmployeeId) )
        {
            return response()->json( ['success'=>"User Lock Successfull in RMS"] , 200);
        }

        return response()->json( ['fail'=>"User Lock Unsuccessfull in RMS"] , 400);
    }

    public function unlockEmployee($rmsEmployeeId)
    {
        if( WpEmpRms::unlockEmployeeOnRms($rmsEmployeeId) )
        {
            return response()->json( ['success'=>"User Unlock Successfull in RMS"] , 200);
        }
        return response()->json( ['fail'=>"User Unlock Unsuccessfull in RMS"] , 400);

    }

    public function rmsUserNotFound($cmsEmpId)
    {
        if( ! $emp = WpEmpRms::employeeExistsInRms($cmsEmpId)){
            return response()->json(['error'=>'User Not Exsist in RMS!'] , 400);
        }

        return response()->json( ['success'=>"User Exists in RMS"] , 200);
    }

    public function employeeNotInRms()
    {
        $empsFromCMS = WpEmpRms::cmsEmployeeNotInRms();
        return response()->json( EmployeeResource::collection($empsFromCMS) , 200);
    }

}
