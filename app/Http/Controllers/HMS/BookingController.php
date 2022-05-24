<?php

namespace App\Http\Controllers\HMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\STD\Student;
use App\Models\HMS\Booking;


class BookingController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $bookings = Booking::get();


        $bookings = $bookings->map(function($item) use($students){

            return [
                'issue_date'    => $item->issue_date,
                'bed_type'      => $item->bed_type,
                'room_id'       => $item->room_id,
                'hostel_id'     => $item->hostel_id,
                'student'       => $student_info
            ];
        });

        if (!empty($bookings)) {
            return response()->json($bookings);
        }
        return response()->json(NULL, 404);
    }
}
