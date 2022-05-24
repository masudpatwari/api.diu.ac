<?php

namespace App\Http\Controllers\DIUIQAC;

use App\Models\Iqac\Setting;
use App\Models\Iqac\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class SettingController extends Controller
{

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'about_diu' => 'required|string',
            'about_tcrc' => 'required|string',
            'mission_vision' => 'required|string',
            'video_id' => 'required|integer',
        ]);

        $form = $request->all();
        unset($form['token']);
        Setting::find($id)->update($form);

        return response()->json(['message' => 'Setting Updated Successfully'], 200);
    }

    public function teamStore(Request $request)
    {
        $this->validate($request, [
            'type' => 'required|in:iqac,sac,qac',
            'employee_id' => 'required|integer',
        ]);

        $form = $request->all();
        $form['created_by'] = $request->auth->id;
        unset($form['token']);
        Team::create($form);

        return response()->json(['message' => 'Team Created Successfully'], 200);
    }

    public function teamIndex()
    {
        return Team::with('employee:id,name,designation_id', 'employee.relDesignation')->get();
    }

    public function teamDestroy($id)
    {
        $team = Team::destroy($id);
        if (!$team) {
            return response()->json(['message' => 'Team data not found'], 404);
        }
        return response()->json(['message' => 'Delete successfully'], 200);
    }


}
