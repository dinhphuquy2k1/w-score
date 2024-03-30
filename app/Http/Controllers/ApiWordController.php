<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
use App\Enums\InfoType;
use App\Enums\PageSize;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use function Symfony\Component\String\b;

class ApiWordController extends Controller
{

    public $_PATH_EXTRACTED = 'app/extracted';
    public $_PATH_ZIP = 'app/temp';
    private const CAKE_LIST_NAME = 'cache_list';
    private const CAKE_STUDENT_NAME = 'cache_student';

    private const START_ROW = 1;

    public function __construct()
    {
        $this->_PATH_EXTRACTED = storage_path($this->_PATH_EXTRACTED);
        $this->_PATH_ZIP = storage_path($this->_PATH_ZIP);
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
                    Cache::store('file')->put(self::CAKE_LIST_NAME, $data, null);
                    return $this->sendResponseSuccess([
                        'cakeListName' => self::CAKE_LIST_NAME,
                    ]);
                } else {
                    // folder lưu file tải lên
                    //xóa các file trước đó
                    File::deleteDirectory($this->_PATH_ZIP);
                    File::deleteDirectory($this->_PATH_EXTRACTED);
                    $listData = Cache::get(self::CAKE_LIST_NAME);
                    // Di chuyển tệp đã tải lên vào thư mục tạm
                    $filePath = $file->move($this->_PATH_ZIP, $file->getClientOriginalName());
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
                    $students = [];
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
                                                if (in_array(strtolower($ext), $valid_docx) && array_key_exists($studentID, $listData)) {
                                                    //thông tin sinh viên
                                                    $students['data'][$studentID] = [
                                                        'studentName' => $listData[$studentID]['studentName'],
                                                        'studentID' => $studentID,
                                                        'studentAssignment' => [$fileChild],
                                                        'path' => $extractPath . '/' . $fileParent,
                                                    ];
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
                Cache::store('file')->put(self::CAKE_STUDENT_NAME, $students, null);
                $students['files'] = [
                    'extractPath' => $extractPath,
                ];
                $students['cakeStudentName'] = self::CAKE_STUDENT_NAME;
                $students['cakeListName'] = self::CAKE_LIST_NAME;
                return $this->sendResponseSuccess($students);
            } else {
                return $this->sendResponseError(['message' => 'Đã xảy ra lỗi']);
            }
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|object|void
     */
    public function calculate(Request $request)
    {
        $filePath = $this->_PATH_EXTRACTED;
        $list = Cache::get(self::CAKE_LIST_NAME) ?? [];
        $listStudent = Cache::get(self::CAKE_STUDENT_NAME) ? Cache::get(self::CAKE_STUDENT_NAME)['data'] : [];
        if (empty($list) || empty($listStudent)) {
            return $this->sendResponseError(['message' => 'Đã xảy ra lỗi']);
        }

        $criterias = Criteria::where('exam_bank_id', 1)->get();

        $ret = [];
        foreach ($listStudent as $student) {
            $phpWord = PHPIOFactory::load($student['path'] . '/' . $student['studentAssignment'][0]);
            // Lấy danh sách các sections trong tài liệu
            $sections = $phpWord->getSections();
            $totalPoint = 0;
            $ret[$student['studentID']]['totalPoint'] = 0;
            foreach ($criterias as $criteria) {
                $ret[$student['studentID']][$criteria->id] = [
                    'point' => $criteria->point,
                    'realPoint' => $criteria->point,
                    'flag' => true,
                    'criteriaName' => $criteria->property_name,
                    'studentId' => $student['studentID'],
                ];
                switch ($criteria->property_type) {
                    case PropertyType::FONT:

                        break;
                    case PropertyType::PAGE_SIZE_ALL:
                        foreach ($sections as $section) {
                            // page size trong bài thi
                            $pageSize = $section->getStyle()->getPaperSize();
                            // page size trong DB
                            $typeSize = PageSize::getKey((int)$criteria->content);
                            if ($pageSize != $typeSize) {
                                $ret[$student['studentID']][$criteria->id]['flag'] = false;
                                $ret[$student['studentID']][$criteria->id]['realPoint'] = 0;
                            }
                        }
                        break;
                    case PropertyType::FOOTER_ALL:
                        foreach ($sections as $section) {
                            $footers = $section->getFooters()[1]->getElements()[0];
                            dd($footers);
                            if (count($footers) > 0) {
                                $footerText = '';
                                foreach ($footers as $footer) {
                                    // Lấy nội dung của footer
                                    $elements = $footer->getElements();
                                    dd($elements[0]);
                                    foreach ($elements as $element) {
                                        if ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
                                            $footerText .= $element->getText();
                                        }
                                    }
                                    // Lấy kiểu của footer
                                    $footerType = $footer->getType();
                                }
                                $footerInfo = $footerText;
                            }

                        }
                        break;
                    case PropertyType::MERGE_LEFT_ALL:
                    case PropertyType::MERGE_RIGHT_ALL:
                    case PropertyType::MERGE_TOP_ALL:
                    case PropertyType::MERGE_BOTTOM_ALL:
                        $this->checkMarginAll($sections, $criteria, $student, $ret);
                        break;
                    case PropertyType::TITLE:
                        $title = $phpWord->getDocInfo()->getTitle();
                        $this->checkInfos($criteria, $student, $ret, $title);
                        break;
                    case PropertyType::AUTHOR:
                        $author = $phpWord->getDocInfo()->getCreator();
                        $this->checkInfos($criteria, $student, $ret, $author);
                        break;
                    default:
                        break;
                }
                $ret[$student['studentID']]['totalPoint'] += $ret[$student['studentID']][$criteria->id]['realPoint'];
            }
        }
        dd($ret);
    }

