<?php

namespace App\Http\Controllers\PhoneCall;

use App\Models\PhoneCall\PhoneCall;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VoiceBlastController extends Controller
{
    public function voiceBlastUploadCSVFile(Request $request)
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

            $destinationFile = storage_path('/voice_blast/');


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

                    $phoneCall[$i]['mobile_number'] = trim($fields[1]);
                    $phoneCall[$i]['response'] = 'NEW';

                }else{
//                    return response()->json(['error' =>'Invalid Mobile number'], 400);
                    return response()->json(['error' =>'Invalid Mobile number ' .$fields[1] . 'Row Number is ' .$i], 400);
                }

                $i++;
            }

            \DB::beginTransaction();

            PhoneCall::insert($phoneCall);

            \DB::commit();


            return response()->json(['message' => "Import Successfully completed!"], 200);

        } catch (\Exception $ex) {
            \DB::rollBack();
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
