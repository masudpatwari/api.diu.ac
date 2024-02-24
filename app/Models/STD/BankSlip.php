<?php

namespace App\Models\STD;

use Illuminate\Database\Eloquent\Model;

class BankSlip extends Model
{
    protected $table = "bank_slips";
    protected $connection = 'std';

    protected $guarded = ['id'];

    public function scopedsc($q)
    {
        $q->orderBy('id', 'desc');
    }

    public function student()
    {
        return $this->belongsTo('App\Models\STD\Student', 'student_id', 'ID')->select('ID', 'NAME', 'REG_CODE');
    }

    public function bank_slip_details()
    {
        return $this->hasMany('App\Models\STD\BankSlipDetail', 'bank_slip_id');
    }
}