    /**
     * @param $sections
     * @param $criteria
     * @param $student
     * @param $ret
     * @return void
     */
    public function checkMarginAll($sections, $criteria, $student, &$ret)
    {
        $value = 0;
        foreach ($sections as $section) {
            switch ((int)$criteria->property_type) {
                case PropertyType::MERGE_LEFT_ALL:
                    $value = round($section->getStyle()->getMarginLeft() / 569, 1);
                    break;
                case PropertyType::MERGE_RIGHT_ALL:
                    $value = round($section->getStyle()->getMarginRight() / 569, 1);
                    break;
                case PropertyType::MERGE_TOP_ALL:
                    $value = round($section->getStyle()->getMarginTop() / 569, 1);
                    break;
                case PropertyType::MERGE_BOTTOM_ALL:
                    $value = round($section->getStyle()->getMarginBottom() / 569, 1);
                    break;
            }
            if ((double)$value != (double)$criteria->content) {
                $ret[$student['studentID']][$criteria->id]['flag'] = false;
                $ret[$student['studentID']][$criteria->id]['realPoint'] = 0;
            }
        }
    }

    /**
     * @param $criteria
     * @param $student
     * @param $ret
     * @param $value
     * @return void
     */
    public function checkInfos($criteria, $student, &$ret, $value)
    {
        $content = json_decode($criteria->content, true);
        if (is_array($content) && !array_key_exists($content['key'], $content) && !array_key_exists($content['value'], $content)) {
            switch ((int)$content['key']) {
                case InfoType::STUDENT_NAME:
                    if (!str_contains($this->stripUnicode($value), $this->stripUnicode($student['studentName']))) {
                        $ret[$student['studentID']][$criteria->id]['flag'] = false;
                        $ret[$student['studentID']][$criteria->id]['realPoint'] = false;
                    }
                    break;
                case InfoType::STUDENT_CODE:
                    if (!str_contains($this->stripUnicode($value), $this->stripUnicode($student['studentID']))) {
                        $ret[$student['studentID']][$criteria->id]['flag'] = false;
                        $ret[$student['studentID']][$criteria->id]['realPoint'] = false;
                    }
                    break;
                case InfoType::STUDENT_CODE_NAME:
                    $this->stripUnicode($student['studentName']);

                    if (!str_contains($this->stripUnicode($value), $this->stripUnicode($student['studentName'])) || !str_contains($this->stripUnicode($value), $this->stripUnicode($student['studentID']))) {
                        $ret[$student['studentID']][$criteria->id]['flag'] = false;
                        $ret[$student['studentID']][$criteria->id]['realPoint'] = false;
                    }
                    break;
                case InfoType::OTHER:
                    if (!str_contains($this->stripUnicode($value), $this->stripUnicode($content['value']))) {
                        $ret[$student['studentID']][$criteria->id]['flag'] = false;
                        $ret[$student['studentID']][$criteria->id]['realPoint'] = 0;
                    }
                    break;
            }
        } else {
            $ret[$student['studentID']][$criteria->id]['flag'] = false;
            $ret[$student['studentID']][$criteria->id]['realPoint'] = 0;
        }
    }

