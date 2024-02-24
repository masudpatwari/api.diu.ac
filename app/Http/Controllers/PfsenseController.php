<?php

namespace App\Http\Controllers;

use App\classes\DIU_WIFI_With_MAC;
use App\Rules\MacAddressValidate;
use App\WiFiWithMac;
use Illuminate\Http\Request;

class PfsenseController extends Controller
{

    /**
     * Display a listing of the resource.L
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['username'] = explode(',', DIU_WIFI_With_MAC::get_macs());
        return response()->json($data, 200);
    }
 /**
     * Display a listing of the resource.L
     *
     * @return \Illuminate\Http\Response
     */
    public function my_account_list( Request $request)
    {
        $user_id = $request->auth->id;

        $wifiWithMac = WiFiWithMac::where('employee_id', $user_id)->get();

        return response()->json($wifiWithMac, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function user_count()
    {
        $data['number_of_user'] = DIU_WIFI_With_MAC::mac_address_count();

        return response()->json($data,200);
    }


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
            WiFiWithMac::insert([
                'employee_id'=> $finalUserId,
                'mac_address'=> $request->mac_address,
            ]);

            DIU_WIFI_With_MAC::add_mac($request->mac_address);

            return response()->json(['data'=>['success'=>'WiFi Account Created!']], 201);
        }catch (\Exception $exception){
            return response()->json(['error' => 'User Already Exists!'], 400);
        }

    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function search(Request $request)
    {
        $this->validate($request,
            [
                'mac_address' => [ new MacAddressValidate() ],
            ]
        );

        if ( ! DIU_WIFI_With_MAC::check_mac_exists($request->mac_address) ) {

            return response()->json(['error' => 'Mac Address Not Found!'],400);
        }
        return response()->json(['error' => 'Mac Address Found!'],200);

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
    public function destroy(Request $request, $wifiWithMac_id, $user_id=0 )
    {

        if ( $user_id && ( isAdmin() || isSuperAdmin()) ) {
            $wifiInfo = WiFiWithMac::where('employee_id', $user_id)
                ->where('id', $wifiWithMac_id)
                ->first();
        }else {
            $wifiInfo = WiFiWithMac::where('employee_id', $request->auth->id )
                ->where('id', $wifiWithMac_id)
                ->first();
        }


        if ( ! $wifiInfo) {
            return response()->json(['error' => 'User Not Found!'],400);
        }

        if ( DIU_WIFI_With_MAC::delete_mac($request->mac_address) ) {
                $wifiInfo->delete();
            return response()->json(NULL, 204);
        }
        return response()->json(['error' => 'Delete Failed.'], 400);
    }
    
}
