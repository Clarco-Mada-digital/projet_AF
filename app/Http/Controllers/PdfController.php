<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use App\Models\Examen;
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
        $examen = null;
        if($iscription->examen_id != null){
            $examen = Examen::where('id', '=', $iscription->examen_id)->first();
        }

            
        
        $nameDuFichier = 'Facture' . "_" . $etudiant->nom . "_". $etudiant->prenom . ".pdf";
       
        $data = [
            "etudiant" => $etudiant,
            "session" => $etudiant->session,
            "auth" => auth()->user(),
            "paiements" => $paiement,
            "price" => $price,
            "examen" => $examen,
        ];
        // dd($data);

        // $pdf = Pdf::loadView('pages/generatePdf/generate-pdf', $data);
        // return $pdf->download($nameDuFichier);
        return view('pages/generatePdf/generate-pdf', $data);
    }
}
