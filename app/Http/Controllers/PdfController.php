<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use App\Models\Inscription;
use App\Models\Paiement;
use App\Models\Price;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function generatePDF(Paiement $paiement)
    {
        // retreive all records from db
        $iscription = Inscription::where('paiement_id', '=', $paiement->id)->first();
        $etudiant = Etudiant::find($iscription->etudiant_id);
        $price = Price::find(2);
        
       
        $data = [
            "etudiant" => $etudiant,
            "session" => $etudiant->session,
            "auth" => auth()->user(),
            "paiements" => $paiement,
            "price" => $price,
        ];
        // dd($data);

        $pdf = Pdf::loadView('pages/generatePdf/generate-pdf', $data);
        // return $pdf->download('Facture.pdf');
        return view('pages/generatePdf/generate-pdf', $data);
    }
}
