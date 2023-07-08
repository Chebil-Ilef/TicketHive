<?php

namespace App\Service ;

class PdfService{
    private $domPdf ;

    public function __construct(){
        $this->domPdf = new DomPdf();

        $pdfOption = new Options();

        $pdfOption->set('defaultFont','Garamond');

        $this->domPdf-> setOptions($pdfOption);
    }

    public function showpdfFile($html)
    {
        $this->domPdf->load($html);
        $this->domPdf->render();
        $this->domPdf->stream("Details.pdf",['Attachement'=>false]); 
    }

    
}