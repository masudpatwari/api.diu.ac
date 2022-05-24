<?php

namespace App\Http\Controllers\Admission;

use App\Traits\RmsApiTraits;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentSessionController extends Controller
{
    use RmsApiTraits;

    public function index()
    {
        $studentSession = $this->fetchStudentSession();

        if (!$studentSession) {
            return response()->json(['error' => 'data not found'], 406);
        }

        return $studentSession;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:15',
        ]);

        $data = $request->all();
        unset($data['token']);

        $studentSession = $this->storeStudentSession($data);

        if (!$studentSession) {
            return response()->json(['error' => 'data not found'], 406);
        }

        return response()->json(['message' => 'Session created successfully.'], 201);

    }

    public function edit($id)
    {
        return $this->editStudentSession($id);
    }

    public function update(Request $request, $id)
    {

        $data = $request->all();
        $data['id'] = $id;
        unset($data['token']);

        $studentSession = $this->updateStudentSession($data);

        if (!$studentSession) {
            return response()->json(['error' => 'Session updated fail'], 406);
        }

        return response()->json(['message' => 'Session updated successfully.'], 201);

    }

}
