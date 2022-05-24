<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LiaisonOfficer extends Model
{
	protected $fillable = [
		'name','fatherName','division','district','ps','address','occupation','institute','email','mobile1','mobile2','code','officerMobileNumber','created_by'
	];

    use SoftDeletes;

	public function scopeFindLiaisonOfficers($query, $items)
    {
        if ($items->code) {
            $query->where('code', 'like', '%'.$items->code.'%');
        }
        if ($items->name) {
            $query->where('name', 'like', '%'.$items->name.'%');
        }
        if ($items->father_name) {
            $query->where('fatherName', 'like', '%'.$items->father_name.'%');
        }
        if ($items->division) {
            $query->where('division', 'like', '%'.$items->division.'%');
        }
        if ($items->district) {
            $query->where('district', 'like', '%'.$items->district.'%');
        }
        if ($items->police_station) {
            $query->where('ps', 'like', '%'.$items->police_station.'%');
        }
        if ($items->address) {
            $query->where('address', 'like', '%'.$items->address.'%');
        }
        if ($items->occupation) {
            $query->where('occupation', 'like', '%'.$items->occupation.'%');
        }
        if ($items->institute) {
            $query->where('institute', 'like', '%'.$items->institute.'%');
        }
        if ($items->email) {
            $query->where('email', 'like', '%'.$items->email.'%');
        }
        if ($items->mobile) {
            $query->where('mobile1', 'like', '%'.$items->mobile.'%')->orWhere('mobile2', 'like', '%'.$items->mobile.'%');
        }
        if ($items->office_mobile) {
            $query->where('officerMobileNumber', 'like', '%'.$items->office_mobile.'%');
        }
        return $query;
    }
}
