<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cour;
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
        $price = Price::find($etudiant->categorie_id);
        $examen = null;
        $cours = null;

        if($paiement->type == "Reinscription a un examen" || $paiement->type == "Inscription a un examen"){
            $examen = Examen::where('id', '=', $iscription->idCourOrExam)->first();
        }
        if($paiement->type == "Reinscription a un cour" || $paiement->type == "Inscription a un cour"){
            $cours = Cour::where('id', '=', $iscription->idCourOrExam)->first();
        }

            
        
        $nameDuFichier = 'Facture' . "_" . $etudiant->nom . "_". $etudiant->prenom . ".pdf";
       
        $data = [
            "etudiant" => $etudiant,
            "session" => $etudiant->session,
            "auth" => auth()->user(),
            "paiements" => $paiement,
            "price" => $price,
            "examen" => $examen,
            "cours" => $cours,
        ];
        // dd($data);

        // $pdf = Pdf::loadView('pages/generatePdf/generate-pdf', $data);
        // return $pdf->download($nameDuFichier);
        return view('pages/generatePdf/generate-pdf', $data);
    }
}
