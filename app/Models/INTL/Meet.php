<?php

namespace App\Models\INTL;

use Illuminate\Database\Eloquent\Model;
use App\Models\INTL\User as InternationalUser;
use App\Models\INTL\ForeignStudent;
use Carbon\Carbon;
use App\Http\Resources\intl\VisaExpireResource;
use Illuminate\Http\Request;


class Meet extends Model
{
	// protected $table = "meets";
    protected $connection = 'intl';

    protected $dates = [
        'next_date',
    ];

    protected $fillable = [
        "student_id",
        "comment",
        "meet_by",
        // "next_date",
    ];


    public function relForeignStudent()
    {
        return $this->belongsTo(ForeignStudent::class, 'student_id', 'student_id');
    }


    public static function findForeignStudent( int $studentId , $withUser = false, $withDump = false)
    {
        $student = InternationalUser::dump($withDump)->where('student_id', $studentId )->first();

        if ( $student ) {
            if ( $withUser) {
                $student->load(['relForeignStudent','relEmployee']);
            }
            return $student;
        }

        throw new \Exception("No student Found", 400);        

    }
    
}
