<?php

namespace Alexbirtwell\AbFilamentExtras\Components\Services;

use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;
use function App\Services\utf8_encode;

class CsvFileProcessor
{

    public $errorDetail = null;
    public $site = null;

    public $expectedFields = null;

    public function read(UploadedFile $file): array
    {
        $array1 = $this->csvToArray($file);
        return $this->formatArrayWithHeaders($array1);
    }

    public function csvToArray(UploadedFile $file) {
        $csvData = $this->readCsvToAssociativeArray($file);
        return $csvData;
    }

    public function readCsvToAssociativeArray(UploadedFile $file)
    {
        $return = array();
        $delimiter=','; $enclosure='"';
        $reader = IOFactory::createReader(ucwords($file->extension()));
        $spreadsheet = $reader->load($file->getRealPath());
        $sheet = $spreadsheet->getSheet($spreadsheet->getFirstSheetIndex());
        $data = $sheet->toArray();
        $rowIncrement = 0;
        foreach($data as $row){
            $col = array_map('trim', $row);

            if ($rowIncrement == 0) {
                $headers = $col;
            }else{
                $return[] = $col;
            }

            $rowIncrement++;
        }
        $this->headers = $headers;

        $return = $this->clearEmptyRows($return);
        $return = $this->clearEmptyColumns($return);

        return $return;
    }

    public function clearEmptyRows(array $return)
    {
        //each successful row should have 5 columns with data
        $newReturn = [];
        foreach($return as $row) {
            $continue = false;
            foreach($row as $col){
                if ($col != '') {
                    $continue = true;
                }
            }
            if ($continue) {
                $newReturn[] = $row;
            }
        }
        return $newReturn;
    }

    public function clearEmptyColumns(array $return)
    {
        $emptyCols = [];
        //cycle record set and check for empty column values throughout
         foreach($return as $rowKey => $row) {
            foreach($row as $colKey=>$col) {
                if($col == "") {
                    $emptyCols[$colKey] = true;
                }else{
                    unset($emptyCols[$colKey]);
                }
            }
        }

         //remove empty cols when not used
        foreach($return as $rowKey => $row) {
            foreach($row as $colKey=>$col) {
                if(isset($emptyCols[$colKey])) {
                    unset($return[$rowKey][$colKey]);
                }
            }
        }
        return $return;
    }

    public function detectLineEnding(string $csv)
    {
        if (strstr($csv, "\r\n")) {
            return "\n";
        }
        if (strstr($csv, "\r")) {
            return "\r";
        }

        return "\n";
    }
    public function readCsvToAssociativeArrayOld(UploadedFile $file)
    {
        //https://github.com/Maatwebsite/Laravel-Excel
        $csv = fopen($file->getRealPath(), 'r');
        $headers = [];
        $result = [];
        $row = 0;

        while (($data = fgetcsv($csv, 0, ",")) !== FALSE) {

            $num = count($data);
            for ($column=0; $column < $num; $column++) {
                if ($row == 0) {
                    $headers[$column] = $data[$column];
                    $result[$row][$column] = $data[$column];
                }else{
                    $result[$row][$column] = $data[$column];
                }
            }
            $row++;
        }

        $this->headers = $headers;
        return $result;
    }

    public function formatArrayWithHeaders(array $rows, ?array $headers = null)
    {
        $result = [];
        $row = 0;
        if (! $headers) {
            $headers = $this->headers;
        }

        foreach($rows as $data) {

            $num = count($data);
            foreach($data as $column => $value) {
                if(isset($headers[$column]) && $headers[$column] !== 'Ignore'){
                    $result[$row][$headers[$column]] = $data[$column];
                }
            }
            $row++;
        }
        return $result;
    }

    public function parseErrorToArray(string $error)
    {
        //Invalid account_number on line 3 (643713189)
        if (strstr($error, " - ")) {
            $tmpArray = explode(' - ', $error);
            $error = $tmpArray[1];
        }
        $summary = $error;
        $error = str_replace(["Invalid", "on", "line"], ["", "", ""], $error);

        $details = explode(" ", $error);

        return [
            'summary' => $summary,
            'column' => $details[1],
            'row' => (int) $details[4],
            'value' => substr($details[5], 1,-1)
        ];
    }

    public function applyCorrections(array $data, array $corrections)
    {
        foreach($corrections as $row=>$correction) {
            if (isset($correction['remove'])) {
                unset($data[$row]);
                break;
            }
            foreach($correction as $column=>$value) {
                $data[$row][$column] = $value;
            }
        }
        return array_values($data);
    }

     public function deleteFile(UploadedFile $file)
    {
        unlink($file->getRealPath());
    }

    public function cleanData(array $results)
    {
        $line = 0;
        $data = [];
        foreach($results as $result) {
            foreach($result as $key=>$value) {
                $data[$line][$key] = $this->cleanEntry($key, $value);
            }
            $line++;
        }
        return $data;
    }


    public function cleanEntry(string $key, string $data)
    {
        $check = Str::of($key)->camel()->__toString();
        $method = "clean" . ucwords($check);
        $data = utf8_encode($data);

        if (method_exists($this,$method)) {
            return $this->$method($data);
        }
        return $data;
    }

    /**
     * @param array $results
     * @param bool $throwErrors
     * @return array|bool
     * @throws Exception
     */
    public function validateData(array $results, bool $throwErrors = true)
    {
        $line = 0;
        $errors = [];
        foreach($results as $result) {
            foreach($result as $key=>$data) {
                if ($error = $this->validateEntry($key, $data, $line, $throwErrors)) {
                    if ($error) {
                        $errors[] = $error;
                    }
                }
            }
            $line++;
        }

        if (count($errors)) {
            $errorStr = implode("<br/> - ",$errors);
            if ($throwErrors) {
                throw new Exception("Validation errors on csv file. These should be corrected and the file resubmitted." . "<br/> - " . $errorStr);

            }else{
                return $errors;
            }
        }

        return false; //false means no errors found file is valid
    }

    public function validateEntry(string $key, string $data, int $line)
    {
        $check = Str::of($key)->camel()->__toString();
        $validmethod = "isInvalid" . ucwords($check);

        if (method_exists($this,$validmethod)) {
            $error = $this->$validmethod($data);
        }

        if (isset($error) && $error) {
            $detail = '';
            if ($this->errorDetail) {
                $detail = $this->errorDetail;
            }
            $this->errorDetail =  null;
            return "Invalid $key on line $line ($data) $detail";
        }
        return false; //false means no error this is valid
    }
}
