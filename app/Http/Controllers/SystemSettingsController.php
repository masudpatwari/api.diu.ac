<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SystemSetting;
use App\Employee;
use App\Http\Resources\SystemSettingResource;
use App\Http\Resources\SystemSettingDetailsResource;
use App\Rules\CheckStrongPassword;

class SystemSettingsController extends Controller
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

    public function index()
    {
        $system_setting = SystemSetting::orderBy('id', 'asc')->get();
        if (!empty($system_setting)) {
            return SystemSettingResource::collection($system_setting);
        }
        return response()->json(NULL, 404);
    }

    public function store(Request $request)
    {
        $this->validate($request,
            [
                'key' => 'required|unique:system_settings,key',
                'value' => 'required',
            ],
            [
                'key.required' => 'Setting key is required.',
                'key.unique' => 'Setting key is already exists.',
                'value.required' => 'Setting value is required.',
            ]
        );

        $setting_array = [
            'key' => slug($request->input('key')),
            'value' => $request->input('value'),
            'created_by' => $request->auth->id,
            'updated_by' => $request->auth->id,
        ];

        $setting = SystemSetting::create($setting_array);
        if (!empty($setting->id)) {
            return response()->json($setting, 201);
        }
        return response()->json(['error' => 'Insert Failed.'], 400);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,
            [
                'value' => 'required',
            ],
            [
                'value.required' => 'Setting value is required.',
            ]
        );

        $replicate = SystemSetting::find($id);
        $system_setting = $replicate->replicate();
        $system_setting->deleted_by = $request->auth->id;
        $system_setting->push();
        $system_setting->delete();

        $setting_array = [
            'key' => $replicate->key,
            'value' => $request->input('value'),
            'updated_by' => $request->auth->id,
        ];

        $setting = SystemSetting::where('id', $id)->update($setting_array);

        if (!empty($setting)) {
            return response()->json($setting, 200);
        }
        return response()->json(['error' => 'Update Failed.'], 400);
    }

    public function show($id)
    {
        $system_setting = SystemSetting::find($id);
        if (!empty($system_setting)) {
            return new SystemSettingDetailsResource($system_setting);
        }
        return response()->json(NULL, 404);
    }

    public function edit($id)
    {
        $system_setting = SystemSetting::find($id);
        if (!empty($system_setting)) {
            return new SystemSettingResource($system_setting);
        }
        return response()->json(NULL, 404);
    }

    public function delete(Request $request, $id)
    {
        $system_setting = SystemSetting::find($id);
        if (!empty($system_setting)) {
            if ($system_setting->delete()) {
                return response()->json(NULL, 204);
            }
            return response()->json(['error' => 'Delete Failed.'], 400);
        }
        return response()->json(NULL, 404);
    }

    public function trashed()
    {
        $system_setting = SystemSetting::orderBy('deleted_at', 'asc')->onlyTrashed()->get();
        if (!empty($system_setting)) {
            return SystemSettingResource::collection($system_setting);
        }
        return response()->json(NULL, 404);
    }

    public function restore($id)
    {
        $system_setting = SystemSetting::withTrashed()->find($id);
        $check_exists = SystemSetting::where('key', $system_setting->key)->exists();
        if (!$check_exists) {
            if ($system_setting->restore()) {
                return response()->json(['success' => 'Restore successful.'], 201);
            }
            return response()->json(['error' => 'Restore Failed.'], 400);
        }
        return response()->json(NULL, 404);
    }

    public function change_password(Request $request)
    {
        $this->validate($request,
            [
                'employee_id' => 'required|numeric|exists:employees,id',
                'password' => ['required', new CheckStrongPassword, 'confirmed'],
                'password_confirmation' => 'required',
            ]
        );

        $password_confirmation = md5($request->input('password_confirmation'));

        $password = Employee::where(['id' => $request->employee_id])->update([
            'password' => $password_confirmation,
        ]);
        if (!empty($password)) {
            return response()->json(['password' => $password_confirmation], 200);
        }
        return response()->json(['error' => 'Password change Failed.'], 400);
    }
}