<?php

namespace App\Http\Controllers\STD;

use App\Traits\MetronetSmsTraits;
use App\Traits\RmsApiTraits;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TranscriptDepartment;
use App\Transcript;
use App\Http\Resources\TranscriptVerificationResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\TranscriptEditMail;
use App\Employee;

class StudentTranscriptController extends Controller
{
    use MetronetSmsTraits, RmsApiTraits;

    public function transcript_department()
    {
        $departments = TranscriptDepartment::orderBy('name', 'asc')->pluck('name', 'id');
        if (!empty($departments)) {
            return response()->json($departments, 200);
        }
        return response()->json(['error' => 'Transcript not found'], 400);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->validate($request,
            [
                'department_id' => 'required|numeric|exists:transcriptDepartments,id',
                'reg_code' => 'nullable|exists:transcripts,regcode',
                'shift' => 'nullable|in:First Shift,Second Shift,Friday-Saturday',
            ]
        );
        $department_id = $request->input('department_id');
        $name = $request->input('student_name');
        $regcode = $request->input('reg_code');
        $batch = $request->input('batch');
        $roll = $request->input('roll');
        $session = $request->input('session');
        $passing_year = $request->input('passing_year');

        if (strlen(implode('', array_values([$name, $regcode, $batch, $roll, $session, $passing_year]))) == 0) {
            return response()->json(['error' => 'Please fillout one more field.'], 400);
        }

        $transcripts = Transcript::where('transcript_department_id', $department_id);
        if (!empty($name)) {
            $transcripts->where('name', 'like', '%' . $name . '%');
        }
        if (!empty($regcode)) {
            $transcripts->where('regcode', $regcode);
        }
        if (!empty($batch)) {
            $transcripts->where('batch', 'like', '%' . $batch . '%');
        }
        if (!empty($roll)) {
            $transcripts->where('roll', $roll);
        }
        if (!empty($session)) {
            $transcripts->where('session', $session);
        }
        if (!empty($passing_year)) {
            $transcripts->where('passing_year', $passing_year);
        }

        $result = $transcripts->orderBy('id', 'desc')->get();

        if (!empty($result) && count($result) > 0) {
            $resource = TranscriptVerificationResource::collection($result);
            return response()->json($resource, 200);
        }
        return response()->json(['error' => 'Transcript not found'], 400);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        if(isset($request->draft))
        {
            $draft = $request->draft;
        }
        $this->validate($request,
            [
                'department_id' => 'required|numeric|exists:transcriptDepartments,id',
                'student_name' => 'required',
                'reg_code' => 'required|max:25',
                'cgpa' => 'required',
                'batch' => 'required',
                'roll' => 'required|numeric',
                'shift' => 'required|in:First Shift,Second Shift,Friday-Saturday',
                'session' => 'required',
                'passing_year' => 'required|numeric',
                'transcript_file' => 'nullable|mimes:jpg,jpeg,pdf|max:1024',
            ]
        );

        $transcript_array = [
            'transcript_department_id' => $request->input('department_id'),
            'name' => $request->input('student_name'),
            'regcode' => trim($request->input('reg_code')),
            'cgpa' => $request->input('cgpa'),
            'batch' => $request->input('batch'),
            'roll' => $request->input('roll'),
            'shift' => $request->input('shift'),
            'session' => $request->input('session'),
            'passing_year' => $request->input('passing_year'),
            'has_file' => 0,
            'drafted' => isset($draft) ? 1 : 0,
            'created_at' => time(),
            'created_by' => $request->auth->id,
        ];

        $regcode_exists = Transcript::where('regcode', $transcript_array['regcode'])->exists();
        if ($regcode_exists) {
            return response()->json(['error' => 'Transcript reg code already exists'], 400);
        }

        try {
            DB::beginTransaction();

            if ($request->hasFile('transcript_file') && $request->file('transcript_file')->isValid()) {
                $file = $request->file('transcript_file');
                $extention = strtolower($file->getClientOriginalExtension());
                $fileName = '' . $transcript_array['regcode'] . '-' . $transcript_array['roll'] . '.' . $extention;
                $request->file('transcript_file')->move(storage_path('transcripts'), 'transcripts/' . $fileName);
                $transcript_array['filename'] = $fileName;
                $transcript_array['has_file'] = 1;
            }
            Transcript::insert($transcript_array);

            DB::commit();
            return response()->json(['success' => 'Transcript upload Successfull.'], 201);
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(['error' => 'Transcript upload Failed.'], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store_temp(Request $request)
    {
        $this->validate($request,
            [
                'department_id' => 'required|numeric|exists:transcriptDepartments,id',
                'student_name' => 'required',
                'reg_code' => 'required',
                'cgpa' => 'required',
                'batch' => 'required',
                'roll' => 'required|numeric',
                'shift' => 'required|in:First Shift,Second Shift,Friday-Saturday',
                'session' => 'required',
                'passing_year' => 'required|numeric',
            ]
        );

        $transcript_array = [
            'transcript_department_id' => $request->input('department_id'),
            'name' => $request->input('student_name'),
            'regcode' => trim($request->input('reg_code')),
            'cgpa' => $request->input('cgpa'),
            'batch' => $request->input('batch'),
            'roll' => $request->input('roll'),
            'shift' => $request->input('shift'),
            'session' => $request->input('session'),
            'passing_year' => $request->input('passing_year'),
            'has_file' => 0,
            'created_at' => time(),
            'created_by' => $request->auth->id,
        ];

        $regcode_exists = Transcript::where('regcode', $transcript_array['regcode'])->exists();

        if ($regcode_exists) {
            return response()->json(['error' => 'Transcript reg code already exists'], 400);
        }

        $transcript_array['filename'] = '';
        $transcript_array['has_file'] = 0;
        Transcript::insert($transcript_array);

        return response()->json(['success' => 'Transcript added Successful.'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $transcript = Transcript::find($id);
        //
        //        if ( $transcript->verified == 1 ){
        //
        //            return response()->json(['error' => 'Transcript already verified. Verified Transcript will be edited.'], 400);
        //        }

        if (!empty($transcript)) {
            return new TranscriptVerificationResource($transcript);
            return response()->json($resource, 200);
        }
        return response()->json(['error' => 'Transcript not found'], 400);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function editByCreator(Request $request, $id)
    {
        return
        $transcript = Transcript::find($id);

        if(!empty($transcript)){
            if($transcript->created_by == $request->auth->id){
                return new TranscriptVerificationResource($transcript);
            }
            return response()->json(['error' => 'Transcript not found'], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        //        dump(\Log::error(print_r($request->all(),true)));

        $this->validate($request,
            [
                'department_id' => 'required|numeric|exists:transcriptDepartments,id',
                'student_name' => 'required|string',
                'reg_code' => 'required|max:25',
                'cgpa' => 'required',
                'batch' => 'required',
                'roll' => 'required|numeric',
                'shift' => 'required|in:First Shift,Second Shift,Friday-Saturday',
                'session' => 'required',
                'passing_year' => 'required|numeric',
                'transcript_file' => 'nullable|mimes:jpg,jpeg,pdf|max:1024',
            ]
        );

        $tArray = [
            'transcript_department_id' => $request->input('department_id'),
            'name' => $request->input('student_name'),
            'regcode' => $request->input('reg_code'),
            'cgpa' => $request->input('cgpa'),
            'batch' => $request->input('batch'),
            'roll' => $request->input('roll'),
            'shift' => $request->input('shift'),
            'drafted' => 0,
            'session' => $request->input('session'),
            'passing_year' => $request->input('passing_year'),
            'updated_at' => time(),
            'updated_by' => $request->auth->id,
        ];

        $regcode_exists = Transcript::where('id', '!=', $id)->where('regcode', $tArray['regcode'])->exists();
        if ($regcode_exists) {
            return response()->json(['error' => 'Transcript reg code already exists'], 400);
        }

        try {
            DB::beginTransaction();
            $transcript = Transcript::where('id', $id)->first();
            if ($transcript->verified == 1) {
                return response()->json(['error' => 'Verified Transcript Will Not Be Edited'], 400);

            }
            if ($request->hasFile('transcript_file') && $request->file('transcript_file')->isValid()) {
                $oldFileName = $transcript->filename;
                $file = $request->file('transcript_file');
                $extention = strtolower($file->getClientOriginalExtension());
                $fileName = '' . $tArray['regcode'] . '-' . $tArray['roll'] . '.' . $extention;
                $request->file('transcript_file')->move(storage_path('transcripts'), 'transcripts/' . $oldFileName);
                rename(storage_path('transcripts') . '/' . $oldFileName, storage_path('transcripts') . '/' . $fileName);
                $tArray['filename'] = $fileName;
                $tArray['has_file'] = 1;
            } else {
                if (($transcript->roll != $tArray['roll']) || ($transcript->regcode != $tArray['regcode'])) {
                    if (!empty($transcript->filename)) {
                        $exists_file_extention = explode('.', $transcript->filename)[1];
                        $fileName = $tArray['regcode'] . '-' . $tArray['roll'] . '.' . $exists_file_extention;
                        $oldFilePath = storage_path('transcripts') . '/' . $transcript->filename;

                        if (file_exists($oldFilePath)) {
                            rename($oldFilePath, storage_path('transcripts') . '/' . $fileName);
                            $tArray['filename'] = $fileName;
                        }
                    }
                }
            }
            Transcript::where(['id' => $id])->update($tArray);

            DB::commit();
            return response()->json(['success' => 'Transcript upload Successfull.'], 201);
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(['error' => 'Transcript upload Failed.'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $id)
    {
        $transcript = Transcript::find($id);
        if (!empty($transcript)) {

            if ($transcript->verified == 1) {
                return response()->json(['error' => 'Verified Transcript Not Deleted.'], 400);
            }
            try {
                DB::beginTransaction();
                Transcript::where(['id' => $id])->update([
                    'deleted_at' => time(),
                    'deleted_by' => $request->auth->id
                ]);
                DB::commit();
                return response()->json(['success' => 'Transcript delete Successfull.'], 200);
            } catch (\PDOException $e) {
                return response()->json(['error' => 'Transcript delete Failed.'], 400);
                DB::rollBack();
            }
        }
        return response()->json(['error' => 'Delete Failed.'], 400);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function trashed(Request $request)
    {
        $transcripts = Transcript::onlyTrashed()->get();
        if (!empty($transcripts)) {
            return response()->json($transcripts, 200);
        }
        return response()->json(['error' => 'Transcript not found'], 400);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $id)
    {
        $transcript = Transcript::onlyTrashed()->where(['id' => $id])->first();
        if (!empty($transcript)) {
            $regcode_exists = Transcript::where('regcode', $transcript->regcode)->exists();
            if ($regcode_exists) {
                return response()->json(['error' => 'Transcript already exists.'], 400);
            }
            try {
                DB::beginTransaction();
                $transcript->update([
                    'updated_at' => time(),
                    'updated_by' => $request->auth->id,
                    'deleted_at' => NULL,
                    'deleted_by' => NULL
                ]);
                DB::commit();
                return response()->json(['success' => 'Transcript restore Successful.'], 200);
            } catch (\PDOException $e) {
                return response()->json(['error' => 'Transcript restore Failed.'], 400);
                DB::rollBack();
            }
        }
        return response()->json(['error' => 'Transcript not found.'], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $transcript = Transcript::onlyTrashed()->where('verified', 0)->where(['id' => $id])->first();
        if (!empty($transcript)) {
            $filename = storage_path('transcripts') . '/' . $transcript->filename;
            try {
                DB::beginTransaction();
                if (file_exists($filename)) {
                    unlink($filename);
                }
                $transcript->forceDelete();
                DB::commit();
                return response()->json(['success' => 'Transcript delete Successfull.'], 200);
            } catch (\PDOException $e) {
                return response()->json(['error' => 'Transcript delete Failed.'], 400);
                DB::rollBack();
            }
        }
        return response()->json(['error' => 'Transcript not found'], 400);
    }

    public function unverified_list(Request $request)
    {


        $transcripts = null;

        if ($request->transcript_department_id) {

            $transcripts = Transcript::orderBy('transcript_department_id', 'batch', 'roll')
                ->with('relDepartments', 'relCreatedBy')
                ->where('verified', 0)
                ->where('rejected', 0)
                ->where('drafted', 0)
                ->orderBy('id');

            if ($request->transcript_department_id != '*') {
                $transcripts->where('transcript_department_id', $request->transcript_department_id);
            }

        }

        $transcripts = $transcripts->get();

        if (!empty($transcripts)) {
            return response()->json($transcripts, 200);
        }
        return response()->json(['error' => 'No Transcript is unverified'], 400);
    }

    public function rejected_or_drafted(Request $request)
    {

        $transcripts = Transcript::orderBy('transcript_department_id', 'batch', 'roll')
            ->with('relDepartments', 'relCreatedBy')
            ->where('drafted', 1)
            ->where('created_by', $request->auth->id)
            ->orWhere('rejected', 1)
            ->orderBy('id');

        $transcripts = $transcripts->get();

        if (!empty($transcripts)) {
            return response()->json($transcripts, 200);
        }
        return response()->json(['error' => 'No Transcript Found'], 400);
    }

    public function verify(Request $request, $id)
    {
        $transcript = Transcript::find($id);
        $otp = rand(0000, 9999);

        if (!empty($transcript)) {

            $studentInfo = $this->studentInfoWithCompleteSemesterResultByRegCode($transcript->regcode);

            $transcript->verified = 1;
            $transcript->updated_at = time();
            $transcript->updated_by = $request->auth->id;
            $transcript->otp = $otp;
            $transcript->save();

            if ($studentInfo['student']['phone_no']) {
                $message = "Dear {$studentInfo['student']['name']} your Transcript/Certificate is Ready for Delivery. Please collect from our respective office. Your OTP is {$otp} which is required to take delivery.";
                $this->send_sms($studentInfo['student']['phone_no'],$message);
            }

            return response()->json('Transcript Verified', 200);
        }
        return response()->json(['error' => 'No Transcript Found!'], 400);
    }

    public function reject(Request $request, $id)
    {
        $transcript = Transcript::find($id);
        // $otp = rand(0000, 9999);

        if (!empty($transcript)) {


            $transcript->verified = 0;
            $transcript->rejected = 1;
            $transcript->updated_at = time();
            $transcript->updated_by = $request->auth->id;
            $transcript->save();

            return response()->json('Transcript Rejected', 200);
        }
        return response()->json(['error' => 'No Transcript Found!'], 400);
    }


    public function findByRegCode(Request $request)
    {
        if (!$request->has('reg_code')) {
            return response()->json(['message' => 'Reg Code is empty!'], 400);
        }

        $transcript = Transcript::with('relDepartments')->where('regcode', 'like', '%' . $request->reg_code . '%')->get();

        if ($transcript->count()) {
            return $transcript;
        }

        return response()->json(['message' => 'Transcript not found!'], 400);

    }

    public function findById($id)
    {
        $transcript = Transcript::with('relDepartments')->where('id', $id)->first();

        if ($transcript) {
            return $transcript;
        }

        return response()->json(['message' => 'Transcript not found!'], 400);

    }

    public function deleteById(Request $request, $id)
    {
        $transcript = Transcript::where('id', $id)->first();

        if (!$transcript) {
            return response()->json(['message' => 'Transcript Not Found By ID!'], 200);
        }

        if ($transcript->filename == '') {
            $oldFileName = $transcript->filename;
            if (file_exists(storage_path('transcripts') . '/' . $oldFileName)) {
                @unlink(storage_path('transcripts') . '/' . $oldFileName);
            }
        }

        $transcript->update(['deleted_at' => time(), 'deleted_by' => $request->auth->id]);

        return response()->json(['message' => 'Transcript Deleted!'], 200);

    }

    public function updateByViceChairman(Request $request, $id)
    {

        $this->validate($request,
            [
                'department_id' => 'required|numeric|exists:transcriptDepartments,id',
                'student_name' => 'required|string',
                'reg_code' => 'required',
                'cgpa' => 'required',
                'batch' => 'required',
                'roll' => 'required|numeric',
                'shift' => 'required|in:First Shift,Second Shift,Friday-Saturday',
                'session' => 'required',
                'passing_year' => 'required|numeric',
                'transcript_file' => 'nullable|mimes:jpg,jpeg,pdf|max:1024',
            ]
        );

        $tArray = [
            'transcript_department_id' => $request->input('department_id'),
            'name' => $request->input('student_name'),
            'regcode' => $request->input('reg_code'),
            'cgpa' => $request->input('cgpa'),
            'batch' => $request->input('batch'),
            'roll' => $request->input('roll'),
            'shift' => $request->input('shift'),
            'drafted' => 0,
            'session' => $request->input('session'),
            'passing_year' => $request->input('passing_year'),
            'updated_at' => time(),
            'updated_by' => $request->auth->id,
        ];


        try {
            DB::beginTransaction();

            if (Transcript::where('regcode', $request->input('reg_code'))->where('id', '!=', $id)->first()) {
                return response()->json(['message' => 'Reg. Code already exists!'], 400);
            }

            $transcript = Transcript::with('relDepartments')->where('id', $id)->first();
            $transcript_old = $transcript->toArray();


            if (!$transcript) {
                return response()->json(['error' => 'Transcript not exists by ID'], 400);
            }

            foreach ($tArray as $k => $v) {
                $transcript->{$k} = $v;
            }

            $transcript_new_array = $transcript->getDirty();

            if (array_key_exists('transcript_department_id', $transcript_new_array)) {
                $transcript_new_array['department'] = TranscriptDepartment::find($transcript_new_array['transcript_department_id'])->name;
                unset($transcript_new_array['transcript_department_id']);
            }

            $transcript_file_uploaded = false;

            try {
                if ($request->hasFile('transcript_file') && $request->file('transcript_file')->isValid()) {

                    $oldFileName = '';

                    if ($transcript->filename == '') {
                        $oldFileName = $transcript->filename;
                        if (file_exists(storage_path('transcripts') . '/' . $oldFileName)) {
                            @unlink(storage_path('transcripts') . '/' . $oldFileName);
                        }
                    }

                    $file = $request->file('transcript_file');

                    $extention = strtolower($file->getClientOriginalExtension());
                    $fileName = $tArray['regcode'] . '-' . $tArray['roll'] . '.' . $extention;
                    @unlink(storage_path('transcripts') . '/' . $fileName);

                    $request->file('transcript_file')->move(storage_path('transcripts'), $fileName);

                    $tArray['filename'] = $fileName;
                    $tArray['has_file'] = 1;
                    $transcript_file_uploaded = true;
                }

                if ($transcript->has_file == 1 && (($transcript->roll != $tArray['roll']) || ($transcript->regcode != $tArray['regcode']))) {
                    if (!empty($transcript->filename)) {
                        $exists_file_extention = explode('.', $transcript->filename)[1];
                        $fileName = $tArray['regcode'] . '-' . $tArray['roll'] . '.' . $exists_file_extention;
                        $oldFilePath = storage_path('transcripts') . '/' . $transcript->filename;

                        if (file_exists($oldFilePath)) {
                            rename($oldFilePath, storage_path('transcripts') . '/' . $fileName);
                            $tArray['filename'] = $fileName;
                        }
                    }
                }

            } catch (\Exception $e) {

                \Log::error($e->getMessage());

                return response()->json(['message' => 'Permission Related Problem'], 400);
            }


            Transcript::where(['id' => $id])->update($tArray);

            DB::commit();

            $employee = Employee::where('id', $request->auth->id)->first();

            $emails = [
                'shameemlaw@hotmail.com', 'drlikhon@gmail.com', 'admin@diu.ac',
                //'arif.it@diu-bd.net',
                'md.arif.tiens@gmail.com'];

            Mail::to($emails)->send(new TranscriptEditMail($transcript_old, $transcript_new_array, $employee, $transcript_file_uploaded));

            return response()->json(['message' => 'Transcript Updated Successfull.'], 200);
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Transcript upload Failed.'], 400);
        }
    }

}
