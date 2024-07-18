<?php

namespace App\Models\STD;


use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = "student";
    protected $connection = 'std';

    // public function __construct(array $attributes = [])
    // {
    //     $this->table = env('DB_HMS_DATABASE').'.'.$this->table;
    //     parent::__construct($attributes);
    // }

    protected $fillable = ['ID', 'NAME', 'slug_name', 'site_tag', 'ROLL_NO', 'REG_CODE', 'PASSWORD', 'EMAIL',
        'DEPARTMENT_ID', 'BATCH_ID', 'SHIFT_ID', 'YEAR', 'REG_SL_NO', 'GROUP_ID', 'BLOOD_GROUP', 'PHONE_NO', 'ADM_FRM_SL', 'RELIGION', 'GENDER', 'DOB', 'BIRTH_PLACE', 'FG_MONTHLY_INCOME', 'PARMANENT_ADD', 'MAILING_ADD', 'F_NAME', 'F_CELLNO', 'F_OCCU', 'M_NAME', 'M_CELLNO', 'M_OCCU', 'G_NAME', 'G_CELLNO', 'G_OCCU', 'E_NAME', 'E_CELLNO', 'E_OCCU', 'E_ADDRESS', 'E_RELATION', 'EMP_ID', 'NATIONALITY', 'MARITAL_STATUS', 'ADM_DATE', 'CAMPUS_ID', 'STD_BIRTH_OR_NID_NO', 'FATHER_NID_NO', 'MOTHER_NID_NO', 'about_me', 'IS_VERIFIED', 'profile_photo', 'show_profile_publicly', 'last_donate'];
//
//    protected $guarded = ['email_one_time_password'];

    protected $hidden = [ 'diu_email_pass', 'wifi_password'];

    protected $appends = ['email_one_time_password'];

    public function relStudentSocialContact()
    {
        return $this->hasMany('App\Models\STD\StudentSocialContact', 'student_id', 'ID');
    }

    public function relStudentEducation()
    {
        return $this->hasMany('App\Models\STD\StudentEducation', 'student_id', 'ID');
    }
    public function relStudentBlood()
    {
        return $this->hasMany('App\Models\Tolet\BloodDonate', 'students_id', 'ID')->orderBy('last_donate', 'DESC');
    }

    public function relDepartment()
    {
        return $this->belongsTO('App\Models\STD\Department', 'DEPARTMENT_ID', 'ID');
    }

    public function relAttendanceReport()
    {
        return $this->hasMany('App\Models\STD\AttendanceReport', 'student_id', 'id');
    }

    public function relBatch()
    {
        return $this->belongsTo('App\Models\STD\Batch', 'BATCH_ID', 'ID')->select(['ID', 'BATCH_NAME']);
        //        return $this->belongsTo('App\Models\STD\Batch', 'BATCH_ID', 'ID')->select([ 'NAME']);
    }

    public function getEmailOneTimePasswordAttribute()
    {
        return $this->diu_email_pass;
    }
}
