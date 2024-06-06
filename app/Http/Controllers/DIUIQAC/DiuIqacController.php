<?php

namespace App\Http\Controllers\DIUIQAC;

use App\Models\Iqac\Team;
use App\Models\Iqac\Photo;
use App\Models\Iqac\Video;
use App\Models\Iqac\Slider;
use Illuminate\Http\Request;
use App\Models\Iqac\Partner;
use App\Models\Iqac\Setting;
use App\Models\Iqac\National;
use App\Models\Iqac\NewsActivities;
use App\Http\Controllers\Controller;
use App\Http\Resources\Iqac\TeamResource;
use App\Http\Resources\Iqac\VideoResource;
use App\Http\Resources\Iqac\PhotoResource;
use App\Models\Iqac\ResearchAndPublications;
use App\Http\Resources\Iqac\NewsActivitiesResource;

class DiuIqacController extends Controller
{
    public function slider()
    {
//        dd('w');
        return Slider::all(['title', 'short_description', 'image_path']);
    }

    public function newsActivities($type)
    {
        $newsActivities = NewsActivities::with('user')
            ->orderBy('id', 'DESC')
            ->whereType($type)
            ->get();
        $newsActivitiesResource = NewsActivitiesResource::collection($newsActivities);
        return $newsActivitiesResource?? abort(404);
    }

    public function newsActivity($id)
    {
        $newsActivities = NewsActivities::with('user')->find($id);

        $newsActivitiesResource = new NewsActivitiesResource($newsActivities);
        return $newsActivitiesResource ?? abort(404);
    }

    public function researchPublication($type)
    {
        return ResearchAndPublications::orderBy('id', 'DESC')->whereType($type)->get();
    }

    public function teams($type)
    {
        $team = Team::with('employee', 'employee.relDesignation')
            ->whereType($type)
            ->get();


        $teamResource = TeamResource::collection($team);
        return $teamResource ?? abort(404);
    }

    public function setting()
    {
        return Setting::with('video')->first();
    }

    public function video()
    {
        $video = Video::orderBy('id', 'DESC')->paginate(300);
        return VideoResource::collection($video);
    }

    public function photos()
    {
        $photos = Photo::orderBy('id', 'DESC')->paginate(300);

        return PhotoResource::collection($photos);
    }

    public function partner()
    {
        return Partner::all();
    }

    public function national($type)
    {
        return National::whereType($type)->get();
    }
}
