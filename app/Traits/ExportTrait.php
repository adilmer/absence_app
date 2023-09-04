<?php

namespace App\Traits;
use PhpOffice\PhpWord\TemplateProcessor;

/**
 * Summary of ExportTrait
 */
trait ExportTrait
{
    /**
     * Summary of exportWord
     * @param mixed $fileRequest
     * @param mixed $Name
     * @param mixed $folder
     * @return string
     */
    function exportWord($data , $template_name, $file_name)
    {

        $templateProcessor = new TemplateProcessor('template_documents/'.$template_name.'.docx');

            foreach ($data as $key => $value){
                if (!is_array($value)){
                    $templateProcessor->setValue($key,$value);
                }
            }
            $path = 'word_documents/'.$file_name.' ('.time().') '.'.docx';
            $templateProcessor->saveAs($path);
            return $path;
    }


}
