<?php
function checkKeysExists($value, $keys_array)
{

    $required = $keys_array;
    $data = array_change_key_case(array_shift($value), CASE_LOWER);
    // Trim the keys of the $data array
    $keys = array_map('trim', array_keys($data));

    // Replace characters with underscores
    $keys = str_replace(['', '-', ' '], '_', $keys);


    $results = array_combine($keys, array_values($data));

    if (count(array_intersect_key(array_flip($required), $results)) === count($required)) {
        //All required keys exist!
        $status = 1;
    } else {
        $missing = array_intersect_key(array_flip($required), $results);
        $data_miss = array_diff(array_flip($required), $missing);
        $status = ' Column with title "' . implode(', ', array_keys($data_miss)) . '"  miss from Excel file. Please make sure file is in the same format as a sample file';
    }

    return $status;
}

function getDataBySheet($objPHPExcel, $sheet_id)
{
    $sheet = $objPHPExcel->getSheet($sheet_id);
    $highestRow = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();
    $headings = $sheet->rangeToArray('A1:' . $highestColumn . 1, NULL, TRUE, FALSE);
    $data = array();
    for ($row = 2; $row <= $highestRow; $row++) {
        //  Read a row of data into an array
        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
        $rowData[0] = array_combine($headings[0], $rowData[0]);
        $data = array_merge_recursive($data, $rowData);
    }
    return $data;
}

if (!function_exists('uploadExcel')) {
    function uploadExcel($sheet_name = null)
    {
        try {
            $folder = "storage/uploads/media/";
            if (!is_dir($folder)) {
                mkdir($folder, 0777, true);
            }
            $file = request()->file('file');

            if (!$file) {
                return json_encode(['error' => 'No file uploaded']);
            }
            $name = time() . rand(4343, 31243434) . '.' . $file->guessClientExtension();
            $move = $file->move($folder, $name);
            $path = $folder . $name;
            if (!$move) {
                die('upload Error');
            } else {
                $objPHPExcel = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
            }
        } catch (Exception $e) {
            $resp = new \stdClass();
            $resp->success = FALSE;
            $resp->msg = 'Error Uploading file';
            echo json_encode($resp);
        }
        $sheets = $objPHPExcel->getSheetNames();
        if ($sheet_name == null) {
            return getDataBySheet($objPHPExcel, 0);
        } else {
            $data = [];
            foreach ($sheets as $key => $value) {
                $data[$value] = [];
            }
            foreach ($sheets as $key => $value) {
                $excel_data = getDataBySheet($objPHPExcel, $key);
                count($excel_data) > 0 ? array_push($data[$value], $excel_data) : '';
            }
            return $data;
        }
        unlink($path);
    }
}