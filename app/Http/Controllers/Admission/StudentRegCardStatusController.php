<?php

namespace App\Http\Controllers\Admission;

use App\Traits\RmsApiTraits;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class StudentRegCardStatusController extends Controller
{
    use RmsApiTraits;

    public function index($department_id)
    {

        $departmentWiseBatchRegCardStatus = $this->departmentWiseBatchRegCardStatus($department_id);

        if (!$departmentWiseBatchRegCardStatus) {

            return response()->json(['error' => 'data not found'], 406);

        }

        return $departmentWiseBatchRegCardStatus;
    }

    public function print($department_id, Request $request)
    {

        $user_id = $request->auth->id;
        $token1 = md5($department_id.$user_id);
        $token2 = md5(date('dymd'));


        return redirect(env('RMS_URL') . '/registration_cards_print/' . $department_id.'/'. $user_id.'/'. $token1.'/'. $token2
            .'/web');
    }

    public function update($batch_id)
    {
        $data = [];
        $data['batch_id'] = $batch_id;

        $batchWiseStudentIdCardStatusUpdate = $this->batchWiseStudentIdCardStatusUpdate($data);

        if (!$batchWiseStudentIdCardStatusUpdate) {
            return response()->json(['error' => 'Reg. card print status update fai;'], 406);
        }

        return response()->json(['message' => 'Reg. card print status updated successfully'], 200);
    }

}

