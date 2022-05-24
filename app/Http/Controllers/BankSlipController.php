<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\RmsApiTraits;
use App\Traits\ApplicationForm;


class BankSlipController extends Controller
{
    use RmsApiTraits;
    use ApplicationForm;
    public function index()
    {
        return \App\Models\STD\BankSlip::with('bank_slip_details', 'student')->dsc()->get();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'bank_name' => 'required',
            'branch_name' => 'required',
            'all_fees' => 'required|array',
            'all_fees.*.fee_type' => 'required',
            'all_fees.*.fee_amount' => 'required|integer',
        ]);

        $all_fees_as_array = $request->all_fees;
        $bank_name = $request->bank_name;
        $branch_name = $request->branch_name;

        return $this->bankSlipForm($request->student_id,$all_fees_as_array,$bank_name,$branch_name);
    }

}
