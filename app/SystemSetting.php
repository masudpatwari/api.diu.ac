<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SystemSetting extends Model
{
    protected $table = "system_settings";
    
    use SoftDeletes;
    
    protected $fillable = [
        'key',
        'value',
        'created_by',
    ];

    public function relCreatedBy()
    {
        return $this->belongsTo('App\Employee', 'created_by', 'id');
    }

    public function relUpdatedBy()
    {
        return $this->belongsTo('App\Employee', 'updated_by', 'id');
    }

    public function relDeletedBy()
    {
        return $this->belongsTo('App\Employee', 'deleted_by', 'id');
    }
}
