<?php

namespace App\Http\Controllers\DIUTCRC;

use App\Http\Resources\Tcrc\PhotoResource;
use App\Http\Resources\Tcrc\TeamResource;
use App\Http\Resources\Tcrc\VideoResource;
use App\Models\Tcrc\National;
use App\Models\Tcrc\Photo;
use App\Models\Tcrc\Team;
use App\Models\Tcrc\Video;
use App\Models\Tcrc\Slider;
use Illuminate\Http\Request;
use App\Models\Tcrc\Partner;
use App\Models\Tcrc\Setting;
use App\Models\Tcrc\NewsActivities;
use App\Http\Controllers\Controller;
use App\Models\Tcrc\ResearchAndPublications;
use App\Http\Resources\Tcrc\NewsActivitiesResource;

class DiuTcrcController extends Controller
{
    public function slider()
    {
        return Slider::all(['title', 'short_description', 'image_path']);
    }

    public function newsActivities($type)
    {
        $newsActivities = NewsActivities::with('user')
            ->orderBy('id', 'DESC')
            ->whereType($type)
            ->paginate(20);
        $newsActivitiesResource = NewsActivitiesResource::collection($newsActivities);
        return $newsActivities ?? abort(404);
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
