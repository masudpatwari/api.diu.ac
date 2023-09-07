<?php

namespace App\Models\BulkSms;

use Illuminate\Database\Eloquent\Model;


class ImportedSms extends Model
{
	protected $table = "imported_sms";

    public function scopeOrderDesc($q)
    {
        $q->orderBy('id', 'desc');
    }

}
