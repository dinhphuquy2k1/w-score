<?php

namespace App\Http\Controllers;

use App\Models\ExamResult;
use App\Models\ExamResultDetail;
use Illuminate\Http\Request;

class ApiExamResultController extends Controller
{
    public function getExamResultDetail(Request $request)
    {
        $request->validate([
            'student_code' => 'required',
            'exam_shift_detail_id' => 'required|integer',
        ]);

        $ret = ExamResultDetail::where('exam_shift_detail_id', $request->exam_shift_detail_id)->where('student_code', $request->student_code)->where('has_child', false)->get()->toArray();
        return $this->sendResponseSuccess($ret);
    }
}
