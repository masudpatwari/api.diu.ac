<?php

namespace App\Http\Controllers\Admission;

use App\Models\Admission\Thana;
use App\Traits\RmsApiTraits;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdmissionFetchDataController extends Controller
{
    use RmsApiTraits;

    public function shiftsIndex(Request $request)
    {
        $shifts = $this->shifts();
        if (!$shifts) {
            return response()->json(['error' => 'data not found'], 406);
        }
        return $shifts;
    }

    public function groupsIndex(Request $request)
    {
        $groups = $this->groups();
        if (!$groups) {
            return response()->json(['error' => 'data not found'], 406);
        }
        return $groups;
    }

    public function religionIndex(Request $request)
    {
        $groups = $this->religion();
        if (!$groups) {
            return response()->json(['error' => 'data not found'], 406);
        }
        return $groups;
    }

    public function division()
    {
        return \App\Models\Admission\Division::all();
    }

    public function district($division_id)
    {
        return \App\Models\Admission\District::whereDivisionId($division_id)->get();
    }

    public function upazila($district_id)
    {
        return Thana::whereDistrictId($district_id)->get();
    }

    public function union($upazila_id)
    {
        return \App\Models\Admission\Union::whereThanaId($upazila_id)->get();
    }

    public function country()
    {

        $country = $this->countriesList();
        if (!$country) {
            return response()->json(['error' => 'data not found'], 406);
        }
        return $country;
    }

    public function refereedByParent()
    {
        $refereedByParents = $this->refereedByParents();
        if (!$refereedByParents) {
            return response()->json(['error' => 'data not found'], 406);
        }
        return $refereedByParents;
    }

    public function refereedChildByParent($parent_id)
    {
        $refereedByParents = $this->refereedChildByParents($parent_id);
        if (!$refereedByParents) {
            return response()->json(['error' => 'data not found'], 406);
        }
        return $refereedByParents;
    }

    public function campus()
    {
        $campus = $this->rmsCampus();
        if (!$campus) {
            return response()->json(['error' => 'data not found'], 406);
        }
        return $campus;
    }

    public function paymentSystem()
    {
        $rmsPaymentSystem = $this->rmsPaymentSystem();
        if (!$rmsPaymentSystem) {
            return response()->json(['error' => 'data not found'], 406);
        }
        return $rmsPaymentSystem;
    }

    public function departmentWiseInactiveBatch($department_id)
    {
        $fetchDepartmentWiseInactiveBatch = $this->fetchDepartmentWiseInactiveBatch($department_id);

        if (!$fetchDepartmentWiseInactiveBatch) {
            return response()->json(['error' => 'data not found'], 406);
        }

        return $fetchDepartmentWiseInactiveBatch;
    }

}
