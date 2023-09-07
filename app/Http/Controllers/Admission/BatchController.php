<?php

namespace App\Http\Controllers\Admission;

use App\Models\Admission\StudentSignature;
use App\Traits\RmsApiTraits;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class BatchController extends Controller
{
    use RmsApiTraits;

    public function index(Request $request)
    {

        $page_number = $request->page;
        $batchIndex = $this->batchIndex($page_number);

        if (!$batchIndex) {

            return response()->json(['error' => 'data not found'], 406);

        }

        return $batchIndex;
    }

    public function edit($id)
    {

        $batchIndex = $this->batchEdit($id);

        if (!$batchIndex) {

            return response()->json(['error' => 'data not found'], 406);

        }

        return $batchIndex;
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'department_id' => 'required|integer',
            'group_id' => 'required|integer',
            'shift_id' => 'required|integer',
            'campus_id' => 'required|integer',
            'batch_name' => 'required',
            'said_fee' => 'required|numeric',
            'common_scholarship' => 'required|numeric',
            'number_of_semester' => 'required|integer',
            'duration_of_semester' => 'required|integer',
            'no_of_seat' => 'required|integer',
            'year' => 'required|integer',
            'session' => 'required',
            'admission_season' => 'required|integer',
            'active' => 'required|in:0,1',
            'id_card_expiration_date' => 'required|date',
            'class_start_date' => 'required|date',
            'last_data_of_admission' => 'required|date',
            'payment_system' => 'required|integer',
            'admission_start_date' => 'required|date',
        ]);

        try {
            $data = $request->all();
            unset($data['token']);
            $data['created_by_email'] = $request->auth->office_email;

            $batch = $this->activeBatchStore($data);

            return response()->json(['message' => 'Batch create successfully'], 200);
        } catch (\Exception $e) {

            dump(\Log::error(print_r($e->getMessage(), true)));
            return response()->json(['error' => $e->getMessage()], 404);

        }

    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'id' => 'required|integer',
            'department_id' => 'required|integer',
            'group_id' => 'required|integer',
            'shift_id' => 'required|integer',
            'campus_id' => 'required|integer',
            'said_fee' => 'required|numeric',
            'common_scholarship' => 'required|numeric',
            'no_of_semester' => 'required|integer',
            'duration_of_sem_m' => 'required|integer',
            'no_seat' => 'required|integer',
            'sess' => 'required',
            'valid_d_idcard' => 'required|date',
            'active_status' => 'required|integer',
            'class_str_date' => 'required|date',
            'last_date_of_adm' => 'required|date',
            'batch_name' => 'required',
            'payment_system_id' => 'required|integer',
            'admission_start_date' => 'required|date',
            'adm_year' => 'required',
            'adm_season' => 'required|integer',
        ]);

        try {
            $data = $request->all();
            unset($data['token']);

            $batch = $this->batchDataUpdate($data);

            return response()->json(['message' => 'Batch updated successfully'], 200);
        } catch (\Exception $e) {

            dump(\Log::error(print_r($e->getMessage(), true)));
            return response()->json(['error' => $e->getMessage()], 404);

        }
    }

}
