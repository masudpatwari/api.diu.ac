<?php

namespace App\Http\Controllers\Admission;

use App\Traits\RmsApiTraits;
use App\Http\Controllers\Controller;


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

