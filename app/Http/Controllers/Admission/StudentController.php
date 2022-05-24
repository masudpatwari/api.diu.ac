<?php

namespace App\Http\Controllers\Admission;

use App\Http\Controllers\Controller;
use App\Traits\RmsApiTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    use RmsApiTraits;

    public function show($id)
    {
        $student = $this->fullInfoStudentById($id);

        if (!$student) {
            return response()->json(['error' => 'data not found'], 406);
        }

        return $student;

    }

    public function search($slug)
    {
        $student = $this->studentSearch($slug);

        if (!$student) {
            return response()->json(['error' => 'data not found'], 406);
        }

        return $student;

    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer',
            'name' => 'required|string|max:80',
            'department_id' => 'required|integer',
            'batch_id' => 'required|integer',
            'shift_id' => 'required|integer',
            'year' => 'required|integer',
            'group_id' => 'required|integer',
            'blood_group' => 'required|max:4',
            'email' => 'required|email',
            'phone_no' => 'required|max:15',
            'adm_frm_sl' => 'required|max:20',
            'religion_id' => 'required|integer',
            'gender' => 'required|max:1',
            'dob' => 'required',
            'birth_place' => 'nullable',
            'fg_monthly_income' => 'nullable|numeric',
            'parmanent_add' => 'required|string|max:200',
            'mailing_add' => 'required|string|max:100',
            'f_name' => 'required|string|max:80',
            'f_cellno' => 'required|string|max:15',
            'f_occu' => 'nullable|string|max:30',
            'father_nid_no' => 'required|max:50',
            'm_name' => 'required|string|max:80',
            'm_cellno' => 'nullable|max:15',
            'm_occu' => 'nullable|string|max:30',
            'mother_nid_no' => 'nullable|max:50',
            'g_name' => 'nullable|string|max:30',
            'g_cellno' => 'nullable|max:15',
            'g_occu' => 'nullable|string|max:30',
            'e_name' => 'required|string|max:30',
            'e_cellno' => 'required|max:15',
            'e_occu' => 'nullable|string|max:30',
            'e_relation' => 'nullable|string|max:20',
            'emp_id' => 'required|integer',
            'nationality' => 'required|max:30',
            'marital_status' => 'required|max:20',
            'std_birth_or_nid_no' => 'nullable|max:50',
            'adm_season' => 'required|integer',
            'e_exam_name1' => 'required|string|max:40',
            'e_group1' => 'required|string|max:20',
            'e_roll_no_1' => 'required|max:10',
            'e_passing_year1' => 'required|max:4',
            'e_ltr_grd_tmark1' => 'required|max:10',
            'e_div_cls_cgpa1' => 'required|max:10',
            'e_board_university1' => 'required|max:50',
            'e_exam_name2' => 'required|string|max:40',
            'e_group2' => 'required|string|max:20',
            'e_roll_no_2' => 'required|max:10',
            'e_passing_year2' => 'required|max:4',
            'e_ltr_grd_tmark2' => 'required|max:10',
            'e_div_cls_cgpa2' => 'required|max:10',
            'e_board_university2' => 'required|max:50',
            'e_exam_name3' => 'nullable|string|max:40',
            'e_group3' => 'nullable|string|max:20',
            'e_roll_no_3' => 'nullable|max:10',
            'e_passing_year3' => 'nullable|max:4',
            'e_ltr_grd_tmark3' => 'nullable|max:10',
            'e_div_cls_cgpa3' => 'nullable|max:10',
            'e_board_university3' => 'nullable|max:50',
            'e_exam_name4' => 'nullable|string|max:40',
            'e_group4' => 'nullable|string|max:20',
            'e_roll_no_4' => 'nullable|max:10',
            'e_passing_year4' => 'nullable|max:4',
            'e_ltr_grd_tmark4' => 'nullable|max:10',
            'e_div_cls_cgpa4' => 'nullable|max:10',
            'e_board_university4' => 'nullable|max:50',
            'refereed_by_parent_id' => 'nullable|integer',
            'refe_by_std_type' => 'nullable|max:50',
            'ref_val' => 'nullable|max:50',
        ]);

        $data = $request->all();
        unset($data['token']);

        $student = $this->studentInfoUpdate($data);

        if (!$student) {
            return response()->json(['error' => 'Student update fail'], 404);
        }

        return response()->json(['message' => 'Student update successfully'], 200);
    }

}

