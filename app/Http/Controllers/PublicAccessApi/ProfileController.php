<?php

namespace App\Http\Controllers\PublicAccessApi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Employee;
use App\ShortPosition;
use App\Designation;
use App\Http\Resources\EmployeeProfileResource;
use App\Http\Resources\EmployeeShortDetailsResource;


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

    public function slug_profile($slug)
    {
        $employees = Employee::where('slug_name', $slug)->first();
        if (!empty($employees))
        {
            return new EmployeeProfileResource($employees);
        }
        return response()->json(NULL, 404);
    }

    public function get_faculty_teachers( $dept_short_code = '' )
    {

        $dept_short_code = strtolower($dept_short_code);

        $t_shortcode_array  = [
            'cse'=>['T_CSE%','C_CSE%','D_CSE','DB_G'],
            'eete'=>['T_EETE%','C_EETE%','DB_G','D_CSE'],
            'law'=>['T_LAW%','C_LAW%','CO_LAW_G'],
            'eng'=>['T_ENG%','C_ENG%','T_ILID'],
            'pha'=>['T_PHA%','C_PHA%','D_CSE','DB_G'],
            'soc'=>['T_SOC%','C_SOC%','C_POL%'],
            'bba'=>['T_BBA%','C_BBA%','CO_BBA_G','DB_B','REG'],
            'civil'=>['T_CIVIL%','C_CIVIL%','CO_CIVIL'],
            'pol'=>['T_POL%','C_POL%','CO_POL'],
            'eco'=>['REG','T_SOC%','C_SOC%','C_POL%','T_POL%','C_POL%','CO_POL%','T_CECD%','T_ILID'],

        ];
        $short_position = ShortPosition::orderBy('id', 'DESC');
        if( strlen($dept_short_code) > 0 && array_key_exists($dept_short_code, $t_shortcode_array) ){
            foreach ($t_shortcode_array[$dept_short_code] as  $code) {
                $short_position->orwhere('name', 'like', $code);
            }
        }
        else
        {
            $short_position->where('name', 'like', 'T%');
            $short_position->orwhere('name', 'like', 'C%');
        }
        $short_position_ids = $short_position->pluck('id');

        $employees = Employee::with(['relDepartment', 'relDesignation'])->whereIn('shortPosition_id', $short_position_ids)->where('activestatus', 1)->orderBy('merit', 'DESC')->get();
        if (!empty($employees))
        {
            return EmployeeShortDetailsResource::collection($employees);
        }
        return response()->json(NULL, 404);
    }

    public function get_key_resource_person()
    {

        $positions = ['%chairman%','%dean%','%Prof%','%Adv%','%Barrister%','%Judge%','%Tex%','%Court%'];
        $positionIdArray =  Designation::where(function($q)use($positions){
            foreach ($positions as  $value) {
                    $q->orWhere('name','like',$value);
                }
        })->pluck('id')->toArray();

        $employees = Employee::with(['relDepartment', 'relDesignation'])
        ->whereIn('designation_id',$positionIdArray)
        ->where('activestatus', 1)->orderBy('merit', 'DESC')->get();
 
        if (!empty($employees))
        {
            return EmployeeShortDetailsResource::collection($employees);
        }
        return response()->json(NULL, 404);
    }

    public function get_department_chairman( $dept_short_code = '' )
    {

        $dept_short_code = strtolower($dept_short_code);

        $t_shortcode_array  = [
            'cse'   => 'C_CSE',
            'eete'  => 'C_EETE',
            'law'   => 'C_LAW%',
            'eng'   => 'C_ENG',
            'pha'   => 'C_PHA',
            'soc'   => 'C_SOC',
            'bba'   => 'C_BBA%',
            'civil' => 'C_CIVIL',
            'pol'   => 'C_POL',
            'eco'   => 'REG',
        ];
        $short_position = NULL;
        if( strlen($dept_short_code) > 0 && array_key_exists($dept_short_code, $t_shortcode_array) ){
            $short_position = ShortPosition::where('name', 'like', $t_shortcode_array[$dept_short_code])->orderBy('id', 'DESC')->first();
        }


        if (!empty($short_position)) {
            $employee = Employee::with(['relDepartment', 'relDesignation'])->where('shortPosition_id', $short_position->id)->where('activestatus', 1)->orderBy('merit', 'DESC')->first();
            if (!empty($employee))
            {
                return new EmployeeShortDetailsResource($employee);
            }
        }
        return response()->json(NULL, 404);
    }
}
