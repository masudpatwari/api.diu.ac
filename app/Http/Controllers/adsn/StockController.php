<?php

namespace App\Http\Controllers\adsn;

use App\Models\adsn\EnglishBookFormDetails;
use App\Models\adsn\EStock;
use App\Models\adsn\FormDetails;
use App\Models\adsn\Stock;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\STD\Student;
use App\Models\HMS\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


class StockController extends Controller
{
    public function index(Request $request)
    {
        $stocks = Stock::get();


        return response($stocks);


    }

    public function english_book(Request $request)
    {
        $stocks = EStock::get();


        return response($stocks);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'start' => ['required','numeric'],
            'end' => ['required','numeric'],
            'count' => ['required','numeric'],
        ]
    );

        try {

            DB::transaction(function () use($request){
                Stock::create([
                    'from' => $request->start,
                    'to' => $request->end,
                    'count' => $request->count,
                    'ip' => $request->ip(),
                    'employee_id' => $request->auth->id ?? 222,
                    'time' => Carbon::now()->format('Y-m-d H:i:s')
                ]);



                $form_details = [];

                $start = $request->start;



                for($i=0; $i<$request->count; $i++)
                {

                    $form_details[$i]['form_number'] = $start;
                    $start++;

                }


                try {
                    FormDetails::insert($form_details);
                    return response()->json(['message' => "Form Import Successfully"]);

                }catch (\Exception $exception)
                {
                    return response(['error' => $exception->getMessage()],400);
                }

            });


        }catch (\Exception $exception)
        {
            return response(['error' => $exception->getMessage()], 406);
        }

        // return response('ok');

    }

    public function english_book_create(Request $request)
    {
        $this->validate($request, [
            'start' => ['required','numeric'],
            'end' => ['required','numeric'],
            'count' => ['required','numeric'],
        ]
    );

        try {

            $api_user = ApiKey::where('apiKey', $request->token)->first();

            dd($request->auth);

            DB::transaction(function () use($request){
                EStock::create([
                    'from' => $request->start,
                    'to' => $request->end,
                    'count' => $request->count,
                    'ip' => $request->ip(),
                    'employee_id' => $request->auth->id ?? $api_user->employee_id,
                    'time' => Carbon::now()->format('Y-m-d H:i:s')
                ]);



                $form_details = [];

                $start = $request->start;



                for($i=0; $i<$request->count; $i++)
                {

                    $form_details[$i]['form_number'] = $start;
                    $start++;

                }


                try {
                    EnglishBookFormDetails::insert($form_details);

                }catch (\Exception $exception)
                {
                    return response(['error' => $exception->getMessage()],400);
                }

            });


        }catch (\Exception $exception)
        {
            return response(['error' => $exception->getMessage()], 406);
        }

        // return response('ok');

    }
    

}
