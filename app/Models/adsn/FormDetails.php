<?php

namespace App\Models\adsn;

use Illuminate\Database\Eloquent\Model;
use App\Employee;

class FormDetails extends Model
{
    protected $connection = 'adm';

    protected $table = 'details';

    protected $guarded = [];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(Employee::class, 'saler_id', 'id');
    }
}
