<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpSpreadsheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
class ApiWordController extends Controller
{
    public function index(): array
    {
        return ['test' => 'message'];
    }

    public function uploadFile(Request $request){
        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));
        if (!$receiver->isUploaded()) {
            // file not uploaded
        }
        $fileReceived = $receiver->receive(); // receive file
        if ($fileReceived->isFinished()) { // file uploading is complete / all chunks are uploaded
            $file = $fileReceived->getFile(); // get file
            // Đọc tệp Excel
            $spreadsheet = IOFactory::load($file);
            // Lấy sheet đầu tiên
            $sheet = $spreadsheet->getActiveSheet();
            // Lấy dữ liệu từ các ô trong sheet
            $data = [];
            foreach ($sheet->getRowIterator() as $row) {
                $rowData = [];
                foreach ($row->getCellIterator() as $cell) {
                    $rowData[] = $cell->getValue();
                }
                $data[] = $rowData;
            }
            $attributes = [
                'ResourcePath' => "ExcelGrader/ExcelScore/{$request->ExamId}/{$new_name}",
            ];
            dd(3);
            $find = DB::table('examshiftdetail')->where('DepartmentId',$request->DepartmentId)->where('ExamShiftId',$request->ExamShiftId);
            if(substr($file->getClientOriginalName(),0,3) === 'DS@'){
                //nếu đã tồn tại đường dẫn thì thực hiện xóa
                File::delete(public_path($find->get()->first()->ResourcePath.'/'.$find->get()->first()->ResourcePathFileList));
                $find->get()->first()->ResourcePath = $file->getClientOriginalName();
                $attributes['ResourcePathFileList'] = $file->getClientOriginalName();
            }
            else if(substr($file->getClientOriginalName(),0,3) === 'BT@'){
                File::delete(public_path($find->get()->first()->ResourcePath.'/'.$find->get()->first()->ResourcePathFileAssignment));
                $find->get()->first()->ResourcePath = $file->getClientOriginalName();
                $attributes['ResourcePathFileAssignment'] = $file->getClientOriginalName();
            }
            try {
                DB::beginTransaction();
                $find->update($attributes);
                $file->move(public_path()."/{$attributes['ResourcePath']}",$file->getClientOriginalName());
                DB::commit();
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    }
}
