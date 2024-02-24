<?php

namespace App\Http\Controllers\masud;

use App\Http\Controllers\Controller;
use App\Models\Exam\Questions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Exam\Settings;
use App\Models\Students\Student;
use App\Traits\RmsApiTraits;


class SpecialController extends Controller
{
    use RmsApiTraits;

    public function local(Request $request)
    {
        $start = $request->input('start_date');
        $end = $request->input('end_date') ?? Carbon::now();

        $start_date = $this->dateFormat($start);
        $end_date = $this->dateFormat($end);


        $phone_nos = DB::connection('intl')
            ->table('local_students')
            ->where('is_admitted', 'false')
            ->when($start_date, function ($query) use($start_date){
                return $query->whereDate('created_at', '>=', $start_date);
            })
            ->when($end_date, function ($query) use($end_date){
                return $query->whereDate('created_at', '<=', $end_date);
            })
            ->pluck('mobile_no');

        return response()->json($phone_nos, 200);
    }
    public function foreign(Request $request)
    {
       
        $start = $request->input('start_date');
        $end = $request->input('end_date') ?? Carbon::now();

        $start_date = $this->dateFormat($start);
        $end_date = $this->dateFormat($end);

        return $this->traits_get_foreign_students($start_date, $end_date);
      
    }

    private function dateFormat($date)
    {
        return Carbon::parse($date)->format('Y-m-d');
    }

    public function examSettings()
    {
        $data['settings'] = Settings::first()->per_ques_time ?? 10;
        $data['questions'] = Questions::get();
        return $data;
    }

    public function questionUpdate(Request $request)
    {
        \Validator::make($request->input('questions'),
        [
            '*.id'      => 'required|number',
            '*.question'   => 'nullable|string',
            '*.title'   => 'nullable|string',
            '*.sub_title'   => 'nullable|string',
        ]);

        $infos = $request->input('questions');
        $time = $request->input('time');

        try {
            foreach ($infos as $info)
            {
                Questions::find($info['id'])->update($info);
            }

            $settings = Settings::first();

            if($time) {
                $settings->update([
                    'per_ques_time' => $time
                ]);
            }

            return response('Questions updated successfully', 200);

        }catch (\Exception $exception){
            return response($exception->getMessage(), 400);
        }
    }
    public function impotNumberUploadCSVFile(Request $request)
    {

        // return Student::take(1)->get();

        $this->validate($request,
            [
                'actual_file' => 'required|mimes:csv,txt'
            ]
        );

        $file = $request->file('actual_file');

        try {
            $file = $request->file('actual_file');
            $fileName = time();

            $destinationFile = storage_path('/import_number/');


            $file->move($destinationFile, $fileName . '_' . $file->getClientOriginalName());


            if (!is_readable($destinationFile . '/' . $fileName . '_' . $file->getClientOriginalName())) {
                throw new \Exception("File is not readable", 1);
            }

            $filename = $destinationFile . '/' . $fileName . '_' . $file->getClientOriginalName();
            $data = array();
            $delimiter = ',';
            $filecontent = file_get_contents($filename);
            $lines = explode("\n", $filecontent);

            $phoneCall = [];

            $i = 0;

            foreach ($lines as $line) {
                if ($i == 0) {
                    $i++;
                    continue;
                }
                /*
                0   "Serial No."
                1   "mobile_number"
                */

                $fields = explode(",", $line);

                if (!isset($fields[1])) {
                    continue;
                }

                if (strpos(trim($fields[1]), "88") == 0 && strlen(trim($fields[1])) == 13 && is_int( (int) trim($fields[1])) ){

                    $lastInsertedId = Student::latest('id')->first()->id;
                    $phoneCall[$i]['id'] = $lastInsertedId+$fields[0];
                    $phoneCall[$i]['number'] = trim($fields[1]);
                    $phoneCall[$i]['status'] = 'NEW';

                }else{
//                    return response()->json(['error' =>'Invalid Mobile number'], 400);
                    return response()->json(['error' =>'Invalid Mobile number ' .$fields[1] . 'Row Number is ' .$i], 400);
                }

                $i++;
            }


            Student::insert($phoneCall);



            return response()->json(['message' => "Import Successfully completed!"], 200);

        } catch (\Exception $ex) {
            \Log::emergency("File:" . $ex->getFile() . "Line:" . $ex->getLine() . "Message:" . $ex->getMessage());
            return response()->json(['error' => $ex->getMessage()], 400);
        } finally {
            if (file_exists($destinationFile . '/' . $fileName . '_' . $file->getClientOriginalName())) {
                unlink($destinationFile . '/' . $fileName . '_' . $file->getClientOriginalName());
                //throw new \Exception('File Already Exists!');
            }
        }
    }
}
