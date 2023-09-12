<?php

namespace App\Models\adsn;

use Illuminate\Database\Eloquent\Model;
use App\Employee;

class EnglishBookFormDetails extends Model
{
    protected $connection = 'adm';

    protected $table = 'b_details';

    protected $guarded = [];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(Employee::class, 'saler_id', 'id');
    }
}
