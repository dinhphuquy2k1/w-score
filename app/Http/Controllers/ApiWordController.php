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
use PhpOffice\PhpWord\IOFactory as PHPIOFactory;
use PhpOffice\PhpWord\Shared\Converter;
use App\Enums\FileType;
use Illuminate\Http\Response;
use ZipArchive;
use App\Models\Criteria;
use App\Enums\PropertyType;
use App\Enums\PageSize;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use function Symfony\Component\String\b;

class ApiWordController extends Controller
{

    public $_PATH_EXTRACTED = 'app/extracted';

    private const START_ROW = 1;

    public function __construct()
    {
        $this->_PATH_EXTRACTED = storage_path($this->_PATH_EXTRACTED);
    }

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
                    $cacheKey = 'cache_list';
                    Cache::store('file')->put($cacheKey, $data, null);
                    return $this->sendResponseSuccess([
                        'cakeListName' => $cacheKey,
                    ]);
                } else {
                    // folder lưu file tải lên
                    $tempDir = storage_path('app/temp/');
                    //xóa các file trước đó
//                    File::deleteDirectory($tempDir);
//                    File::deleteDirectory(storage_path('app/extracted/'));
                    $listData = Cache::get('cache_N4THOc1MKQ_1711764801');
                    // Di chuyển tệp đã tải lên vào thư mục tạm
                    $filePath = $file->move($tempDir, $file->getClientOriginalName());
                    $valid_docx = array('docx');
                    $extractPath = $this->_PATH_EXTRACTED;
                    $zip = new ZipArchive;
                    $res = $zip->open($filePath);
                    if ($res === TRUE) {
                        // Extract file
                        $zip->extractTo($extractPath);
                        $zip->close();
                    } else {
                        return $this->sendResponseError(['message' => 'Lỗi giải nén']);
                    }

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
                                if (is_dir($dirChild) && $handleChild = opendir($dirChild)) {
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
                $cacheKey = 'cache_student';
                Cache::store('file')->put($cacheKey, $students, null);
                $students['files'] = [
                    'extractPath' => $extractPath,
                ];
                $students['cakeStudentName'] = $cacheKey;
                $students['cakeListName'] = $request->cakeListName;
                return $this->sendResponseSuccess($students);
            } else {
                return $this->sendResponseError(['message' => 'Đã xảy ra lỗi']);
            }
        }
    }

    public function calculate(Request $request)
    {
        $filePath = $this->_PATH_EXTRACTED;
        $list = Cache::get('cache_list') ?? [];
        $listStudent = Cache::get('cache_student') ? Cache::get('cache_student')['data'] : [];
        if (empty($list) || empty($listStudent)) {
            return $this->sendResponseError(['message' => 'Đã xảy ra lỗi']);
        }

        $criterias = Criteria::where('exam_bank_id', 1)->get();


        foreach ($listStudent as $student) {
            $phpWord = PHPIOFactory::load($student['path'] . '/' . $student['studentAssignment'][0]);
            // Lấy danh sách các sections trong tài liệu
            $point = 0;
            $sections = $phpWord->getSections();
            foreach ($criterias as $criteria) {
                switch ($criteria->property_type) {
                    case PropertyType::PAGE_SIZE:
                        $isValid = true;
                        foreach ($sections as $section) {
                            // page size trong bài thi
                            $pageSize = $section->getStyle()->getPaperSize();
                            // page size trong DB
                            $typeSize = PageSize::getKey((int)$criteria->content);
                            if ($pageSize != $typeSize){
                                $isValid = false;
                            }
                        }
                        if ($isValid) $point+=$criteria->point;
                        break;
                    default:
                        break;
                }
            }
            dd($point);

        }

    }

    /**
     * Kiểm tra khổ giấy
     * **/
    function checkPageSize($pageSize, $typeSize)
    {
        switch ($typeSize) {
            case PageSize::Letter:
                if ($pageSize === 1 || $pageSize === 2) {
                    return true;
                }
            case PageSize::Tabloid:
                if ($pageSize === 3) {
                    return true;
                }
            case PageSize::Legal:
                if ($pageSize === 5) {
                    return true;
                }
            case PageSize::Statement:
                if ($pageSize === 6) {
                    return true;
                }
            case PageSize::Executive:
                if ($pageSize === 7) {
                    return true;
                }
            case PageSize::A3:
                if ($pageSize === 8) {
                    return true;
                }
            case PageSize::A4:
                if ($pageSize === 9 || $pageSize === 10) {
                    return true;
                }
                break;
            case PageSize::B4:
                if ($pageSize === 12) {
                    return true;
                }
            case PageSize::B5:
                if ($pageSize === 13) {
                    return true;
                }
        }
    }
}
