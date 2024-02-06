<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function generatePDF()
    {
        $data = [
            "title" => 'exemple title pdf',
            "date" => date('m/d/Y')
        ];

        $pdf = Pdf::loadView('generate-pdf', $data);
        return $pdf->download('invoice.pdf');
    }
}
