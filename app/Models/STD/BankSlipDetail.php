<?php

namespace App\Models\STD;

use Illuminate\Database\Eloquent\Model;

class BankSlipDetail extends Model
{
    protected $table = "bank_slip_details";
    protected $connection = 'std';

    protected $guarded = ['id'];
}
