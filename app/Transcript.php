<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transcript extends Model
{
	protected $table = "transcripts";

    use SoftDeletes;
    public $timestamps = false;
	
    protected $fillable = ['regcode', 'transcript_department_id', 'batch', 'shift', 'session', 'name', 'roll', 'cgpa', 'passing_year', 'filename', 'has_file', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by', 'rejected'];

    public function relDepartments()
    {
        return $this->belongsTo('App\TranscriptDepartment', 'transcript_department_id', 'id');
    }
    public function relCreatedBy()
    {
        return $this->belongsTo(Employee::class, 'created_by', 'id');
    }
}
