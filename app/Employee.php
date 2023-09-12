<?php

namespace App;

use App\Models\RMS\WpEmpRms;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\EmployeeShortDetailsResource;

class Employee extends Model
{
    protected $table = "employees";
    protected $connection = 'mysql';

    const ACTIVE = 1;
    const INACTIVE = 0;

    protected $fillable = [
        'name',
        'slug_name',
        'type',
        'designation_id',
        'department_id',
        'office_email',
        'private_email',
        'personal_phone_no',
        'alternative_phone_no',
        'spous_phone_no',
        'parents_phone_no',
        'other_phone_no',
        'office_phone_no',
        'home_phone_no',
        'gurdian_phone_no',
        'jobtype',
        'date_of_birth',
        'date_of_join',
        'campus_id',
        'nid_no',
        'office_address',
        'profile_photo_file',
        'signature_card_photo_file',
        'cover_photo_file',
        'password',
        'activestatus',
        'lock_for_rms',
        'rms_permissions',
        'permissions',
        'weekly_worked_hour',
        'salary_report_sort_id',
        'created_by',
        'supervised_by',
        'shortPosition_id',
        'overview',
        'groups',
        'merit',
        'total_rating_provider',
        'average_rating'
    ];

    protected $hidden = ['password'];

    /*protected $hidden = [
        'password',
    ]*/

    public function relShortPosition()
    {
        return $this->belongsTo('App\ShortPosition', 'shortPosition_id', 'id');
    }

    public function relGallery()
    {
        return $this->hasMany('App\Gallery', 'employee_id', 'id');
    }

    public function relCampus()
    {
        return $this->belongsTo('App\Campus', 'campus_id', 'id');
    }

    public function relDesignation()
    {
        return $this->belongsTo('App\Designation', 'designation_id', 'id');
    }

    public function relDepartment()
    {
        return $this->belongsTo('App\Department', 'department_id', 'id');
    }

    public function relOfficeTime()
    {
        return $this->hasMany('App\OfficeTime', 'employee_id', 'id');
    }

    public function relEmployeeRole()
    {
        return $this->hasMany('App\EmployeeRole', 'employee_id', 'id');
    }

    public function relEmployeeUpdateHistory()
    {
        return $this->hasMany('App\EmployeeUpdateHistory', 'employee_id', 'id');
    }

    public function relAttendanceIds()
    {
        return $this->hasOne('App\AttendanceId', 'employee_id', 'id');
    }

    public function relLeaveApplication()
    {
        return $this->hasMany('App\LeaveApplication', 'employee_id', 'id');
    }

    public function relCreatedByHoliday()
    {
        return $this->hasMany('App\Holiday', 'employee_id', 'id');
    }

    /*
     * relSubordinate [ Employee Immediate under by me]
    */
    public function relImmediateSubordinate()
    {
        return $this->belongsTo('App\LeaveApplication', 'employee_id', 'id');
    }


    /*
     * relSubordinate [ Employee Immediate senior by me]
    */
    public function relImmediateSuperior()
    {
        return $this->hasMany('App\LeaveApplication', 'employee_id', 'id');
    }

    /*
     * Get supervised by using employee id
    */
    public static function supervised_by($employee_id)
    {
        $data = static::selectRaw('supervised_by')->where(['id' => $employee_id])->first();
        return (!empty($data->supervised_by)) ? $data->supervised_by : $employee_id;
    }

    /*
     * Get superordinate employees
    */
    public static function superordinate($employee_id)
    {
        $level = [];
        $data['data'] = [];
        do {
            if (count($level) == 0) {
                $x = static::where('id', $employee_id)->first();
                $level[] = $x->supervised_by;
            } else {
                if (!empty($level[count($level) - 1])) {
                    $x = static::where('id', $level[count($level) - 1])->first();
                    $level[] = $x->supervised_by;
                    $data['data'][] = new EmployeeShortDetailsResource($x);
                } else {
                    break;
                }
            }
        } while ($level[count($level) - 1]);
        unset($data['data'][5]);
        return $data;
    }

    /*
     * Get subordinate employees
    */
    public static function subordinate($employee_id)
    {
        $level = [];
        $data['data'] = [];
        do {
            if (count($level) == 0) {
                $x = static::where('supervised_by', $employee_id)->get();
                $level[] = $x->pluck('id')->toArray();
                $data['data'][] = EmployeeShortDetailsResource::collection($x);
            } else {
                $x = static::whereIn('supervised_by', $level[count($level) - 1])->get();
                $level[] = $x->pluck('id')->toArray();
                $data['data'][] = EmployeeShortDetailsResource::collection($x);
            }
        } while ($level[count($level) - 1]);
        unset($data['data'][count($level) - 1]);
        return $data;
    }

