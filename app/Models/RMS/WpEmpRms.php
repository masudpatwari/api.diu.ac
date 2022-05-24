<?php

namespace App\Models\RMS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Employee;

class WpEmpRms extends Model
{
    protected $connection = "rms";
    protected $table = "wp_emp";
    public $timestamps = false;

    protected $hidden = [
        'pass'
    ];

    public static function getLockedRmsUser()
    {
        return self::where('lock_for_rms', 1)->get();
    }


    public static function employeeExistsInRms($cmsEmpId)
    {

        $cms = Employee::with('relShortPosition', 'relCampus', 'relDesignation', 'relDepartment',
            'relAttendanceIds')->findOrFail($cmsEmpId);

        $rms = self::where('email1', $cms->office_email)->first();

        if ($rms) {
            return [
                $rms->id,
                $rms->name,
                $rms->email1,
                $rms->dept,
                $rms->position
            ];
        }

        return false;
    }

    public static function cmsSyncToRms($cmsEmpId)
    {
        $cms = Employee::with('relShortPosition', 'relCampus', 'relDesignation', 'relDepartment',
            'relAttendanceIds')->findOrFail($cmsEmpId);

        if (!$cms) return 400;

        $rms = self::where('email1', $cms->office_email)->first();

        $status = 200;
        if (!$rms) {
            // rms will add new employee from cms db
            $rms = new self();
            $rms->merit = 6;
            $rms->level = 6;
            $rms->activestatus = 1; // 1 = active user.
            $rms->lock_for_rms = 1;// 1 = locked
            $status = 201;
        }

        $rms->name = $cms->name;
        $rms->position = $cms->relDesignation->name;
        $rms->jobtype = $cms->jobtype;
        $rms->dept = $cms->relDepartment->name;
        $rms->DOB = date("Y-m-d", $cms->date_of_birth);
        $rms->DOJ = date("Y-m-d", $cms->date_of_join);
        $rms->campus = $cms->relCampus->name;
        $rms->idno = $cms->relAttendanceIds->att_card_id;
        $rms->preidno = '0';
        $rms->oadd = $cms->office_address;
        $rms->ophone = $cms->office_phone_no;
        $rms->hphone = $cms->home_phone_no;
        $rms->mno1 = $cms->personal_phone_no;
        $rms->mno2 = $cms->alternative_phone_no;
        $rms->smno = $cms->spous_phone_no;
        $rms->pmno = $cms->parents_phone_no;
        $rms->omno = $cms->other_phone_no;
        $rms->email1 = $cms->office_email;
        $rms->email2 = $cms->private_email;
        $rms->photo = $cms->profile_photo_file;
        $rms->scard = $cms->signature_card_photo_file;
        $rms->pphoto = $cms->cover_photo_file;
        $rms->ugroup = $cms->type;
        $rms->usrcategory = $cms->type;


        $rms->incharge = $cms->type;
        $rms->pass = $cms->password;
        $rms->holiday = '';
        $rms->ost = '0';
        $rms->oet = '0';
        $rms->att_id = $cms->relAttendanceIds->att_data_id;
        $rms->emp_short_position = $cms->relShortPosition->name;
        $rms->save();

        return $status;
    }

    public static function cmsEmployeeNotInRms()
    {

        $rmsEmployeeMails = WpEmpRms::select('email1')->pluck('email1');

        return Employee::with('relShortPosition', 'relCampus', 'relDesignation', 'relDepartment', 'relAttendanceIds')
            ->whereNotIn('office_email', $rmsEmployeeMails)
            ->get();

    }

    public static function lockEmployeeOnRms($rmsEmployeeId)
    {
        $employee = WpEmpRms::findOrFail($rmsEmployeeId);
        $employee->activestatus = 0;
        $employee->lock_for_rms = 1;
        $employee->save();
        return true;
    }

    public static function lockEmployeeOnRmsByCmsEmail($email)
    {
        $cmsEmployee = Employee::where('office_email', trim($email))->first();

        if (!$cmsEmployee) return false;

        $employee = WpEmpRms::where('email1', $cmsEmployee->office_email)->first();
        $employee->activestatus = 0;
        $employee->lock_for_rms = 1;
        $employee->save();
        return true;
    }

    public static function unlockEmployeeOnRms($rmsEmployeeId)
    {
        $employee = WpEmpRms::findOrFail($rmsEmployeeId);
        $employee->activestatus = 1;
        $employee->lock_for_rms = 0;
        $employee->save();
        return true;
    }


    public static function unlockEmployeeOnRmsByCmsEmail($email)
    {
        $cmsEmployee = Employee::where('office_email', trim($email))->first();

        if (!$cmsEmployee) return false;

        $employee = WpEmpRms::where('email1', $cmsEmployee->office_email)->first();

        if (!$employee) return false;

        $employee->activestatus = 1;
        $employee->lock_for_rms = 0;
        $employee->save();
        return true;
    }

    public static function destroy($id)
    {
        $employee = WpEmpRms::find($id);
        $employee->activestatus = 0;
        $employee->lock_for_rms = 1;
        $employee->save();
        return true;
    }

    public static function destroyByEmail($email)
    {
        $cmsEmployee = Employee::where('office_email', trim($email))->first();

        if (!$cmsEmployee) return false;

        $employee = WpEmpRms::where('email1', $cmsEmployee->office_email)->first();
        if (!$employee) return false;
        $employee->activestatus = 0;
        $employee->lock_for_rms = 1;
        $employee->save();
        return true;
    }

    public static function changeEmail($presentEmail, $changeToEmail)
    {
        $employee = self::where('email1', $presentEmail)->first();

        if (!$employee) return false;

        $employee->email1 = $changeToEmail;
        $employee->save();
        return true;
    }

    public static function changePassword($email, $passwordInMd5)
    {
        $employee = self::where('email1', $email)->first();

        if (!$employee) return false;

        $employee->pass = $passwordInMd5;
        $employee->save();
        return true;
    }

}
