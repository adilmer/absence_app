<?php

namespace App\PDF;

use TCPDF;

class ArabicPDF extends TCPDF
{
    protected $tempDir;

    public function __construct()
    {
        parent::__construct();

        // Set the font family and size for Arabic text
        $this->SetFont('dejavusans', '', 10);

        // Set the temporary directory for TCPDF
        $this->tempDir = storage_path('app/public/temp');
    }

    protected function getTempDir()
    {
        return $this->tempDir;
    }
}
