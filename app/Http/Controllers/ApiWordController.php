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
use App\Enums\FileType;
use Illuminate\Http\Response;
use ZipArchive;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ApiWordController extends Controller
{

    private const START_ROW = 1;

    public function index(): array
    {
        return ['test' => 'message'];
    }

    public function uploadFile(Request $request)
    {
        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));
        if (!$receiver->isUploaded()) {
            // file not uploaded
        }
        $fileReceived = $receiver->receive(); // receive file
        if ($fileReceived->isFinished()) { // file uploading is complete / all chunks are uploaded
            $fileType = $request->fileType;
            if ($fileType == FileType::EXAM || $fileType == FileType::LIST) {
                $file = $fileReceived->getFile(); // get file
                // file danh sách
                if ($fileType == FileType::LIST) {
                    $spreadsheet = IOFactory::load($file);
                    $sheet = $spreadsheet->getActiveSheet();
                    // Lấy dữ liệu từ các ô trong sheet
                    $data = [];
                    foreach ($sheet->getRowIterator() as $index => $row) {
                        $rowData = [];
                        if ($index != self::START_ROW) {
                            $studentCode = $sheet->getCell("B{$index}")->getValue();
                            $studentName = $sheet->getCell("C{$index}")->getValue();
                            $department = $sheet->getCell("D{$index}")->getValue();
                            if ($studentCode && $studentName && $department) {
                                $data[$studentCode] = [
                                    'studentCode' => $studentCode,
                                    'studentName' => $studentName,
                                    'department' => $department,
                                ];
                            }
                        }
                    }
                    if (empty($data)) {
                        return $this->sendResponseError(['message' => 'Không có dữ liệu']);
                    }
                    // lưu data vào cache
                    $cacheKey = 'cache_' . Str::random(10) . '_' . time();
                    Cache::put($cacheKey, $data, null);
                    return $this->sendResponseSuccess([
                        'data' => '2f058da8e78e44bc6776dc6ed896bcbe5681c216',
                    ]);
                } else {
                    $listData = Cache::get('cache_LzRFQMxpTE_1711706123');
                    // folder lưu file tải lên
                    $tempDir = storage_path('app/temp');
                    // Di chuyển tệp đã tải lên vào thư mục tạm
                    $filePath = $file->move($tempDir, $file->getClientOriginalName());
                    $valid_docx = array('docx');
                    $extractPath = storage_path('app/extracted/K0F5Y4fMNV_1711707823');
//                    $extractPath = storage_path('app/extracted/' . Str::random(10) . '_' . time());
//                    $zip = new ZipArchive;
//                    $res = $zip->open($filePath);
//                    if ($res === TRUE) {
//                        // Extract file
//                        $zip->extractTo($extractPath);
//                        $zip->close();
//                    } else {
//                        echo '<br><font color=red><b>failed!</b></font>';
//                    }

                    $handleParent = opendir($extractPath);
                    $pathTo = "P";
                    if ($handleParent) {
                        //đọc folder bài tải lên
                        while (($fileParent = readdir($handleParent)) !== FALSE) {
                            if (!in_array($fileParent, array('.', '..')) && !is_dir($extractPath . $fileParent)) {
                                //đọc từng folder con để lấy ra bài word | excel | pp tương ứng
                                $dirChild = $extractPath . '/' . $fileParent;
                                $parts = explode('_', $fileParent);
                                $studentID = $parts[0];                                       //mã sinh viên
                                // $infos = explode(' ',explode('-',$parts[1])[1]);
                                // $key_student =  $infos[0];                                          //Khóa
                                // $studentDepartment = $infos[1];                                     //Khoa
                                if ($handleChild = opendir($dirChild)) {
                                    while (($fileChild = readdir($handleChild)) !== FALSE) {
                                        if (!in_array($fileChild, array('.', '..')) && !is_dir($dirChild . $fileChild)) {
                                            $ext = strtolower(pathinfo($fileChild, PATHINFO_EXTENSION));
                                            if ($pathTo === "P") {
                                                if (in_array(strtolower($ext), $valid_docx)) {
                                                    //thông tin sinh viên
                                                    $students['data'][$studentID] = ['studentID' => $studentID];
                                                    $students['data'][$studentID]['studentAssignment'][] = $fileChild;  //tên file
                                                    $students['data'][$studentID]['path'] = $extractPath . '/' . $fileParent;  //đường dẫn đến bài
                                                }
                                            }
                                        }
                                    }
                                    closedir($handleChild);
                                }
                            }
                        }
                        closedir($handleParent);
                    }
                }

                if (empty($students)) {
                    return $this->sendResponseError(['message' => 'Dữ liệu trống']);
                }
                $students['files'] = [
                    'extractPath' => $extractPath,
                ];
                dd($students);
            }
        }
    }
}
