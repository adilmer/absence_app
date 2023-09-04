<?php

namespace App\Traits;

/**
 * Summary of UploadTrait
 */
trait UploadTrait
{
    /**
     * Summary of saveAs
     * @param mixed $fileRequest
     * @param mixed $Name
     * @param mixed $folder
     * @return string
     */
    function saveAs($fileRequest, $Name, $folder)
    {
        //save file
        $file_name = null;
        if ($fileRequest) {
            $file_name = $Name . '.' . $fileRequest->getClientOriginalExtension();
            $fileRequest->move(public_path($folder), $file_name, 'public');
        }
        return $file_name;
    }
}
