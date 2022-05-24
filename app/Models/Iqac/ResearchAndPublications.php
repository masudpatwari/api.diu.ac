<?php

namespace App\Models\Iqac;

use App\Employee;
use Illuminate\Database\Eloquent\Model;

class ResearchAndPublications extends Model
{
    protected $connection = "iqac";
    protected $table = "research_and_publications";

    protected $fillable = [
        'type',
        'title',
        'file_path',
        'created_by',
        'cover_file',
    ];

    public function user()
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

}
