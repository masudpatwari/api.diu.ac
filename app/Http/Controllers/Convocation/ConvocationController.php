<?php

namespace App\Http\Controllers\Convocation;


use App\Http\Resources\StudentConvocationResource;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\RmsApiTraits;
use App\Http\Controllers\Controller;
use App\Models\Convocation\StudentConvocation;

class ConvocationController extends Controller
{

    use RmsApiTraits;

    public function index(Request $request)
    {
//        if ($request->ip() == '172.16.7.3') {

            $query = StudentConvocation::query();

            if ($request->has('key')) {
                $query = $query->where('student_name', 'like', '%' . $request->get('key') . '%')
                    ->orWhere('form_number', $request->get('key'))
                    ->orWhere('reg_code_one', 'like', '%' . $request->get('key') . '%');
            }

            $studentConvocation = $query->order()->paginate(1000);

            return StudentConvocationResource::collection($studentConvocation);

//        }

//        return StudentConvocationResource::collection(StudentConvocation::order()->paginate(500));
    }

    public function studentInfos($student_id)
    {
        $student = $this->student_infos($student_id);
        $student_transcript = $this->student_provisional_transcript_marksheet_info_by_student_id($student_id);

        /*if ($student_transcript == false) {
            return response()->json(['message' => 'ERP data error'], 400);
        }*/


        $data_student_transcript = [];

        $data_student_transcript['batch_name_as_major'] = $student_transcript['batch_name_as_major'] ?? 'N/A';
        $data_student_transcript['passing_year'] = \Carbon\Carbon::parse(str_replace('/', '-', $student_transcript['result_publish_date_of_last_semester']))->format('Y') ?? 'N/A';
        $data_student_transcript['result_publish_date_of_last_semester'] = \Carbon\Carbon::parse(str_replace('/', '-', $student_transcript['result_publish_date_of_last_semester']))->format('Y-m-d') ?? 'N/A';
        $data_student_transcript['cgpa'] = $student_transcript['cgpa'] ?? '0.00';
        $data_student_transcript['duration_in_month'] = $student_transcript['duration_in_month'] ?? 'N/A';


        $data = [
            'student' => $student,
            'student_transcript' => $data_student_transcript,
        ];

        return $data;
    }

    public function studentDataStore(Request $request)
    {
        $this->validate($request, [
            'number_of_convocation' => 'required|integer',
            'form_number' => 'required|unique:student_convocations',
            'student_name' => 'required|string',
            'father_name' => 'required|string',
            'mother_name' => 'required|string',
            'present_address' => 'nullable|string',
            'permanent_address' => 'nullable|string',
            'nationality' => 'required|string|max:20',
            'contact_no' => 'required|min:11',
            'email_address' => 'nullable',

            'second_degree' => 'nullable',

            'name_of_program_one' => 'required|string',
            'major_in_one' => 'required',
            'roll_no_one' => 'required|integer',
            'reg_code_one' => 'required',
            'batch_one' => 'required',
            'session_one' => 'required',
            'group_one' => 'required',
            'duration_of_the_courses_one' => 'required',
            'shift_one' => 'required',
            'passing_year_one' => 'required',
            'result_one' => 'required',
            'result_published_date_one' => 'required',

            'name_of_program_two' => 'required_if:second_degree,true|string',
            'major_in_two' => 'required_if:second_degree,true',
            'roll_no_two' => 'required_if:second_degree,true|integer',
            'reg_code_two' => 'required_if:second_degree,true',
            'batch_two' => 'required_if:second_degree,true',
            'session_two' => 'required_if:second_degree,true',
            'group_two' => 'required_if:second_degree,true',
            'duration_of_the_courses_two' => 'required_if:second_degree,true',
            'shift_two' => 'required_if:second_degree,true',
            'passing_year_two' => 'required_if:second_degree,true',
            'result_two' => 'required_if:second_degree,true',
            'result_published_date_two' => 'required_if:second_degree,true',
        ]);

        \DB::transaction(function () use ($request) {
            $studentConvocation = new StudentConvocation();

            $studentConvocation->fill($request->except('contact_no', 'created_by', 'image_url', 'result_published_date_one', 'result_published_date_two'));

            $files = $request->file('file');

            if ($files) {
                $extension = $files->getClientOriginalExtension();
                $file_name = time() . '_' . Str::random(10) . '.' . $extension;
                $files->move(storage_path('images/convocation'), $file_name);

                $studentConvocation->image_url = env('APP_URL') . "/images/convocation/{$file_name}";
            }

            $studentConvocation->contact_no = '+88' . substr(trim($request->contact_no), -11);

            $studentConvocation->created_by = $request->auth->id;
            $studentConvocation->result_published_date_one = Carbon::parse($request->result_published_date_one)->format('Y-m-d');
            $studentConvocation->result_published_date_two = Carbon::parse($request->result_published_date_two)->format('Y-m-d');
            $studentConvocation->save();
        });

        return response()->json(['message' => 'Convocation form create Successfully'], 200);

    }

}
