<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExamBank;

class ApiExamBankController extends Controller
{
    public function get()
    {
        return $this->sendResponseSuccess(ExamBank::all()->toArray());
    }

    /**
     * @param Request $request
     * @return void
     */
    public function save(Request $request)
    {
        $attribute = $request->validate([
            'exam_bank_name' => 'required',
            'exam_bank_code' => 'required|unique:exam_banks,exam_bank_code'
        ],
            [
                'exam_bank_name.required' => 'Tên đề thi không được để trống',
                'exam_bank_code.required' => 'Mã đề thi không được để trống',
                'exam_bank_code.unique' => 'Mã đề thi đã tồn tại',
            ]);
        ExamBank::insert($attribute);
    }

    /**
     * @param Request $request
     * @param $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        $attribute = $request->validate([
            'exam_bank_name' => 'required',
            'exam_bank_code' => "required|unique:exam_banks,exam_bank_code,{$request->exam_bank_code},exam_bank_code",
        ],
            [
                'exam_bank_name.required' => 'Tên đề thi không được để trống',
                'exam_bank_code.required' => 'Mã đề thi không được để trống',
                'exam_bank_code.unique' => 'Mã đề thi đã tồn tại',
            ]);
        ExamBank::find($request->id)->update($attribute);
    }
}
