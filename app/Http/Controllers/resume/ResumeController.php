<?php

namespace App\Http\Controllers\resume;

use App\Mail\CandidateConfirmationMail;
use App\Mail\CandidateRejectionMail;
use App\Resume;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


class ResumeController extends Controller
{
    public function index()
    {
//        return Resume::where('a_status', 1)->latest('id')->get();
        return Resume::where('a_status', 1)->get();
    }

    public function consent()
    {
        return Resume::where('a_status', 3)->get();
    }


    public function store(Request $request)
    {
        $info = $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:students.resumes,email',
            'phone' => 'required|string|max:13|unique:students.resumes,phone',
            'qualifications' => 'required|string',
            'resume' => 'required|mimes:doc,docs,pdf|max:10000',
            'image' => 'required|mimes:jpg,jpeg,png|max:512',
            'dob' => 'required|date',
            'gender' => 'required|in:male,female',
            'status' => 'required|in:married,unmarried',
        ]);

        $info['date'] = date('Y-m-d H:i:s');
        $info['dob'] = Carbon::parse($request->dob)->format('Y-m-d');
        $info['a_status'] = 1;

        try {
            $candidate = Resume::create($info);

            /**
             * UPLOAD PHOTO
             */
            if ($request->hasFile('resume') && $request->file('resume')->isValid()) {

                $image = $request->file('resume');
                $extention = strtolower($image->getClientOriginalExtension());

                $profile_photo_fileName = 'images/resumes/' . 'resume_' . $candidate->id . '.' . $extention;

                $request->file('resume')->move(storage_path('images/resumes'), $profile_photo_fileName);

                $candidate->update(['resume' => $profile_photo_fileName]);
            }
            /**
             * UPLOAD PHOTO
             */
            if ($request->hasFile('image') && $request->file('image')->isValid()) {

                $image = $request->file('image');
                $extention = strtolower($image->getClientOriginalExtension());

                $profile_photo_fileName = 'images/resumes/' . 'image_' . $candidate->id . '.' . $extention;

                $request->file('image')->move(storage_path('images/resumes'), $profile_photo_fileName);

                $candidate->update(['image' => $profile_photo_fileName]);
            }

            return $candidate->id;

        }catch(\Exception $exception)
        {
            return response(['error' => $exception->getMessage(), 400]);
        }
    }

    public function status($id){
        $resume = Resume::find($id);

        if($resume && $resume->a_status== 1)
        {
            //send mail with attachment
            try {

                Mail::to($resume->email)->send(new CandidateConfirmationMail($resume));

                $resume->update([
                    'a_status' => 2
                ]);

                return Resume::where('a_status', 1)->get();
            }catch (\Exception $exception)
            {
                return response('mail send error', 400);
            }

        }
    }

    public function statusNotEligible($id){
        $resume = Resume::find($id);

        if($resume)
        {
            $resume->update([
                'a_status' => 0
            ]);

            Mail::to($resume->email)->send(new CandidateRejectionMail($resume));


            return Resume::where('a_status', 1)->get();
        }

        return response(['error' => 'Candidate Not Found'], 400);

    }

    public function statusEligible($id){
        $resume = Resume::find($id);

        if($resume)
        {
            $resume->update([
                'a_status' => 1
            ]);

            return Resume::where('a_status', 1)->get();
        }

        return response(['error' => 'Candidate Not Found'], 400);

    }

    public function informationSubmit($info)
    {
        $information = decrypt($info);

        $explode_by = '.0.0.0.0.';

        $information = explode($explode_by, $information);

        $candidate_id = $information[0];


        $dob = $information[1];

        $found = Resume::where(['id' => $candidate_id, 'dob' => $dob, 'a_status' => 2])->first();

        if($found)
        {
            return redirect("https://jobs.diu.ac/submit.php?token={$info}");
        }

        $type = 'image/jpeg';
        $headers = ['Content-Type' => $type];
        $path = storage_path('images/404.jpeg');

        $response = new BinaryFileResponse($path, 200 , $headers);

        return $response;

    }

    public function file(Request $request)
    {
        $this->validate($request, [
            'token' => 'required|string',
            'file' => 'required|mimes:jpg,jpeg,pdf|max:10000',
        ]);

        $information = decrypt($request->input('token'));

        $explode_by = '.0.0.0.0.';


        $information = explode($explode_by, $information);

        $candidate_id = $information[0];

        $dob = $information[1];


        $found = Resume::where(['id' => $candidate_id, 'dob' => $dob, 'a_status' => 2])->first();

        if($found)
        {

            try {

                if ($request->hasFile('file') && $request->file('file')->isValid()) {

                    $image = $request->file('file');
                    $extention = strtolower($image->getClientOriginalExtension());

                    $profile_photo_fileName = 'images/resumes/' . 'file_' . $found->id . '.' . $extention;

                    $request->file('file')->move(storage_path('images/resumes'), $profile_photo_fileName);

                    $found->update(['file' => $profile_photo_fileName]);
                }

            }catch(\Exception $exception)
            {
                return response($extention->getMessage(), 401);
            }

            $found->update([
                'a_status' => 3
            ]);

            return response($found->name, 200);

        }

        return response('error', 400);
    }
}
