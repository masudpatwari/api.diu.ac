<?php

namespace App\Http\Controllers;

use App\classes\DIU_WIFI_With_MAC;
use App\Models\STD\Student;
use App\Rules\MacAddressValidate;

use Illuminate\Http\Request;

class StudentPfsenseController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $finalUserId = $request->auth->id;

        if ($request->employee_id) {
            $finalUserId = $request->employee_id;
        }
        $this->validate($request,
            [
                'mac_address' => [ new MacAddressValidate() ],
            ]
        );

        if( DIU_WIFI_With_MAC::check_mac_exists( $request->mac_address ) ){
                return response()->json(['error'=>'MAC address already used'], 400);
        }

        try{
            $student = Student::findOrFail($finalUserId);
            $student->mac_address = $request->mac_address ;
            $student->save();

            DIU_WIFI_With_MAC::add_mac($request->mac_address);

            return response()->json(['data'=>['success'=>'WiFi Account Created!']], 201);
        }catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 400);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param int $wifiWithMac_id
     * @param int $user_id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, $user_id)
    {

        $student = Student::findOrFail($user_id);
        $student->mac_address = null;

        try{
            if ( DIU_WIFI_With_MAC::delete_mac($request->mac_address) ) {
                $student->save();
                return response()->json(['error'=>'MAC deleted'], 202);
            }
            return response()->json(['error' => 'Delete Failed.'], 400);
        }
        catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 400);
        }

    }

}
