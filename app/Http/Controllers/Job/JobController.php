<?php

namespace App\Http\Controllers\Job;

use App\Models\PBX\Provider;
use Illuminate\Http\Request;
use App\Http\Resources\JobResource;
use App\Http\Resources\ProviderWiseJobResource;
use App\Http\Controllers\Controller;

class JobController extends Controller
{
    public function jobReport()
    {

        $jobs = \DB::table('jobs')
            ->select(\DB::raw('count(*) as total_row, queue'), \DB::raw('MIN(available_at) as start_at, queue'), \DB::raw('MAX(available_at) as end_at, queue'))
            ->groupBy('queue')
            ->get();

        $providers = Provider::all();

        $providerWiseQueue = [];
        foreach ($providers as $provider) {

            foreach ($jobs as $job) {
                $row = \DB::table('jobs')
                    ->selectRaw('count(*) as total_row')
                    ->selectRaw('MIN(available_at) as start_at')
                    ->selectRaw('MAX(available_at) as end_at')
                    ->where('queue', $job->queue)
                    ->where('payload', 'LIKE', '%' . $provider->name_or_number . '%')
                    ->first();

                $providerWiseQueue[] = [
                    'queue' => $job->queue,
                    'provider' => $provider->name_or_number,
                    'data_row' => [
                        'total_row' => $row->total_row,
                        'start_at' => $row->start_at ? date("Y-m-d h:i:s A", $row->start_at) : 'N/A',
                        'end_at' => $row->end_at ? date("Y-m-d h:i:s A", $row->end_at) : 'N/A',
                    ]
                ];
            }

        }

        $data = [
            'jobsCollection' => JobResource::collection($jobs),
            'providerWiseJobCollection' => $providerWiseQueue,
        ];
        return $data;
    }
}
