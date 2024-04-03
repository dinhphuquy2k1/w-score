<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class ApiExamShiftController extends Controller
{
    public function getWithDepartment()
    {

    }

    public function checkExamShiftCodeExits(Request $request)
    {
        //insert
        if ($request->mode == 1) {
            // validate incoming request
            $validator = Validator::make($request->data, [
                'exam_shift_code' => 'unique:exam_shifts,exam_shift_code',
            ]);
        } //update
        else if ($request->mode == 2) {
            $validator = Validator::make($request->data, [
                'exam_shift_code' => "required|unique:exam_shifts,exam_shift_code,{$request->data['exam_shift_id']},id",
            ]);
        }

        if ($validator->fails()) {
            $this->sendResponseSuccess(['result' => true]);
        }
        return $this->sendResponseSuccess(['result' => false]);
    }
}
