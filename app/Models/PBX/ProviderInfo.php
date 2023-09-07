<?php

namespace App\Models\PBX;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProviderInfo extends Model
{
    use SoftDeletes;

	protected $table = "pbx_provider";

    protected $connection = 'pbxsms';
//     protected $connection = 'pbx';

    protected $dates = [
    ];

    protected $fillable = [
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function scopeInActive($query)
    {
        return $query->where('is_active', 0);
    }

}
