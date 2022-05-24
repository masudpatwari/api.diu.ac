<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Holiday;
use App\Http\Resources\HolidayResource;
use App\Http\Resources\HolidayDetailsResource;

class HolidayController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        $holiday = Holiday::orderBy('id', 'desc')->get();
        if (!empty($holiday))
        {
            return HolidayResource::collection($holiday);
        }
        return response()->json(NULL, 404);
    }

    public function store(Request $request)
    {
        $this->validate($request, 
            [
                'holiday_name' => 'required|max:100',
                'str_date' => 'required|date_format:Y-m-d',
                'end_date' => 'required|date_format:Y-m-d',
                'no_of_days' => 'required|numeric|min:1',
                'description' => 'max:100',
            ],
            [
                'holiday_name.required' => 'Holiday is required.',
                'holiday_name.max' => 'There is a limit of 100 characters.',
                'str_date.required' => 'Starting date is required.',
                'str_date.date_format' => 'Starting date invalid. ( YY-MM-DD ).',
                'end_date.required' => 'Ending date is required.',
                'end_date.date_format' => 'Ending date invalid. ( YY-MM-DD )',
                'no_of_days.required' => 'No of days is required.',
                'no_of_days.numeric' => 'Only number are allow.',
                'no_of_days.min' => 'At least 1 day is necessary.',
                'description.max' => 'There is a limit of 100 characters.',
            ]
        );

        $holiday_array = [
            'name' => $request->input('holiday_name'),
            'start_date' => date_to_datestamp($request->input('str_date')),
            'end_date' => date_to_datestamp($request->input('end_date')),
            'number_of_days' => $request->input('no_of_days'),
            'cause' => $request->input('description'),
            'created_by' => $request->auth->id
        ];

        $holiday = Holiday::create($holiday_array);

        if (!empty($holiday->id)) {
            return response()->json($holiday, 201);
        }
        return response()->json(['error' => 'Insert Failed.'], 400);
    }

    public function update(Request $request, $id)
    {
        $holiday = Holiday::find($id);
        if (date_to_datestamp(date('Y-m-d')) <= $holiday->end_date) {
            $this->validate($request, 
                [
                    'holiday_name' => 'required|max:100',
                    'str_date' => 'required|date_format:Y-m-d',
                    'end_date' => 'required|date_format:Y-m-d',
                    'no_of_days' => 'required|numeric|min:1',
                    'description' => 'max:100',
                ],
                [
                    'holiday_name.required' => 'Holiday is required.',
                    'holiday_name.max' => 'There is a limit of 100 characters.',
                    'str_date.required' => 'Starting date is required.',
                    'str_date.date_format' => 'Starting date invalid. ( YY-MM-DD ).',
                    'end_date.required' => 'Ending date is required.',
                    'end_date.date_format' => 'Ending date invalid. ( YY-MM-DD )',
                    'no_of_days.required' => 'No of days is required.',
                    'no_of_days.numeric' => 'Only number are allow.',
                    'no_of_days.min' => 'At least 1 day is necessary.',
                    'description.max' => 'There is a limit of 100 characters.',
                ]
            );

            $holiday_array = [
                'name' => $request->input('holiday_name'),
                'start_date' => date_to_datestamp($request->input('str_date')),
                'end_date' => date_to_datestamp($request->input('end_date')),
                'number_of_days' => $request->input('no_of_days'),
                'cause' => $request->input('description'),
                'created_by' => $request->auth->id
            ];
            
            $holiday = Holiday::where('id', $id)->update($holiday_array);

            if (!empty($holiday)) {
                $holiday = Holiday::find($id);
                return response()->json($holiday, 200);
            }
            return response()->json(['error' => 'Update Failed.'], 400);
        }
        return response()->json(['error' => 'Update date exprie.'], 400);
    }

    public function show($id)
    {
        $holiday = Holiday::find($id);
        if (!empty($holiday))
        {
            return new HolidayDetailsResource($holiday);
        }
        return response()->json(NULL, 404);
    }

    public function delete($id)
    {
        $holiday = Holiday::find($id);
        if (!empty($holiday)) {
            if (date_to_datestamp(date('Y-m-d')) <= $holiday->end_date) {
                if ($holiday->delete()) {
                    return response()->json(NULL, 204);
                }
                return response()->json(['error' => 'Delete Failed.'], 400);
            }
            return response()->json(['error' => 'Delete date exprie!'], 400);
        }
        return response()->json(NULL, 404);
    }

    public function trashed()
    {
        $holiday = Holiday::orderBy('deleted_at', 'asc')->onlyTrashed()->get();
        if (!empty($holiday)) {
            return HolidayResource::collection($holiday);
        }
        return response()->json(NULL, 404);
    }

    public function restore($id)
    {
        $holiday = Holiday::withTrashed()->find($id);
        if (!empty($holiday)) {
            if ($holiday->restore()) {
                return response()->json(['success' => 'Restore successful.'], 201);
            }
            return response()->json(['error' => 'Restore Failed.'], 400);
        }
        return response()->json(NULL, 404);
    }
}
