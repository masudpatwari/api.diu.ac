<?php

namespace App\Models\DIUWebsite;

use App\Employee;
use Illuminate\Database\Eloquent\Model;

class WebsiteProgramBasicInfo extends Model
{
    protected $table = "website_program_basic_infos";

    protected $fillable = [
        'website_program_id',
        'introduction',
        'mission',
        'vission',
        'department_head_speach',
        'department_chairman_id',
    ];

    public function employee(){
        return $this->belongsTo(Employee::class,'department_chairman_id');
    }

}
