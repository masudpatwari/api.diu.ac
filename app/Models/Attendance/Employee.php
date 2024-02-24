<?php

namespace App\Models\Attendance;


use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = "emp";
    public $timestamps = false;
    protected $connection = 'attendance';

    protected $fillable = [
        'name',
        'position',
        'dept',
        'DOB',
        'DOJ',
        'campus',
        'idno',
        'preidno',
        'oadd',
        'ophone',
        'hphone',
        'mno1',
        'mno2',
        'smno',
        'pmno',
        'omno',
        'email1',
        'email2',
        'scard',
        'ugroup',
        'merit',
        'incharge',
        'pass',
        'activestatus',
        'holiday',
        'ost',
        'oet',
        'att_id',
        'emp_short_position',
    ];
}
