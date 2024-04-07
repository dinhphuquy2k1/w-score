<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExamBank;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
class ApiExamBankController extends Controller
{
    public function get()
    {
        return $this->sendResponseSuccess(ExamBank::all()->toArray());
    }

    /**
     * @param Request $request
     */
    public function save(Request $request)
    {
        try {
            $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));
            if (!$receiver->isUploaded()) {
                // file not uploaded
//                return $this->sendResponseError();
            }
            dd(3);
            $fileReceived = $receiver->receive(); // receive file
            if ($fileReceived->isFinished()) { // file uploading is complete / all chunks are uploaded
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
                return $this->sendResponseSuccess();
            }
            else return $this->sendResponseError();
        } catch (\Throwable $th) {
            dd($th);
        }

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

    /**
     * Lấy danh sách đề thi đã setting
     */
    public function getSettings()
    {
        return $this->sendResponseSuccess(ExamBank::all()->toArray());
    }

    public function delete($id)
    {
        ExamBank::where('id', $id)->delete();
    }
}
