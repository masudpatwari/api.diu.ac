<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mobilepayment extends Model
{
	protected $table = "mobilepayment";

    protected $fillable = [

    ];
	
	public static function getData($verified=false){
      return self::where('isverified', $verified)
      ->where('deleted_at',null)
      ->orderBy('created_at','desc')->simplePaginate(env('PER_PAGE_ITEM',2000));
    }

    public function relEmployee()
    {
        return $this->hasMany('App\Employee', 'verified_by', 'id');
    }

    public static function deleteMobilepayment($id){
      return self::where('id',$id)->update(['deleted_at'=> date('Y-m-d H:i:s')]);
    }
}
