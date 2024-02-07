<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use App\Models\Paiement;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function generatePDF()
    {
        $data = [
            "etudiant" => Etudiant::find(1),
            "auth" => auth()->user(),
            "paiements" => Paiement::find(1),
        ];

        $pdf = Pdf::loadView('generate-pdf', $data);
        return $pdf->download('invoice.pdf');
        // return view('generate-pdf', $data);
    }
}
