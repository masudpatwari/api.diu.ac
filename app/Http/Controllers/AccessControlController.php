<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\EmployeeRole;
use App\Employee;
use App\Http\Resources\RoleResource;
use App\Http\Resources\RoleDetailsResource;
use App\Http\Resources\RoleEditResource;
use App\Http\Resources\RoleAccessResource;
use Illuminate\Support\Facades\Storage;

class AccessControlController extends Controller
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

    public function permissions()
    {
        try {
            $routes = getAllRouteNameAsArray();
            foreach ($routes as $key => $route) {
                $explode = explode(".", $route);
                if (isset($explode[1]) && !empty($explode[1]))
                    if(isset($explode[2]) && !empty($explode[2])){
                        $data[$explode[0]][] = $explode[1].'.'.$explode[2];
                    }else {
                        $data[$explode[0]][] = $explode[1];
                    }
            }
            if (!empty($data)) {
                return response()->json($data, 200);
            }
        } catch (\Exception $exception) {
            Log::alert($exception);
        }

        return response()->json(NULL, 404);
    }

    public function assign_role(Request $request)
    {
        $this->validate($request,
            [
                'role_id' => 'required|exists:roles,id',
            ],
            [
                'role_id.required' => 'Role name is required.',
                'role_id.exists' => 'Role name does not exists.',
            ]
        );
        $all_routes = $this->fullRouteNames();
        $permissions = $request->input('permissions');
        $check = checkPermissionArray($all_routes, $permissions);

        $role_array = [
            'permissions' => json_encode($permissions),
        ];
        if (empty($permissions)) {
            $role_array = [
                'permissions' => NULL,
            ];
        }

        if ($check) {
            $id = $request->input('role_id');
            $replicate = Role::find($id);
            $role = $replicate->replicate();
            $role->deleted_by = $request->auth->id;
            $role->push();
            $role->delete();

            $role = Role::where('id', $id)->update($role_array);

            if (!empty($role)) {
                return response()->json($role, 200);
            }
            return response()->json(['error' => 'Update Failed.'], 400);
        }
        return response()->json(['error' => 'Invalid permissions.'], 400);
    }

    public function assign_role_module(Request $request, $layout)
    {
        $this->validate($request,
            [
                'role_id' => 'required|exists:roles,id',
            ],
            [
                'role_id.required' => 'Role name is required.',
                'role_id.exists' => 'Role name does not exists.',
            ]
        );

        $check = true;
        $all_routes = $this->fullRouteNames();
        $permissions = $request->input('permissions');

        if (empty($permissions)) {
            $role_array = [
                'permissions' => NULL,
            ];
        }else {
            $check = checkPermissionArray($all_routes, $permissions);
            $role_array = [
                'permissions' => json_encode($permissions),
            ];
        }



        if ($check) {
            $id = $request->input('role_id');
            $replicate = Role::find($id);
            $role = $replicate->replicate();
            $role->deleted_by = $request->auth->id;
            $role->push();
            $role->delete();

            $role = Role::where('id', $id);


            $permission_array = $this->modular_permission($role, $layout, $role_array['permissions']);


            $role->update($permission_array);

            if (!empty($role)) {
                return response()->json($role, 200);
            }

            return response()->json(['error' => 'Update Failed.'], 400);
        }

        return response()->json(['error' => 'Invalid permissions.'], 400);
    }

    public function assign_employee_role(Request $request)
    {
        $this->validate($request,
            [
                'employee_id' => 'required|exists:employees,id',
                'role_id' => 'required|exists:roles,id',
            ],
            [
                'employee_id.required' => 'Employee name is required.',
                'employee_id.exists' => 'Employee name does not exists.',
                'role_id.required' => 'Role name is required.',
                'role_id.exists' => 'Role name does not exists.',
            ]
        );

        $employee_id = $request->input('employee_id');
        $role_id = $request->input('role_id');
        $role_array = [
            'role_id' => $role_id,
            'employee_id' => $employee_id,
            'created_by' => $request->auth->id,
        ];

        $employee = Employee::find($employee_id);
        $employee->type = Role::find($role_id)->name;
        $employee->save();

        $x = EmployeeRole::where(['employee_id' => $employee_id]);
        if ($x->exists() == false) {
            $employee_role = EmployeeRole::create($role_array);
            return response()->json($employee_role, 201);
        } else {
            $x->where('role_id', $role_id);
            if ($x->exists() == false) {
                $exists = EmployeeRole::where(['employee_id' => $employee_id])->first();
                $exists->deleted_by = $request->auth->id;
                $exists->push();
                $exists->delete();
                $employee_role = EmployeeRole::create($role_array);
                return response()->json($employee_role, 201);
            }
            return response()->json(['error' => 'Role already assigned.'], 400);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function assign_permission(Request $request)
    {
        $this->validate($request,
            [
                'employee_id' => 'required|exists:employees,id',
            ],
            [
                'employee_id.required' => 'Employee name is required.',
                'employee_id.exists' => 'Employee name does not exists.',
            ]
        );
        $check = true;
        $all_routes = $this->fullRouteNames();
        $employee_id = $request->input('employee_id');
        $permissions = $request->input('permissions');
        $role_array = [
            'permissions' => json_encode($permissions),
        ];
        if (empty($permissions)) {
            $role_array = [
                'permissions' => NULL,
            ];
        } else {
            $check = checkPermissionArray($all_routes, $permissions);
        }

        /**
         *   TASKS
         *   =====
         *   check all of item in  $request->input('permissions')  in getAllRouteNameAsArray()
         */

        if ($check) {
            $employee = Employee::where('id', $employee_id)->update($role_array);
            if (!empty($employee)) {
                return response()->json($employee, 200);
            }
            return response()->json(['error' => 'Update Failed.'], 400);
        }
        return response()->json(['error' => 'Invalid permissions.'], 400);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */

    public function assign_module_permission(Request $request, $module)
    {
        $this->validate($request,
            [
                'employee_id' => 'required|exists:employees,id',
            ],
            [
                'employee_id.required' => 'Employee name is required.',
                'employee_id.exists' => 'Employee name does not exists.',
            ]
        );

        $check = true;
        $all_routes = $this->fullRouteNames();

        $employee_id = $request->input('employee_id');
        $permissions = $request->input('permissions');


        $role_array = [
            'permissions' => json_encode($permissions),
        ];
        if (empty($permissions)) {
            $role_array = [
                'permissions' => NULL,
            ];
        } else {
            $check = checkPermissionArray($all_routes, $permissions);
        }

        /**
         *   TASKS
         *   =====
         *   check all of item in  $request->input('permissions')  in getAllRouteNameAsArray()
         */

        if ($check) {
            $employee = Employee::where('id', $employee_id);

            $permission_array = $this->modular_permission($employee, $module, $role_array['permissions']);

            $employee->update($permission_array);

            if (!empty($employee)) {
                return response()->json($employee, 200);
            }
            return response()->json(['error' => 'Update Failed.'], 400);
        }
        return response()->json(['error' => 'Invalid permissions.'], 400);
    }

    private function modular_permission($model, $layout, $new_permission_array = null): array
    {
        $old_permissions = json_decode($model->value('permissions'));
        $non_module_permissions = [];

        if ($old_permissions) {
            foreach ($old_permissions as $key => $old_permission) {
                $permission_modules = explode('.', $old_permission);


                if ($layout == 'students_management') {
                    if ($permission_modules[0] != 'students_website' && $permission_modules[0] != 'blocked' && $permission_modules[0] != 'cms_transcript_update' && $permission_modules[0] != 'campusAdda' && $permission_modules[0] != 'microsoftStudent' && $permission_modules[0] != 'photoContest' && $permission_modules[0] != 'talentHunt' && $permission_modules[0] != 'cms_student_module' && $permission_modules[0] != 'student_doc_mtg' && $permission_modules[0] != 'newStudentAccount' && $permission_modules[0] != 'studentSession' && $permission_modules[0] != 'studentRegCardStatus' && $permission_modules[0] != 'studentImage' && $permission_modules[0] != 'student' && $permission_modules[0] != 'studentPendingIdCard' && $permission_modules[0] != 'mobile_banking') {
                        array_push($non_module_permissions, $old_permission);
                    }
                }
                if ($layout == 'itSupport') {
                    if ($permission_modules[0] != 'studentSupportTicket') {
                        array_push($non_module_permissions, $old_permission);
                    }
                }
                if ($layout == 'leave_attendance') {
                    if ($permission_modules[0] != 'holiday' && $permission_modules[0] != 'leave_application' && $permission_modules[0] != 'cms_student_attendance' && $permission_modules[0] != 'attendance_sms' && $permission_modules[0] != 'attendance_report' && $permission_modules[0] != 'salary' && $permission_modules[0] != 'switchoffday') {
                        array_push($non_module_permissions, $old_permission);
                    }
                }
                if ($layout == 'accounts') {
                    if ($permission_modules[0] != 'mobilePayment' && $permission_modules[0] != 'covid-accounts-report' && $permission_modules[0] != 'eligible-students-for-exam' && $permission_modules[0] != 'other-form-download' && $permission_modules[0] != 'take_payment' && $permission_modules[0] != 'mobile_banking' && $permission_modules[0] != 'exim' && $permission_modules[0] != 'faculties' && $permission_modules[0] != 'programs') {
                        array_push($non_module_permissions, $old_permission);
                    }
                }
                if ($layout == 'employee') {
                    if ($permission_modules[0] != 'department' && $permission_modules[0] != 'designation' && $permission_modules[0] != 'short_position' && $permission_modules[0] != 'employee' && $permission_modules[0] != 'employee_group') {
                        array_push($non_module_permissions, $old_permission);
                    }
                }
                if ($layout == 'docmtg') {
                    if ($permission_modules[0] != 'cms_transcript_update' && $permission_modules[0] != 'cms_transcript') {
                        array_push($non_module_permissions, $old_permission);
                    }
                }
                if ($layout == 'liaison_officer') {
                    if ($permission_modules[0] != 'liaison_officer' && $permission_modules[0] != 'liaison_student'  && $permission_modules[0] != 'whats_app'   && $permission_modules[0] != 'admissionForm'  && $permission_modules[0] != 'englishBookForm' && $permission_modules[0] != 'liaison_bill' && $permission_modules[0] != 'liaison_bill_student' && $permission_modules[0] != 'liaison-programs' && $permission_modules[0] != 'admissionInActiveBatch' && $permission_modules[0] != 'registrationSummary' && $permission_modules[0] != 'InternationalStudentDoc' && $permission_modules[0] != 'internationalStudent' && $permission_modules[0] != 'batch' && $permission_modules[0] != 'goip') {
                        array_push($non_module_permissions, $old_permission);
                    }
                }
                if ($layout == 'pbx') {
                    if ($permission_modules[0] != 'pbx') {
                        array_push($non_module_permissions, $old_permission);
                    }
                }
                if ($layout == 'statistics') {
                    if ($permission_modules[0] != 'statistics' && $permission_modules[0] != 'staffsServiceFeedback' && $permission_modules[0] != 'teachersServiceFeedback' && $permission_modules[0] != 'fetchFeedbackData') {
                        array_push($non_module_permissions, $old_permission);
                    }
                }
                if ($layout == 'system_settings') {
                    if ($permission_modules[0] != 'role' && $permission_modules[0] != 'permission' && $permission_modules[0] != 'job' && $permission_modules[0] != 'system_setting' && $permission_modules[0] != 'erp' && $permission_modules[0] != 'rms') {
                        array_push($non_module_permissions, $old_permission);
                    }
                }
                if ($layout == 'hostel_management') {
                    if ($permission_modules[0] != 'hostel') {
                        array_push($non_module_permissions, $old_permission);
                    }
                }

            }
        }


//        dd($new_permission_array, $non_module_permissions, json_encode($non_module_permissions));
        if (!empty($non_module_permissions)) {
            if ($new_permission_array) {
                $permission_arrays = array_merge(json_decode($new_permission_array), $non_module_permissions);

                $permission_array = [
                    'permissions' => json_encode($permission_arrays)
                ];
            } else {
                $permission_array = [
                    'permissions' => json_encode($non_module_permissions)
                ];
            }

        } else {
            $permission_array = [
                'permissions' => $new_permission_array
            ];
        }


        return $permission_array;
    }

    private function fullRouteNames(): array
    {
        $data = [];
        $routes = getAllRouteNameAsArray();
        foreach ($routes as $key => $route) {
            $explode = explode(".", $route);
            if (isset($explode[1]) && !empty($explode[1]))
                if(isset($explode[2]) && !empty($explode[2])){
                    $data[] = $explode[0].'.'.$explode[1].'.'.$explode[2];
                }else {
                    $data[] = $explode[0].'.'.$explode[1];
                }
        }

        return $data;
    }
}
