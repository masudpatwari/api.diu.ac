<?php

namespace App\Http\Controllers\Alumni;

use App\Models\alumni\Alumni;
use App\Models\alumni\AlumniJobDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AlumniController extends Controller
{
    private $avatar;
    private $short_interview_video;

    public function alumni_list()
    {
        $alumni = Alumni::select('id','name','department','batch','roll','shift','session','phone','email', 'avatar', 'facebook_link', 'linkedin_link','twitter_link')->latest()->paginate(16);
          
        return $alumni;
    }

    public function alumni_info($id)
    {
        try {
            $alumni = Alumni::where('id', $id)->with('alumni_job_details')->firstOrFail();
//            $alumni = Alumni::where('user_name', $name)->whereHas('alumni_job_details')->with('alumni_job_details')->firstOrFail();
            return response([
                "status" => "success",
                "message" => "Alumni info found",
                "data" => $alumni,
                "status_code" => 200,
            ], 200);
        } catch (\Throwable $th) {
            return response([
                "status" => "error",
                "message" => $th->getMessage(),
                "status_code" => 500,
            ], 500);
        }
    }

    public function alumni_account_has($reg_code)
    {
        Alumni::where('reg_code', $reg_code)->firstOrFail();
        try {
            return response([
                "status" => "success",
                "message" => "Alumni Already Exists",
                "status_code" => 200,
            ], 200);
        } catch (\Throwable $th) {
            return response([
                "status" => "error",
                "message" => "Alumni Not Found",
                "status_code" => 404,
            ], 404);
        }
    }

    public function add_alumni(Request $req)
    {
        info($req->all());
        $data = json_decode($req->input('data'), true);

        $imageValidator = Validator::make($req->all(), [
            'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'short_interview_video' => 'required|mimes:mp4|max:100000',
        ], [
            'short_interview_video.max' => 'Short interview video should be less than 100 MB',
        ]);
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'batch' => 'required|string|max:255',
            'roll' => 'required|integer',
            'shift' => 'required|string|max:255',
            'reg_code' => 'required|integer',
            'session' => 'required',
            'user_name' => 'required|string|max:255|regex:/[a-zA-Z_@.#&+-]+\d+$/|unique:almni.alumnies,user_name',
            'password' => ['required', 'string', 'max:255','min:8'],
            'mobiles' => 'required|array',
            'mobiles.*' => 'required|digits:11',
            'emails' => 'required|array',
            'emails.*' => 'required|string|email|max:255|distinct',
            'present_address' => 'required|string|max:255',
            'facebook_link' => 'required|url|string|max:255',
            'linkedin_link' => 'required|url|string|max:255',
            'instagram_link' => 'url|string|max:255',
            'twitter_link' => 'url|string|max:255',
            'workExperiences.*.company_name' => 'required_with:workExperiences.*.company_address,workExperiences.*.start_date,workExperiences.*.end_date,workExperiences.*.responsibility|string|max:255',
            'workExperiences.*.company_address' => 'required_with:workExperiences.*.company_name,workExperiences.*.start_date,workExperiences.*.end_date,workExperiences.*.responsibility|string|max:255',
            'workExperiences.*.start_date' => 'required_with:workExperiences.*.company_address,workExperiences.*.company_name,workExperiences.*.end_date,workExperiences.*.responsibility|string|max:255',
            'workExperiences.*.end_date' => 'required_with:workExperiences.*.company_address,workExperiences.*.start_date,workExperiences.*.company_name,workExperiences.*.responsibility|string|max:255',
            'workExperiences.*.responsibility' => 'required_with:workExperiences.*.company_address,workExperiences.*.start_date,workExperiences.*.end_date,workExperiences.*.company_name|string|max:255',
            'help_alumni' => 'required|boolean',
            'job_seeker' => 'required|boolean',
        ], [
            'user_name.regex' => 'User name must be Alphanumeric and contain one of (_@.#&+-) and must be ends with number',
            'emails.*.required' => 'Email is required',
            'emails.*.email' => 'Email must be valid email',
            'emails.*.distinct' => 'Email must not be duplicated',
            'mobiles.*.required' => 'Phone is required',
            'mobiles.*.digits' => 'Phone must be valid phone number',
            'mobiles.*.distinct' => 'Phone must not be duplicated',
            'facebook_link.url' => 'Must Be Valid URL',
            'linkedin_link.url' => 'Must Be Valid Url',
            'instagram_link.url' => 'Must Be Valid Url',
            'twitter_link.url' => 'Must Be Valid Url',
        ]);
        if ($validator->fails()) {
            info($validator->errors());
            return response()->json(['error' => $validator->errors()], 422);
        }
        if ($imageValidator->fails()) {
            info($imageValidator->errors());
            return response()->json(['error' => $imageValidator->errors()], 422);
        }

        try {
            $this->fileUpload($req);
            DB::transaction(function () use ($data) {
                $user = Alumni::create([
                    "name" => $data['name'],
                    'user_name' => $data['user_name'],
                    'password' => Hash::make($data['password']),
                    "department" => $data['department'],
                    "batch" => $data['batch'],
                    "roll" => $data['roll'],
                    "shift" => $data['shift'],
                    "reg_code" => $data['reg_code'],
                    "session" => $data['session'],
                    "phone" => $data['mobiles'],
                    "email" => $data['emails'],
                    "present_address" => $data['present_address'],
                    "facebook_link" => $data['facebook_link'],
                    "linkedin_link" => $data['linkedin_link'],
                    "instagram_link" => $data['instagram_link'],
                    "twitter_link" => $data['twitter_link'],
                    "help_alumni" => $data['help_alumni'],
                    "job_seeker" => $data['job_seeker'],
                    "avatar" => $this->avatar,
                    "short_interview_video" => $this->short_interview_video,
                    "created_at" => Carbon::now()
                ]);
                collect($data['workExperiences'])->map(function ($val) use ($user) {
                    if ($val["company_name"] && $val["company_address"] && $val["start_date"] && $val["end_date"] && $val["department"] && $val["responsibility"]) {
                        AlumniJobDetail::create([
                            'alumni_id' => $user->id,
                            'company_name' => $val['company_name'],
                            "company_address" => $val['company_address'],
                            "start_date" => $val['start_date'],
                            "end_date" => $val['end_date'],
                            "department" => $val['department'],
                            "responsibility" => $val['responsibility']
                        ]);
                    }
                });
            });
            return response([
                "status" => "success",
                "message" => "Alumni added successfully",
                "status_code" => 200,
            ], 200);
        } catch (\Throwable $th) {
            info($th);
            return response([
                "status" => "error",
                "message" => $th->getMessage(),
                "status_code" => 500,
            ], 500);
        }
    }


    protected function fileUpload($req)
    {
        if ($req->file('avatar')) {
            $file = $req->file('avatar');
            $extension = $file->getClientOriginalExtension();
            $filename = date('d_m_y_h_i_s_a') . time() . '.' . $extension;
            try {
                $filepath = Storage::disk('alumni')->putFileAs('avatar', $req->file('avatar'), $filename);

            }catch (\Throwable $th) {
                info($th);
                return response([
                    "status" => "error",
                    "message" => $th->getMessage(),
                    "status_code" => 500,
                ], 500);
            }
            $this->avatar = env('APP_URL') .'/images/alumni/'. $filepath;;
        }
        if ($req->file('short_interview_video')) {
            $file = $req->file('short_interview_video');
            $extension = $file->getClientOriginalExtension();
            $filename = date('d_m_y_h_i_s_a') . time() . '.' . $extension;
            $filepath = Storage::disk('alumni')->putFileAs('short_interview_video', $req->file('short_interview_video'), $filename);
            $this->short_interview_video = env('APP_URL') .'/images/alumni/'. $filepath;
        }
    }
}
