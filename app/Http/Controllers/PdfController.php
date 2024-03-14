<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Adhesion;
use App\Models\Cour;
use App\Models\Etudiant;
use App\Models\Examen;
use App\Models\Inscription;
use App\Models\Paiement;
use App\Models\Price;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public $session;


    public function generatePDF(Paiement $paiement)
    {
        // retreive all records from db
        $inscription = $paiement->inscription;
        foreach($inscription as $insc)
        {
            $this->session = $insc->session;
            $etudiant = Etudiant::find($insc->adhesion_id);

            if ($etudiant == null)
            {
                $etudiant['adhesion'] = Adhesion::find($insc->adhesion_id)->toArray();                
            }

            $categories_id = $etudiant['adhesion']['categorie_id'];
            if ($categories_id == 4)
            {
                $price = $paiement->montant;
            }
            else{
                $price = Price::find($categories_id);
            }

            $examen = null;
            $cours = null;

            if($paiement->type == "Inscription a un examens" || $paiement->type == "Adhésion + Inscription a un examens"){
                $examen = Examen::where('id', '=', $insc->idCourOrExam)->first();
            }
            if($paiement->type == "Inscription a un cours" || $paiement->type == "Adhésion + Inscription a un cours"){
                $cours = Cour::where('id', '=', $insc->idCourOrExam)->first();
            }
        }
            
        
        $nameDuFichier = 'Facture' . "_" . $etudiant['adhesion']['nom'] . "_". $etudiant['adhesion']['prenom'] . ".pdf";
       
        $data = [
            "etudiant" => $etudiant,
            "session" => $this->session,
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
