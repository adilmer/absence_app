<?php

namespace App\Traits;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;

trait ConvertTrait
{
    public function ExceltoArray($csvFilePath, $outputExcelFilePath)
    {
        // Read the CSV file using Maatwebsite/Laravel-Excel
        $csvData = Excel::toArray([], $csvFilePath)[0];
        if (!File::exists($outputExcelFilePath)) {
            File::put($outputExcelFilePath, 'This is the content of the file.');
            }
        // Write the CSV data to an Excel file
        Excel::store(collect($csvData), $outputExcelFilePath);
       // dd('ff');

        return $outputExcelFilePath;
    }

    public function excelToCsv($excelFilePath, $outputCsvFilePath)
    {
        // Read the Excel file using Maatwebsite/Laravel-Excel
        $excelData = Excel::toArray([], $excelFilePath)[0];

        // Write the Excel data to a CSV file
        $file = fopen($outputCsvFilePath, 'w');
        foreach ($excelData as $row) {
            fputcsv($file, $row);
        }
        fclose($file);
        return $outputCsvFilePath;
    }
}
