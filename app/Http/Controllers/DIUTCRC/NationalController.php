<?php

namespace App\Http\Controllers\DIUTCRC;

use App\Libraries\Slug;
use App\Models\Tcrc\National;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tcrc\NewsActivities;
use App\Models\Tcrc\ResearchAndPublications;


class NationalController extends Controller
{

    public function index()
    {
        return National::with('user:id,name')->get();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'type' => 'required|in:government,non-government',
            'title' => 'required|string|max:500',
            'url' => 'required|string',
        ]);


        National::create([
            'type' => $request->type,
            'title' => $request->title,
            'url' => $request->url,
            'created_by' => $request->auth->id,
        ]);


        $message = "{$request->type} national created successfully";
        return response()->json(['message' => $message], 200);
    }

    public function edit($id)
    {
        $national = National::find($id);

        return $national ?? abort(404);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'type' => 'required|in:government,non-government',
            'title' => 'required|string|max:500',
            'url' => 'required|string',
        ]);

        National::find($id)->update([
            'type' => $request->type,
            'title' => $request->title,
            'url' => $request->url,
        ]);

        $message = "{$request->type} national created successfully";
        return response()->json(['message' => $message], 200);

    }

    public function destroy($id)
    {
        $national = National::destroy($id);
        if (!$national) {
            return response()->json(['message' => 'National data not found'], 404);
        }
        return response()->json(['message' => 'Delete successfully'], 200);
    }

}
