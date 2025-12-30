<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// This method generates a csv file and then returns the generated content

if (!function_exists('arrayToCSV')) {
    function arrayToCSV($query, $fields, $filename = "CSV")
    {
        if (count($query) == 0) {
            return "The query is empty. It doesn't have any data.";
        } else {
            $headers = rowCSV($fields);

            $data = "";
            foreach ($query as $row) {
                $line = rowCSV($row);
                $data .= trim($line) . "\n";
            }
            $data = str_replace("\r", "", $data);

            $content =$data;
            
            $filename = date('YmdHis') . "_export_{$filename}.csv";

            header("Content-Description: File Transfer");
            header("Content-type: application/csv; charset=UTF-8");
            header("Content-Disposition: attachment; filename={$filename}");
            header("Content-Transfer-Encoding: binary");
            header("Content-Type: application/force-download");
            //header("Content-Type: application/octet-stream");
            header("Content-Type: application/download");
            header("Expires: 0");
            header("Cache-Control: must-revalidate");
            header("Pragma: public");
            header("Content-Length: " . strlen($content));

            print_r($content);
        }
    }
}

if (!function_exists('rowCSV')) {
    function rowCSV($fields)
    {
        $output = '';
        $separator = '';
        foreach ($fields as $field) {
            if (preg_match('/\\r|\\n|,|"/', $field)) {
                $field = '"' . str_replace('"', '""', $field) . '"';
            }
            $output .= $separator . $field;
            $separator = ',';
        }
        return $output . "\r\n";
    }
}



if (!function_exists('array_to_csv')) {
    function array_to_csv($array, $download = "")
    {
        if ($download != "")
        {   
            header('Content-Type: application/csv');
            header('Content-Disposition: attachement; filename="' . $download . '"');
        }   

        ob_start();
        $f = fopen('php://output', 'w') or show_error("Can't open php://output");
        $n = 0; 
        foreach ($array as $line)
        {
            $n++;
            if ( ! fputcsv($f, $line))
            {
                show_error("Can't write line $n: $line");
            }
        }
        fclose($f) or show_error("Can't close php://output");
        $str = ob_get_contents();
        ob_end_clean();

        if ($download == "")
        {
            return $str;    
        }
        else
        {   
            echo $str;
        }   
    }
}
/* End of file export_csv_helper.php */
/* Location: ./application/helpers/export_csv_helper.php */