    /**
     * Xóa dấu câu trong chuỗi
     * @param string $str Chuỗi cần xóa dấu
     * @return string $str
     * **/
    function stripUnicode(string &$str): string
    {
        $str = mb_strtolower($str);
        $unicode = array(
            'a' => 'a|á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'A' => 'A|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'd' => 'd|đ',
            'D' => 'D|Đ',
            'e' => 'e|é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'E' => 'E|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'i' => 'i|í|ì|ỉ|ĩ|ị',
            'I' => 'I|Í|Ì|Ỉ|Ĩ|Ị',
            'o' => 'o|ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'O' => 'O|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'u' => 'u|ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'U' => 'U|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'y' => 'y|ý|ỳ|ỷ|ỹ|ỵ',
            'Y' => 'Y|Ý|Ỳ|Ỷ|Ỹ|Ỵ'
        );
        foreach ($unicode as $nonUnicode => $uni) $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        return str_replace(' ', '', $str);
    }

    private function getTextContent($paragraph, $ns_w)
    {
        $text = '';


        // Iterate through text elements in the paragraph
        foreach ($paragraph->xpath('.//w:t') as $textElement) {
            // Append text content to the result
            $text .= (string)$textElement;
        }


        return $text;
    }


    public function getListStyles($filePath)
    {
        // Đọc file DOCX như một tệp nén
        $zip = new ZipArchive();
        if ($zip->open($filePath) === true) {
            // Đọc nội dung của file styles.xml trong tệp nén
            $stylesContent = $zip->getFromName('word/styles.xml');
            // Đọc nội dung của file word/document.xml trong tệp nén
            $documentContent = $zip->getFromName('word/document.xml');
            $zip->close();

            if (!empty($stylesContent) && !empty($documentContent)) {
                // Lấy danh sách các style từ file styles.xml
                $styles = $this->extractStyles($stylesContent);


                // Lấy danh sách các đoạn văn cùng với thông tin style tương ứng
                $contentWithStyles = $this->extractContentWithStyles($documentContent, $styles);

            } else {
                echo "Failed to read styles.xml or document.xml";
            }
        } else {
            echo "Failed to open the DOCX file";
        }
    }

