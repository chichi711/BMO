<?php 
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
/**
* composer require phpoffice/phpspreadsheet
*
**/
class Xls{
    
    function export_download($header,$datas,$filename=""){
        if($filename == ''){
            $filename = date('Y-m-d-H-i-s').'.xls';
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // 設定標題        
        $col1 = 'A';
        foreach ($header as $key => $value) {
            $sheet->setCellValue(chr(ord($col1) + $key).'1', $value);
        }
        // 設定內容
        foreach($datas as $k1=>$v1){
            $i =0;
            foreach ($v1 as $k2 => $v2) {
                $sheet->setCellValue(chr(ord($col1) + $i).($k1+2), $v2);
                $i++;
            }
        }
        $writer = new Xlsx($spreadsheet);
        header('Content-Type:application/vnd.ms-excel');
        header('Content-Disposition:attachment;filename="'.$filename.'"');
        header('Cache-Control:max-age=0');
        $writer->save('php://output');

    }
    function importExecl(string $file = '', int $sheet = 0, int $columnCnt = 0, &$options = [])
    {
        try {
            /* 轉碼 */
            $file = iconv("utf-8", "gb2312", $file);

            if (empty($file) OR !file_exists($file)) {
                throw new \Exception('檔案不存在!');
            }

            /** @var Xlsx $objRead */
            $objRead = IOFactory::createReader('Xlsx');

            if (!$objRead->canRead($file)) {
                /** @var Xls $objRead */
                $objRead = IOFactory::createReader('Xls');

                if (!$objRead->canRead($file)) {
                    throw new \Exception('只支援匯入Excel檔案！');
                }
            }

            /* 如果不需要獲取特殊操作，則只讀內容，可以大幅度提升讀取Excel效率 */
            empty($options) && $objRead->setReadDataOnly(true);
            /* 建立excel物件 */
            $obj = $objRead->load($file);
            /* 獲取指定的sheet表 */
            $currSheet = $obj->getSheet($sheet);

            if (isset($options['mergeCells'])) {
                /* 讀取合併行列 */
                $options['mergeCells'] = $currSheet->getMergeCells();
            }

            if (0 == $columnCnt) {
                /* 取得最大的列號 */
                $columnH = $currSheet->getHighestColumn();
                /* 相容原邏輯，迴圈時使用的是小於等於 */
                $columnCnt = Coordinate::columnIndexFromString($columnH);
            }

            /* 獲取總行數 */
            $rowCnt = $currSheet->getHighestRow();
            $data   = [];

            /* 讀取內容 */
            for ($_row = 1; $_row <= $rowCnt; $_row++) {
                $isNull = true;

                for ($_column = 1; $_column <= $columnCnt; $_column++) {
                    $cellName = Coordinate::stringFromColumnIndex($_column);
                    $cellId   = $cellName . $_row;
                    $cell     = $currSheet->getCell($cellId);

                    if (isset($options['format'])) {
                        /* 獲取格式 */
                        $format = $cell->getStyle()->getNumberFormat()->getFormatCode();
                        /* 記錄格式 */
                        $options['format'][$_row][$cellName] = $format;
                    }

                    if (isset($options['formula'])) {
                        /* 獲取公式，公式均為=號開頭資料 */
                        $formula = $currSheet->getCell($cellId)->getValue();

                        if (0 === strpos($formula, '=')) {
                            $options['formula'][$cellName . $_row] = $formula;
                        }
                    }

                    if (isset($format) && 'm/d/yyyy' == $format) {
                        /* 日期格式翻轉處理 */
                        $cell->getStyle()->getNumberFormat()->setFormatCode('yyyy/mm/dd');
                    }

                    $data[$_row][$cellName] = trim($currSheet->getCell($cellId)->getFormattedValue());

                    if (!empty($data[$_row][$cellName])) {
                        $isNull = false;
                    }
                }

                /* 判斷是否整行資料為空，是的話刪除該行資料 */
                if ($isNull) {
                    unset($data[$_row]);
                }
            }

            return $data;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
?>