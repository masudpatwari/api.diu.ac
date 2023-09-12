<?php

namespace App\Http\Controllers\CMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\INTL\PotentialStudent;
use Illuminate\Support\Facades\Log;


class PotentialStudentController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request,
            [
                'actual_file' => 'required|mimes:csv,txt'
            ]
        );

        $file = $request->file('actual_file');

        try {
            $file = $request->file('actual_file');
            $fileName = time();

            $destinationFile = storage_path('/potential_students/');


            $file->move($destinationFile, $fileName . '_' . $file->getClientOriginalName());


            if (!is_readable($destinationFile . '/' . $fileName . '_' . $file->getClientOriginalName())) {
                throw new \Exception("File is not readable", 1);
            }

            $filename = $destinationFile . '/' . $fileName . '_' . $file->getClientOriginalName();
            $data = array();
            $delimiter = ',';
            $filecontent = file_get_contents($filename);
            $lines = explode("\n", $filecontent);

            $potentialStudents = [];

            $i = 0;

            foreach ($lines as $line) {
                if ($i == 0) {
                    $i++;
                    continue;
                }
                /*
                0   "name."
                1   "mobile"
                2   "technology"
                3   "assign_to"
                */
                $line = str_replace('"',"", $line);

                $fields = explode(",", $line);

                if (!isset($fields[1])) {
                    continue;
                }

                $potentialStudents[$i]['name'] = trim($fields[0]);
                $potentialStudents[$i]['mobile'] = trim($fields[1]);
                $potentialStudents[$i]['technology'] = trim($fields[2]);
                $potentialStudents[$i]['status'] = 0;
                $potentialStudents[$i]['assign_to'] = trim($fields[3]);
                $potentialStudents[$i]['updated_at'] = \Carbon\Carbon::now()->format('Y-m-d h:i:s');

                $i++;
            }

            \DB::beginTransaction();

//            dump(\Log::info(print_r($potentialStudents,true)));

            PotentialStudent::insert($potentialStudents);

            \DB::commit();


            return response()->json(['message' => "Import Successfully completed!"], 200);

        } catch (\Exception $ex) {
            \DB::rollBack();
            \Log::emergency("File:" . $ex->getFile() . "Line:" . $ex->getLine() . "Message:" . $ex->getMessage());
            return response()->json(['error' => $ex->getMessage()], 400);
        } finally {
            if (file_exists($destinationFile . '/' . $fileName . '_' . $file->getClientOriginalName())) {
                unlink($destinationFile . '/' . $fileName . '_' . $file->getClientOriginalName());
            }
        }
    }

}