    private function extractStyles($stylesXml)
    {
        $styles = [];


        // Load XML content
        $xml = simplexml_load_string($stylesXml);

        // Register namespaces
        $namespaces = $xml->getDocNamespaces();
        $ns_w = $xml->getNamespaces(true)['w'];


        // Iterate through styles
        foreach ($xml->xpath('//w:style') as $style) {
            $styleName = (string)($style->attributes($ns_w)->styleId);


            // Extract font name
            $fontName = null;
            $fontElement = $style->xpath('.//w:rFonts');
            if (!empty($fontElement)) {
                $fontName = (string)($fontElement[0]->attributes($ns_w)->ascii);
            }


            // Extract font size
            $fontSize = null;
            $fontSizeElement = $style->xpath('.//w:sz');
            if (!empty($fontSizeElement)) {
                $fontSize = (string)($fontSizeElement[0]->attributes($ns_w)->val);
            }


            // Extract font style
            $fontStyle = null;
            $fontStyleElement = $style->xpath('.//w:b');
            if (!empty($fontStyleElement)) {
                $fontStyle = 'Bold';
            } else {
                $fontStyleElement = $style->xpath('.//w:i');
                if (!empty($fontStyleElement)) {
                    $fontStyle = 'Italic';
                }
            }


            // Extract font color
            $fontColor = null;
            $fontColorElement = $style->xpath('.//w:color');
            if (!empty($fontColorElement)) {
                $fontColor = (string)($fontColorElement[0]->attributes($ns_w)->val);
            }


            // Extract indent information
            $indentLeft = null;
            $indentHanging = null;
            $indentElement = $style->xpath('.//w:ind');


            if (!empty($indentElement)) {
                $indentLeft = (string)($indentElement[0]->attributes($ns_w)->left ?? null);
                $indentHanging = (string)($indentElement[0]->attributes($ns_w)->hanging ?? null);
            }
            // Extract spacing information
            $spaceBefore = null;
            $spaceAfter = null;
            $spacingElement = $style->xpath('.//w:spacing');
            if (!empty($spacingElement)) {
                $spaceBefore = (string)($spacingElement[0]->attributes($ns_w)->before ?? null);
                $spaceAfter = (string)($spacingElement[0]->attributes($ns_w)->after ?? null);
            }


            // Extract line spacing
            $lineSpacing = null;
            $lineSpacingElement = $style->xpath('.//w:spacing');
            if (!empty($lineSpacingElement)) {
                $lineSpacing = (string)($lineSpacingElement[0]->attributes($ns_w)->line ?? null);
            }


            // Extract numbering format
            $numberingFormat = null;
            $numPrElement = $style->xpath('.//w:numPr');
            if (!empty($numPrElement)) {
                $numId = (string)($numPrElement[0]->xpath('.//w:numId')[0]->attributes($ns_w)->val ?? null);
                $numberingFormat = $this->getNumberingFormat($numId, $xml, $ns_w);
            }


            $styles[] = [
                'name' => $styleName,
                'font' => $fontName,
                'font_size' => $fontSize,
                'font_style' => $fontStyle,
                'font_color' => $fontColor,
                'indent_left' => $indentLeft,
                'indent_hanging' => $indentHanging,
                'space_before' => $spaceBefore,
                'space_after' => $spaceAfter,
                'line_spacing' => $lineSpacing,
                'numbering_format' => $numberingFormat,
            ];
        }

        dd($styles);
        return $styles;
    }


    private function extractContentWithStyles($documentXml, $styles)
    {
        $contentWithStyles = [];


        // Load XML content
        $xml = simplexml_load_string($documentXml);


        // Register namespaces
        $namespaces = $xml->getDocNamespaces();
        $ns_w = $xml->getNamespaces(true)['w'];


        // Iterate through paragraphs
        foreach ($xml->xpath('//w:p') as $paragraph) {
            // Get paragraph style ID
            $styleId = (string)($paragraph->xpath('./w:pPr/w:pStyle/@w:val')[0] ?? null);
            $textContent = $this->getTextContent($paragraph, $ns_w);


            // Find the corresponding style
            $style = null;
            foreach ($styles as $s) {
                if ($s['name'] === $styleId) {
                    $style = $s;
                    break;
                }
            }


            // If no style found, use default style
            if ($style === null) {
                // Find the style with the name 'Normal' and use its properties
                foreach ($styles as $s) {
                    if ($s['name'] === 'Normal') {
                        $style = $s;
                        break;
                    }
                }
            }


            // Add content with style to the list
            $contentWithStyles[] = [
                'style' => $style,
                'text' => $textContent,
            ];
        }


        return $contentWithStyles;
    }


}
