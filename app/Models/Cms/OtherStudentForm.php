<?php

namespace App\Models\Cms;

use App\Docmtg;
use App\Employee;
use App\Models\STD\BankSlip;
use Illuminate\Database\Eloquent\Model;

class OtherStudentForm extends Model
{
    protected $table = "other_student_forms";

    protected $fillable = [
        'name',
        'form_name',
        'department_id',
        'batch_id',
        'student_id',
        'purpose_id',
        'total_payable',
        'bank_id',
        'bank_payment_date',
        'note',
        'receipt_no',
        'created_by',
        'reg_code',
        'cgpa',
        'shift',
        'session',
        'passing_year',
        'roll',
        'status',
        'mobile_no',
        'email',
        'bank_slip_id',
        'convocation_first_degree', //int default 0; 1 = ace
        'convocation_second_degree', //int default 0; 1= ace
        'code',
        'semester',
        'download_by'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'created_by', 'id');
    }

    public function otherStudentFormResearch()
    {
        return $this->belongsTo(OtherStudentFormResearch::class, 'id', 'other_student_form_id');
    }

    public function otherStudentFormConvocationSecondDegree()
    {
        return $this->belongsTo(OtherStudentFormConvocationSecondDegree::class, 'id', 'other_student_form_id');
    }

    public function bankSlip()
    {
        return $this->belongsTo(BankSlip::class, 'bank_slip_id', 'id');
    }

    public function docmtg()
    {
        return $this->belongsTo(Docmtg::class, 'reference_no', 'doc_mtg_code');
    }

    public function otherStudentFormReceivedStatus()
    {
        return $this->hasMany(OtherStudentFormStatus::class, 'other_student_form_id', 'id')->whereType('received');
    }

    public function otherStudentFormPreparedStatus()
    {
        return $this->hasMany(OtherStudentFormStatus::class, 'other_student_form_id', 'id')->whereType('prepared');
    }

    public function otherStudentFormComparedStatus()
    {
        return $this->hasMany(OtherStudentFormStatus::class, 'other_student_form_id', 'id')->whereType('compared');
    }

    public function otherStudentFormVerifiedStatus()
    {
        return $this->hasMany(OtherStudentFormStatus::class, 'other_student_form_id', 'id')->whereType('verified');
    }

    public function otherStudentFormSeenStatus()
    {
        return $this->hasMany(OtherStudentFormStatus::class, 'other_student_form_id', 'id')->whereType('seen');
    }

    public function otherStudentFormApprovedStatus()
    {
        return $this->hasMany(OtherStudentFormStatus::class, 'other_student_form_id', 'id')->whereType('approved');
    }

    public function pdfFileName($otherStudentForm = null)
    {
        // for msc thesis and project
        if ($this->department_id == 4) {
            if ($otherStudentForm && str_contains($otherStudentForm['batch']['batch_name'], 'Project')) {
                return '3_msc_project_transcript';
            } else {
                return '3_msc_thesis_transcript';
            }
        }

        return [
                '1' => '4_sociology_two_year_transcript',
                '2' => '12_cse_day_transcript',
                '3' => '12_cse_evening_transcript',
                '5' => '12_eete_day_transcript',
                '6' => '12_eete_evening_transcript',
                '7' => '12_civil_day_transcript',
                '8' => '12_civil_evening_transcript',
                '9' => '8_b_pharma_transcript',
                '11' => '12_english_evening_transcript',
                '12' => '2_english_one_year_transcript',
                '13' => '2_english_two_year_transcript',
                '15' => '12_sociology_evening_transcript',
                '16' => '2_sociology_one_year_transcript',
                '17' => '12_llb_day_transcript',
                '20' => '2_llm_one_year_transcript',
                '21' => '4_llm_two_year_transcript',
                '22' => '4_mhrl_transcript',
                '23' => '12_bba_day_transcript',
                '25' => '2_rmba_one_year_transcript',
                '26' => '4_emba_two_year_transcript',
            ][$this->department_id] ?? '';

    }


    public function studentShiftName()
    {
        return [
                '1ST SHIFT' => 'First Shift',
                '2ND SHIFT' => 'Second Shift',
                'FRIDAY-SATURDAY' => 'Friday-Saturday',
            ][$this->shift] ?? 'FRIDAY-SATURDAY';
    }


}
