<?php

namespace App\Http\Controllers\bapi;

use App\BStudent;
use App\Http\Controllers\Controller;
use App\Traits\RmsApiTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BapiController extends Controller
{
    use RmsApiTraits;

    public function index()
    {
        $bapiCache = $this->bapiCacheClear();

        if (!$bapiCache) {

            return response()->json(['error' => 'data not found'], 406);

        }

        return response()->json(['message' => 'Bapi Cache Cleaered Successfully'], 200);
    }


    public function blockedStudent()
    {
//        BStudent::truncate();
//        BStudent::create(
//            [
//                'name' => 'ABU BAKAR SIDDIK KHAN',
//                'department' => 'B.PHARM',
//                'batch' => 24,
//                'roll' => 52,
//                'fb_link' => 'https://www.facebook.com/100009643489074/',
//                'problem' => 'missing proper documents',
//                'entry_date' => date('Y-m-d H:i:s'),
//                'photo' => 'images/student_profile_photo_16659.jpg',
//                'entry_by' => 842,
//            ]
//        );


        return BStudent::get()->map(function($item){
            $info = $this->student_infos($item->student_id);

            return [
              'name' => $info['name'],
              'department' => $info['name'] ?? '',
              'department' => $info['department']['name'] ?? '',
              'batch' => $info['batch']['batch_name'] ?? '',
              'roll' => $info['roll_no'] ?? '',
              'reg' => $info['reg_code'] ?? '',
              'fb' => $item->fb_link ?? '',
              'photo' => $item->photo ?? '',
            ];
        });

    }


    public function store(Request $request)
    {

        $info = $this->validate($request, [
            'department_id' => 'required|integer',
            'batch_id' => 'required|integer',
            'student_id' => 'required|integer',
            'fb_link' => 'nullable',
            'problem' => 'nullable',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:512',
            'image_link' => 'nullable|string',
        ]);

        unset($info['photo']);
        $info['entry_by'] = $request->auth->id;
        $info['entry_date'] = date('Y-m-d');
//        $info['phot'] = date('Y-m-d');

        $student = BStudent::create(
            $info
        );

        /**
         * UPLOAD PHOTO
         */
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {

            $image = $request->file('photo');
            $extention = strtolower($image->getClientOriginalExtension());

            $profile_photo_fileName = 'images/' . 'blocked_student_file_' . $request->student_id . '.' . $extention;

            $request->file('photo')->move(storage_path('/images'), $profile_photo_fileName);

            $student->update(['photo' => $profile_photo_fileName]);

        }
    }


    public function session()
    {
        try {
            return $this->traits_get_session_assign();
        }catch(\Exception $exception)
        {
            return $exception->getMessage();
        }
    }

    public function supervisor_change()
    {
        return 'ok';
    }
    
}
