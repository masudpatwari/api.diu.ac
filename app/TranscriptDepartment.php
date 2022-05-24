<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TranscriptDepartment extends Model
{
	protected $table = "transcriptDepartments";

    use SoftDeletes;

    public function relTranscripts()
    {
        return $this->hasMany('App\Transcript', 'transcript_department_id', 'id');
    }
}
