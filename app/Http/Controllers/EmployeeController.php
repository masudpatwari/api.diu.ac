<?php

namespace App\Http\Controllers;

use App\EmployeeRole;
use App\Role;
use Illuminate\Http\Request;
use App\Employee;
use App\User;
use App\WiFi;
use App\AttendanceId;
use App\EmployeeUpdateHistory;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\EmployeeDetailsResource;
use App\Http\Resources\EmployeeEditResource;
use App\Rules\CheckStrongPassword;
use App\Rules\CheckValidPhoneNumber;
use App\Rules\CheckValidOfficePhoneNumber;
use App\Rules\EmailAccountExists;
use App\Rules\GroupSlugExists;
use Illuminate\Support\Facades\DB;
use App\classes\vestacp;
use App\classes\diuLdap;
use App\Models\RMS\WpEmpRms;

class EmployeeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    public function __construct()
    {

        $vestacp_host = env('VESTA_HOSTNAME');
        $vestacp_username = env('VESTA_USERNAME');
        $vestacp_password = env('VESTA_PASSWORD');
        $vestacp_returncode = env('VESTA_RETURNCODE');
        $vestacp_email_domain = env('VESTA_EMAIL_DOMAIN');

        $this->vestacpObj = new vestacp($vestacp_host, $vestacp_username, $vestacp_password, $vestacp_returncode, $vestacp_email_domain);
        $this->diuLdap = new diuLdap();
    }


    public function index()
    {
        $employees = Employee::orderBy('id', 'asc')->where('activestatus', '1')->get();
        if (!empty($employees)) {
            return EmployeeResource::collection($employees);
        }
        return response()->json(NULL, 404);
    }

    public function Released_list()
    {
        $employees = Employee::orderBy('id', 'asc')->where('activestatus', '0')->get();
        if (!empty($employees)) {
            return EmployeeResource::collection($employees);
        }
        return response()->json(NULL, 404);
    }

    public function store(Request $request)
    {
        $this->validate($request,
            [
                'employee_name' => 'required',
//                'employee_type' => 'required',
                'designation_id' => 'required|numeric|exists:designations,id',
                'job_type' => 'required',
                'department_id' => 'required|numeric|exists:departments,id',
                'date_of_birth' => 'required|date_format:Y-m-d',
                'date_of_joining' => 'required|date_format:Y-m-d',
                'campus_id' => 'required|numeric|exists:campuses,id',
                'office_address' => 'required',
                'office_email' => ['required', 'email', 'unique:employees,office_email', new EmailAccountExists],
                'office_phone' => ['required', 'unique:employees,office_phone_no', new CheckValidOfficePhoneNumber],
                'private_email' => 'required|email|unique:employees,private_email',
                'home_phone' => [new CheckValidPhoneNumber],
                'personal_phone' => ['required', 'unique:employees,personal_phone_no', new CheckValidPhoneNumber],
                'alternative_phone' => [new CheckValidPhoneNumber],
                'spous_phone' => [new CheckValidPhoneNumber],
                'parents_phone' => [new CheckValidPhoneNumber],
                'gurdian_phone' => [new CheckValidPhoneNumber],
                'nid_no' => 'required|numeric',
                'employee_short_position' => 'required|exists:shortPositions,id',
                'supervised_by' => 'required|exists:employees,id',
                'attendance_card_id' => 'nullable',
                'attendance_id' => 'required',
                'merit' => 'required',
                'password' => ['required', new CheckStrongPassword, 'confirmed'],
                'password_confirmation' => 'required',
                'profile_photo_file' => 'required|image|mimes:jpeg,jpg|max:256',
                'signature_card_photo_file' => 'required|image|mimes:jpeg,jpg|max:256',
                'employee_group' => ['required', 'array', new GroupSlugExists],
                'salary_sl_no' => 'required|numeric',
                'role_id' => 'required|exists:roles,id',
            ]
        );

        try {
            DB::beginTransaction();

            $slug = str_replace([".", " ", "(", ")"], ["."], strtolower($request->input('employee_name')));
            $employee_group = NULL;
            if (!empty($request->input('employee_group'))) {
                $employee_group = implode(",", $request->input('employee_group'));
            }
            $employee_array = [
                'name' => $request->input('employee_name'),
                'slug_name' => $slug,
//                'type' => $request->input('employee_type'),
                'designation_id' => $request->input('designation_id'),
                'department_id' => $request->input('department_id'),
                'office_email' => $request->input('office_email'),
                'private_email' => $request->input('private_email'),
                'personal_phone_no' => $request->input('personal_phone'),
                'alternative_phone_no' => $request->input('alternative_phone'),
                'spous_phone_no' => $request->input('spous_phone'),
                'parents_phone_no' => $request->input('parents_phone'),
                'other_phone_no' => $request->input('other_phone'),
                'office_phone_no' => $request->input('office_phone'),
                'home_phone_no' => $request->input('home_phone'),
                'gurdian_phone_no' => $request->input('gurdian_phone'),
                'jobtype' => $request->input('job_type'),
                'date_of_birth' => date_to_datestamp($request->input('date_of_birth')),
                'date_of_join' => date_to_datestamp($request->input('date_of_joining')),
                'campus_id' => $request->input('campus_id'),
                'nid_no' => $request->input('nid_no'),
                'office_address' => $request->input('office_address'),
                'profile_photo_file' => $request->input('office_address'),
                'signature_card_photo_file' => $request->input('office_address'),
                'shortPosition_id' => $request->input('employee_short_position'),
                'password' => md5($request->input('password')),
                'activestatus' => 1,
                'created_by' => $request->auth->id,
                'groups' => $employee_group,
                'supervised_by' => $request->input('supervised_by'),
                'merit' => $request->input('merit'),
                'salary_report_sort_id' => $request->input('salary_sl_no'),
                'role_id' => 'required|numeric|unique:roles,id',

            ];
            $employee = Employee::create($employee_array);


            $attendance_array = [
                'employee_id' => $employee->id,
                'att_data_id' => $request->input('attendance_id'),
                'created_by' => $request->auth->id,
            ];

            if ($request->input('attendance_card_id')) {
                $attendance_array['att_card_id'] = $request->input('attendance_card_id');
            }

            AttendanceId::create($attendance_array);


            /**
             * Create Role start
             */
            $role_id = $request->input('role_id');
            $role_array = [
                'role_id' => $role_id,
                'employee_id' => $employee->id,
                'created_by' => $request->auth->id,
            ];

            $employee = Employee::find($employee->id);
            $employee->type = Role::find($role_id)->name;
            $employee->save();

            EmployeeRole::create($role_array);

            /**
             * Create Role End
             */


            /**
             * UPLOAD SIGNATURE CARD PHOTO
             */
            if ($request->hasFile('profile_photo_file') && $request->file('profile_photo_file')->isValid()) {

                $image = $request->file('profile_photo_file');
                $extention = strtolower($image->getClientOriginalExtension());

                $profile_photo_filefileName = 'images/' . 'profile_photo_file_' . $employee->id . '.' . $extention;

                $request->file('profile_photo_file')->move(storage_path('/images'), $profile_photo_filefileName);
            }

            /**
             * UPLOAD SIGNATURE CARD PHOTO
             */
            if ($request->hasFile('signature_card_photo_file') && $request->file('signature_card_photo_file')->isValid()) {

                $image = $request->file('signature_card_photo_file');
                $extention = strtolower($image->getClientOriginalExtension());

                $signature_card_photo_filefileName = 'images/' . 'signature_card_photo_file_' . $employee->id . '.' . $extention;

                $request->file('signature_card_photo_file')->move(storage_path('/images'), $signature_card_photo_filefileName);
            }

            $employee->profile_photo_file = $profile_photo_filefileName;
            $employee->signature_card_photo_file = $signature_card_photo_filefileName;
            $employee->save();

            /*
            * RMS sync
            */
            WpEmpRms::cmsSyncToRms($employee->id);


            $created = $this->vestacpObj->add_account(
                $request->input('office_email'),
                md5($request->input('password')),
                $request->input('employee_name')
            );

            DB::commit();
            return response()->json(NULL, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return response()->json(['error' => 'Insert Failed.' . $e], 400);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,
            [
                'employee_name' => 'required',
                'employee_name_slug' => 'unique:employees,slug_name,' . $id,
//                'employee_type' => 'required',
                'designation_id' => 'required|numeric|exists:designations,id',
                'job_type' => 'required',
                'department_id' => 'required|numeric|exists:departments,id',
                'date_of_birth' => 'required|date_format:Y-m-d',
                'date_of_joining' => 'required|date_format:Y-m-d',
                'campus_id' => 'required|numeric|exists:campuses,id',
                'office_address' => 'required',
                // 'office_email' => 'required|email|unique:employees,office_email,'.$id,
                'office_phone' => ['required', 'unique:employees,office_phone_no,' . $id, new CheckValidOfficePhoneNumber],
                'private_email' => 'required|email|unique:employees,private_email,' . $id,
                'home_phone' => [new CheckValidPhoneNumber],
                'personal_phone' => ['required', 'unique:employees,personal_phone_no,' . $id, new CheckValidPhoneNumber],
                'alternative_phone' => [new CheckValidPhoneNumber],
                'spous_phone' => [new CheckValidPhoneNumber],
                'parents_phone' => [new CheckValidPhoneNumber],
                'gurdian_phone' => [new CheckValidPhoneNumber],
                'nid_no' => 'required|numeric',
                'employee_short_position' => 'required|exists:shortPositions,id',
                'supervised_by' => 'required|exists:employees,id',
                'attendance_card_id' => '',
                'attendance_id' => 'required',
                'merit' => 'required',
                'employee_group' => ['required', 'array', new GroupSlugExists],
                'salary_sl_no' => 'required|numeric',
                'role_id' => 'required|exists:roles,id',
            ]
        );

        $slug = str_replace([".", " ", "(", ")"], ["."], strtolower($request->input('employee_name_slug')));
        $employee_group = NULL;
        if (!empty($request->input('employee_group'))) {
            $employee_group = implode(",", $request->input('employee_group'));
        }

        $employee_array = [
            'name' => $request->input('employee_name'),
            'slug_name' => $slug,
//            'type' => $request->input('employee_type'),
            'designation_id' => $request->input('designation_id'),
            'department_id' => $request->input('department_id'),
            // 'office_email' => $request->input('office_email'),
            'private_email' => $request->input('private_email'),
            'personal_phone_no' => $request->input('personal_phone'),
            'alternative_phone_no' => $request->input('alternative_phone'),
            'spous_phone_no' => $request->input('spous_phone'),
            'parents_phone_no' => $request->input('parents_phone'),
            'other_phone_no' => $request->input('other_phone'),
            'office_phone_no' => $request->input('office_phone'),
            'home_phone_no' => $request->input('home_phone'),
            'gurdian_phone_no' => $request->input('gurdian_phone'),
            'jobtype' => $request->input('job_type'),
            'date_of_birth' => date_to_datestamp($request->input('date_of_birth')),
            'date_of_join' => date_to_datestamp($request->input('date_of_joining')),
            'campus_id' => $request->input('campus_id'),
            'nid_no' => $request->input('nid_no'),
            'office_address' => $request->input('office_address'),
            'shortPosition_id' => $request->input('employee_short_position'),
            'supervised_by' => $request->input('supervised_by'),
            'groups' => $employee_group,
            'merit' => $request->input('merit'),
            // 'activestatus' => $request->input('active_status'),
            'salary_report_sort_id' => $request->input('salary_sl_no'),
        ];

        $attendance_array = [
            'employee_id' => $id,
            'att_data_id' => $request->input('attendance_id'),
            'created_by' => $request->auth->id,
        ];

        if ($request->input('attendance_card_id')) {
            $attendance_array['att_card_id'] = $request->input('attendance_card_id');
        }


        $role_id = $request->input('role_id');
        $role_array = [
            'role_id' => $role_id,
            'employee_id' => $id,
            'created_by' => $request->auth->id,
        ];


        try {
            DB::beginTransaction();


            $employee = Employee::where('id', $id)->first();
            $employee->type = Role::find($role_id)->name;
            $employee->save();

            $x = EmployeeRole::where(['employee_id' => $id, 'role_id' => $role_id])->first();
            if ($x) {
                $x->deleted_by = $request->auth->id;
                $x->delete();
            }
//
            EmployeeRole::create($role_array);

            $old_employee = Employee::where('id', $id)->first();
            Employee::where('id', $id)->update($employee_array);
            $updated_employee = Employee::where('id', $id)->first();

            $diff_result = array_diff($old_employee->toArray(), $updated_employee->toArray());
            unset($diff_result['updated_at']);
            if (!empty($diff_result)) {
                EmployeeUpdateHistory::create([
                    'prev_row' => json_encode($diff_result),
                    'created_by' => $request->auth->id,
                ]);
            }


            $attendance = AttendanceId::where(['employee_id' => $id])->first();
            $is_exists = $attendance->where([
                'employee_id' => $id,
                'att_data_id' => $request->input('attendance_id'),
                'att_card_id' => $request->input('attendance_card_id')
            ])->withTrashed()->first();
            if (empty($is_exists)) {
                $attendance->delete();
                AttendanceId::create($attendance_array);
            }

            /*
            * RMS sync
            */
            WpEmpRms::cmsSyncToRms($id);

            DB::commit();
            return response()->json($diff_result, 200);
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(['error' => 'Update Failed.' . $e], 400);
        }
    }

    public function show($id)
    {
        $employees = Employee::find($id);
        if (!empty($employees)) {
            return new EmployeeDetailsResource($employees);
        }
        return response()->json(NULL, 404);
    }

    public function edit($id)
    {
        $employees = Employee::find($id);
        if (!empty($employees)) {
            return new EmployeeEditResource($employees);
        }
        return response()->json(NULL, 404);
    }

    public function chnage_password(Request $request)
    {
        $this->validate($request,
            [
                'current_password' => 'required',
                'password' => ['required', new CheckStrongPassword, 'confirmed'],
                'password_confirmation' => 'required',
            ]
        );

        $password_confirmation = md5($request->input('password_confirmation'));

        if (md5($request->input('current_password')) == $request->auth->password) {
            $password = Employee::where(['id' => $request->auth->id])->update([
                'password' => $password_confirmation,
            ]);
            if (!empty($password)) {

                /*
                *   RMS password cange
                */
                $message = "CMS Password changed. ";

                $changed = WpEmpRms::changePassword(Employee::find($request->auth->id)->office_email, $password_confirmation);
                if ($changed) {
                    $message .= "Also RMS password changed";
                }
                return response()->json(['success' => $message], 200);
            }
            return response()->json(['error' => 'Password change Failed.'], 400);
        }
        return response()->json(['error' => 'Current password not match.'], 400);
    }

    public function changeOfficialEmail(Request $request)
    {

        $this->validate($request,
            [
                'employee_id' => ['required', 'integer', 'exists:employees,id'],
                'new_office_email' => ['required', 'email', 'unique:employees,office_email,' . $request->auth->id, new EmailAccountExists],
                'password' => ['required', new CheckStrongPassword, 'confirmed'],
                'password_confirmation' => 'required',
            ]
        );

        $employee = Employee::find($request->employee_id);
        $office_email = $employee->office_email;


        if ($office_email == '') {
            return response()->json(['error' => 'Selected Employee has no email!'], 400);
        }

        if (!in_array(explode("@", $office_email)[0], $this->vestacpObj->list_of_mail_accounts_id())) {
            return response()->json(['error' => 'Selected Employee\'s email not opened in server!'], 400);
        }

        $suspend = $this->vestacpObj->suspend_mail_account($office_email);
        $created = $this->vestacpObj->add_account($request->new_office_email, $request->password, $employee->name);

        if ($suspend == '0' && $created == '0') {

            $employee->office_email = $request->new_office_email;
            $employee->save();
            /*
            *   RMS password cange
            */
            $message = "Email changed in CMS ";

            $changed = WpEmpRms::changeEmail(Employee::find($request->auth->id)->office_email, $request->new_office_email);
            if ($changed) {
                $message .= " And RMS";
            }

            return response()->json(['success' => $message], 200);
        }

        $message = '';
        if ($suspend != '') {
            $message .= "Present Email Suspended Fail.";
        }
        if ($created != '') {
            $message .= "New Email Create Fail.";
        }
        $unsuspend = $this->vestacpObj->unsuspend_mail_account($office_email);

        return response()->json(['error' => $message], 400);
    }

    public function releaseEmployee(Request $request)
    {

        $successMessage = "";

        $this->validate($request,
            [
                'employee_id' => ['required', 'integer', 'exists:employees,id'],
            ]
        );

        if ($request->employee_id == env('ROOT_EMPLOYEE_ID')) {
            return response()->json(['error' => 'Root Employee Cannot Be Deleted'], 400);
        }

        $employee = Employee::find($request->employee_id);

        if (!$employee) {
            return response()->json(['error' => 'Employee Not Found!'], 400);
        }

        if ($employee->id == $request->auth->id) {
            return response()->json(['error' => 'Employee Cannot Release Himself!'], 400);
        }

        /**
         *   RMS disabled
         */
        if (WpEmpRms::destroyByEmail($employee->office_email)) {
            $successMessage .= " RMS Account Disabled. ";
        }

        if ($employee->activestatus == 0) {
            return response()->json(['error' => 'CMS Employee account already disabled.'], 400);
        }

        $office_email = $employee->office_email;


        /*******************************
         * vesta email account  START
         */

        if (in_array(explode("@", $office_email)[0], $this->vestacpObj->list_of_mail_accounts_id())) {
            $suspend = $this->vestacpObj->suspend_mail_account($office_email);
            $successMessage .= " Email Account Suspended. ";
        } else {
            $successMessage .= " Email Account Not Found In Email Server. ";
        }

        /**
         * vesta email account  END
         ***********************************/


        /**************************
         * WiFi  account  START
         */
        $wifiUser = WiFi::where('employee_id', $request->employee_id)->first();
        if ($wifiUser) {

            $wifiUser->delete();

        } else {
            $successMessage .= " WiFi Account not found. ";
        }

        /**
         * WiFi  account  END
         **********************/

        $employee->activestatus = 0;
        $employee->save();

        $successMessage = " Web Account disabled." . $successMessage;

        return response()->json(['success' => $successMessage], 200);

    }

    public function reactiveEmployee(Request $request)
    {

        $successMessage = "";

        $this->validate($request,
            [
                'employee_id' => ['required', 'integer', 'exists:employees,id'],
            ]
        );

        if ($request->employee_id == env('ROOT_EMPLOYEE_ID')) {
            return response()->json(['error' => 'Root Employee Cannot Be Changed'], 400);
        }

        $employee = Employee::find($request->employee_id);

        if (!$employee) {
            return response()->json(['error' => 'Employee Not Found!'], 400);
        }

        /**
         *   RMS disabled
         */
        if (WpEmpRms::destroyByEmail($employee->office_email)) {
            $successMessage .= " RMS Account Activated. ";
        }

        if ($employee->activestatus == 1) {
            return response()->json(['error' => 'Employee account already Active.'], 400);
        }

        $office_email = $employee->office_email;


        /*******************************
         * vesta email account  START
         */

        if (in_array(explode("@", $office_email)[0], $this->vestacpObj->list_of_mail_accounts_id())) {
            $suspend = $this->vestacpObj->unsuspend_mail_account($office_email);
            $successMessage .= " Email Account Activated. ";
        } else {
            $successMessage .= " Email Account Not Found In Email Server. ";
        }

        /**
         * vesta email account  END
         ***********************************/


        /**************************
         * WiFi  account  START
         */
        //        $wifiUser = WiFi::withTrashed()->where('employee_id', $request->employee_id )->first();
        //        if ($wifiUser) {
        //            $wifiUserName = $wifiUser->username;
        //            $wifiUserpassword = $wifiUser->userpassword;
        //            if($this->diuLdap->search_user($wifiUserName)['count'] == 0){
        //                $this->diuLdap->addUser($wifiUserName, $wifiUserpassword);
        //                $wifiUser->restore();
        //                $successMessage.=" WiFi Account Activated";
        //            }else{
        //                $successMessage.=" WiFi Account already Activated.";
        //            }
        //        }else{
        //            $successMessage.=" WiFi Account not found.";
        //        }

        /**
         * WiFi  account  END
         **********************/

        $employee->activestatus = 1;
        $employee->save();
        $successMessage = " Web Account Activated." . $successMessage;

        return response()->json(['success' => $successMessage], 200);

    }

//profile_photo_file
//signature_card_photo_file
//cover_photo_file
    public function profile_image_upload(Request $request)
    {
        $this->validate($request, [
            'profile_photo' => 'required|image|mimes:jpeg,jpg|max:500',
        ]);


        $employee = Employee::findOrFail($request->auth->id);

        $image = $request->file('profile_photo');
        $extention = strtolower($image->getClientOriginalExtension());
        $profile_photo_filefileName = 'images/' . 'profile_photo_file_' . $employee->id . '.' . $extention;
        $request->file('profile_photo')->move(storage_path('/images'), $profile_photo_filefileName);
        $employee->profile_photo_file = $profile_photo_filefileName;
        $employee->save();

        return response()->json(['success' => 'Profile Image Updated!'], 201);

        /*if ($this->imageUpload('profile_photo_file', 'profile_photo', 'profile_image_upload_', $request)) {
            return response()->json(['success' => 'Profile Image Updated!'], 201);
        }
        return response()->json(['error' => 'Profile Photo File not Found!'], 400);*/
    }

    public function signature_card_photo_upload(Request $request)
    {

        $this->validate($request, [
            'signature_card_photo' => 'required|image|mimes:jpeg,jpg|max:256',
        ]);

        if ($this->imageUpload('signature_card_photo_file', 'signature_card_photo', 'signature_card_photo_', $request)) {
            return response()->json(['success' => 'Signature Card Photo Updated!'], 201);
        }
        return response()->json(['error' => 'Signature Card Photo File not Found!'], 400);
    }

    private function imageUpload($columnName, $fileInputFieldName, $fileNameStartWith, $request): bool
    {
        if ($request->hasFile($fileInputFieldName) && $request->file($fileInputFieldName)->isValid()) {

            $image = $request->file($fileInputFieldName);
            $extention = strtolower($image->getClientOriginalExtension());

            $employee = Employee::findOrFail($request->auth->id);
            $fileName = 'images/' . $fileNameStartWith . $employee->id . '.' . $extention;
            $employee->$columnName = $fileName;


            $request->file($fileInputFieldName)->move(storage_path('images'), $fileName);

            $employee->save();
            return true;
        }
        return false;
    }

    public function find_signature(Request $request)
    {
        $this->validate($request,
            [
                'employee_id' => 'required|numeric|exists:employees,id',
            ]
        );

        $signature = Employee::whereId($request->employee_id)->first();
        if (empty($signature->signature_card_photo_file)) {
            return response()->json(['error' => 'Please Upload Signature Card Photo!'], 400);
        }
        $filename = storage_path() . '/' . $signature->signature_card_photo_file;
        if (file_exists($filename)) {
            return 'https://api.diu.ac/' . $signature->signature_card_photo_file;
        }
        return response()->json(['error' => 'Signature Card Photo Not Found!'], 400);
    }


    public function updateSNCnProfileImage(Request $request)
    {
        $this->validate($request,
            [
                'employee_id' => 'required',
                'profile_photo_file' => 'image|mimes:jpeg,jpg|max:256',
                'signature_card_photo_file' => 'image|mimes:jpeg,jpg|max:512',
            ]
        );

        try {

            $employee = Employee::findOrFail($request->employee_id);

            if (
                (!$request->hasFile('profile_photo_file') || !$request->file('profile_photo_file')->isValid())
                &&
                (!$request->hasFile('signature_card_photo_file') || !$request->file('signature_card_photo_file')->isValid())
            ) {
                return response()->json(['error' => 'No Image File Selected'], 400);
            }


            /**
             * UPLOAD SIGNATURE CARD PHOTO
             */
            $profile_photo_filefileName = '';

            if ($request->hasFile('profile_photo_file') && $request->file('profile_photo_file')->isValid()) {

                $image = $request->file('profile_photo_file');
                $extention = strtolower($image->getClientOriginalExtension());

                $profile_photo_filefileName = 'images/' . 'profile_photo_file_' . $employee->id . '.' . $extention;

                $request->file('profile_photo_file')->move(storage_path('/images'), $profile_photo_filefileName);
                $employee->profile_photo_file = $profile_photo_filefileName;

            }

            /**
             * UPLOAD SIGNATURE CARD PHOTO
             */
            $signature_card_photo_filefileName = '';
            if ($request->hasFile('signature_card_photo_file') && $request->file('signature_card_photo_file')->isValid()) {

                $image = $request->file('signature_card_photo_file');
                $extention = strtolower($image->getClientOriginalExtension());

                $signature_card_photo_filefileName = 'images/' . 'signature_card_photo_file_' . $employee->id . '.' . $extention;

                $request->file('signature_card_photo_file')->move(storage_path('/images'), $signature_card_photo_filefileName);
                $employee->signature_card_photo_file = $signature_card_photo_filefileName;

            }

            $employee->save();

            return response()->json(NULL, 200);
        } catch (\PDOException $e) {
            \Log::error($e);
            return response()->json(['error' => 'Image Upload Fail'], 400);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['error' => 'Image Upload Fail'], 400);
        }
    }

    public function newStore(Request $request)
    {
        $this->validate($request,
            [
                'employee_name' => 'required|string|max:50',
                'designation_id' => 'required|numeric|exists:designations,id',
                'job_type' => 'required|in:Full Time,Part Time',
                'department_id' => 'required|numeric|exists:departments,id',
                'date_of_birth' => 'required|date|date_format:Y-m-d',
                'date_of_joining' => 'required|date|date_format:Y-m-d',
                'campus_id' => 'required|numeric|exists:campuses,id',
                'office_address' => 'required|string|max:100',
                'other_phone' => ['required', 'max:50', new CheckValidPhoneNumber],
                // 'office_email' => ['required', 'email', 'unique:employees,office_email', 'max:40', new EmailAccountExists],
                'office_email' => ['required', 'email', 'unique:employees,office_email', 'max:40'],
                'office_phone' => ['required', 'unique:employees,office_phone_no', 'max:300', new CheckValidOfficePhoneNumber],
                'private_email' => 'required|email|unique:employees,private_email|max:40',
                'home_phone' => ['nullable', 'max:25', new CheckValidPhoneNumber],
                'personal_phone' => ['required', 'max:20', 'unique:employees,personal_phone_no', new CheckValidPhoneNumber],
                'alternative_phone' => ['nullable', 'max:20', new CheckValidPhoneNumber],
                'spous_phone' => ['nullable', 'max:25', new CheckValidPhoneNumber],
                'parents_phone' => ['nullable', 'max:25', new CheckValidPhoneNumber],
                'gurdian_phone' => ['nullable', 'max:25', new CheckValidPhoneNumber],
                'nid_no' => 'required|numeric',
                'employee_short_position' => 'required|integer|exists:shortPositions,id',
                'supervised_by' => 'required|integer|exists:employees,id',
                'attendance_card_id' => 'nullable',
                'attendance_id' => 'required',
                'merit' => 'required|integer',
                'password' => ['required', 'min:8', 'max:100', new CheckStrongPassword],
//                'password_confirmation' => 'required',
                'profile_photo_file' => 'required|image|mimes:jpeg,jpg,png|max:1024',
                'signature_card_photo_file' => 'required|image|mimes:jpeg,jpg,png|max:1024',
                'employee_group' => ['required', 'array', new GroupSlugExists],
                'salary_sl_no' => 'required|numeric',
                'role_id' => 'required|exists:roles,id',
            ]
        );

        // return 'ok';

        try {

            DB::transaction(function () use ($request) {
                $slug = str_replace([".", " ", "(", ")"], ["."], strtolower($request->input('employee_name')));
                $employee_group = NULL;
                if (!empty($request->input('employee_group'))) {
                    $employee_group = implode(",", $request->input('employee_group'));
                }

                $employee_array = [
                    'name' => $request->input('employee_name'),
                    'slug_name' => $slug,
//                'type' => $request->input('employee_type'),
                    'designation_id' => $request->input('designation_id'),
                    'department_id' => $request->input('department_id'),
                    'office_email' => $request->input('office_email'),
                    'private_email' => $request->input('private_email'),
                    'personal_phone_no' => $request->input('personal_phone'),
                    'alternative_phone_no' => $request->input('alternative_phone'),
                    'spous_phone_no' => $request->input('spous_phone'),
                    'parents_phone_no' => $request->input('parents_phone'),
                    'other_phone_no' => $request->input('other_phone'),
                    'office_phone_no' => $request->input('office_phone'),
                    'home_phone_no' => $request->input('home_phone'),
                    'gurdian_phone_no' => $request->input('gurdian_phone'),
                    'jobtype' => $request->input('job_type'),
                    'date_of_birth' => date_to_datestamp($request->input('date_of_birth')),
                    'date_of_join' => date_to_datestamp($request->input('date_of_joining')),
                    'campus_id' => $request->input('campus_id'),
                    'nid_no' => $request->input('nid_no'),
                    'office_address' => $request->input('office_address'),
                    'profile_photo_file' => $request->input('office_address'),
                    'signature_card_photo_file' => $request->input('office_address'),
                    'shortPosition_id' => $request->input('employee_short_position'),
                    'password' => md5($request->input('password')),
                    'activestatus' => 1,
                    'created_by' => $request->auth->id,
                    'groups' => $employee_group,
                    'supervised_by' => $request->input('supervised_by'),
                    'merit' => $request->input('merit'),
                    'salary_report_sort_id' => $request->input('salary_sl_no'),
                    'role_id' => 'required|numeric|unique:roles,id',

                ];
                $employee = Employee::create($employee_array);

                $attendance_array = [
                    'employee_id' => $employee->id,
                    'att_data_id' => $request->input('attendance_id'),
                    'created_by' => $request->auth->id,
                ];

                if ($request->input('attendance_card_id')) {
                    $attendance_array['att_card_id'] = $request->input('attendance_card_id');
                }

                AttendanceId::create($attendance_array);

                /**
                 * Create Role start
                 */
                $role_id = $request->input('role_id');
                $role_array = [
                    'role_id' => $role_id,
                    'employee_id' => $employee->id,
                    'created_by' => $request->auth->id,
                ];

                $employee = Employee::find($employee->id);
                $employee->type = Role::find($role_id)->name;
                $employee->save();

                EmployeeRole::create($role_array);

                /**
                 * Create Role End
                 */


                /**
                 * UPLOAD SIGNATURE CARD PHOTO
                 */
                if ($request->hasFile('profile_photo_file') && $request->file('profile_photo_file')->isValid()) {

                    $image = $request->file('profile_photo_file');
                    $extention = strtolower($image->getClientOriginalExtension());

                    $profile_photo_filefileName = 'images/' . 'profile_photo_file_' . $employee->id . '.' . $extention;

                    $request->file('profile_photo_file')->move(storage_path('/images'), $profile_photo_filefileName);
                }

                /**
                 * UPLOAD SIGNATURE CARD PHOTO
                 */
                if ($request->hasFile('signature_card_photo_file') && $request->file('signature_card_photo_file')->isValid()) {

                    $image = $request->file('signature_card_photo_file');
                    $extention = strtolower($image->getClientOriginalExtension());

                    $signature_card_photo_filefileName = 'images/' . 'signature_card_photo_file_' . $employee->id . '.' . $extention;

                    $request->file('signature_card_photo_file')->move(storage_path('/images'), $signature_card_photo_filefileName);
                }

                $employee->profile_photo_file = $profile_photo_filefileName;
                $employee->signature_card_photo_file = $signature_card_photo_filefileName;
                $employee->save();

                /*
                * RMS sync
                */
                WpEmpRms::cmsSyncToRms($employee->id);
            });
            return response()->json(['message' => 'Employee Created successfully'], 201);
        } catch (\Exception $e) {

            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return response()->json(['error' => 'Insert Failed.' . $e], 400);
        }
    }
}