    /*
     * Get subordinate employees ids
    */
    public static function subordinate_ids($employee_id)
    {
        $level = [];
        $data = [];
        do {
            if (count($level) == 0) {
                $x = static::where('supervised_by', $employee_id)->get();
                $level[] = $x->pluck('id')->toArray();
                $data[] = array_merge($data, $x->pluck('id')->toArray());
            } else {
                $x = static::whereIn('supervised_by', $level[count($level) - 1])->get();
                $level[] = $x->pluck('id')->toArray();
                $data[] = array_merge($data, $x->pluck('id')->toArray());
            }
        } while ($level[count($level) - 1]);

        return $data;
    }


    /*
     * Get coordinate employees
    */
    public static function coordinate($employee_id)
    {
        $supervised_id = static::where('id', $employee_id)->first()->supervised_by;
        $data = static::where('supervised_by', $supervised_id)->where('id', '!=', $employee_id)->get();
        return EmployeeShortDetailsResource::collection($data);
    }

    public static function haveCurrentRouteAccessPermissions($routeName, $user_id)
    {


        /**
         *   user will get access permission of courrent route if user is accessing common route for all user
         */
        $commonRouteNames = getAllLogedinUserCanAccessRouteNameAsArray();

        if (in_array($routeName, $commonRouteNames)) {
            return true;
        }

        $roleIds = \App\EmployeeRole::where('employee_id', $user_id)->pluck('role_id')->toArray();
        $roles = \App\Role::whereIn('id', $roleIds)->get();

        /**
         *   if user has role `su` then user can access all route :)
         */
        if ($roles->where('slug', 'su')->count()) return true;

        $permittedRouteName = [];

        foreach ($roles as $role) {
            if (trim($role->permissions))
                $permittedRouteName = array_merge($permittedRouteName, json_decode($role->permissions));
        }

        if (in_array($routeName, $permittedRouteName)) return true;

        $personalPermisssions = Employee::where('id', $user_id)->first()->permissions;
        if ($personalPermisssions) {
            return in_array($routeName, json_decode($personalPermisssions));
        }
        /**
         *   TASKS:
         *   =====
         *   1.add  route  permission that is permitted from $permittedRouteName
         *   2. remove route  permission that is not permitted $permittedRouteName
         */

        return in_array($routeName, $permittedRouteName);

    }

    public function relAcademicQualifications()
    {
        return $this->hasMany('App\AcademicQualifications', 'employee_id', 'id');
    }

    public function relTrainingExperience()
    {
        return $this->hasMany('App\TrainingExperiences', 'employee_id', 'id');
    }

    public function relAreaOfSkills()
    {
        return $this->hasMany('App\AreaOfSkills', 'employee_id', 'id');
    }

    public function relPublications()
    {
        return $this->hasMany('App\Publications', 'employee_id', 'id');
    }

    public function relAwards()
    {
        return $this->hasMany('App\AwardScholarships', 'employee_id', 'id');
    }

    public function relExpartOn()
    {
        return $this->hasMany('App\ExpartOn', 'employee_id', 'id');
    }

    public function relSocial()
    {
        return $this->hasMany('App\SocialContact', 'employee_id', 'id');
    }

    public function relEmployment()
    {
        return $this->hasMany('App\PreviousEmployments', 'employee_id', 'id');
    }

    public function relCounselingHour()
    {
        return $this->hasMany('App\CounsellingHours', 'employee_id', 'id');
    }

    public function relMemberships()
    {
        return $this->hasMany('App\MemberShips', 'employee_id', 'id');
    }


    /*
     * Get subordinate employees
    */
    public static function isSubordinate($superordinate_id, $subordinate_id)
    {
        $subordinateArray = [];
        $level = [];

        do {
            if (count($level) == 0) {
                $x = static::where('supervised_by', $superordinate_id)->get();
                $level[] = $x->pluck('id')->toArray();
            } else {
                $x = static::whereIn('supervised_by', $level[count($level) - 1])->get();
                $level[] = $x->pluck('id')->toArray();
            }
        } while ($level[count($level) - 1]);
        $ids = array_flatten($level);
        if (in_array($subordinate_id, $ids)) {
            return true;
        }
        return false;
    }


    public function pbx_extention()
    {
        return $this->belongsTo('App\Models\PBX\User', 'name', 'name');
    }


    public function rmsEmployee()
    {
        return $this->belongsTo(WpEmpRms::class, 'office_email', 'email1');
    }

    public function relOfficeOffDay()
    {
        return $this->belongsTo('App\OfficeTime', 'id', 'employee_id')->where('type', 'offday');
    }


}
