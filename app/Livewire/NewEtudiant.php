<?php

namespace App\Livewire;

use App\Models\Adhesion;
use App\Models\Categorie;
use App\Models\Cour;
use Livewire\Component;
use App\Models\Etudiant;
use App\Models\Examen;
use App\Models\Inscription;
use App\Models\Level;
use App\Models\Paiement;
use App\Models\Price;
use App\Models\Session;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;

class NewEtudiant extends Component
{
    use WithFileUploads;

    // ----------- Nos variable --------------    
    public string $search = "";
    public $memberResult = [];
    public $newEtudiant = ['profil' => '', 'level_id' => '1', 'ville' => 'Diego', 'pays' => 'Madagascar'];
    public $photo;
    public int $bsSteepActive = 1;
    public $listSession;
    public $levels;
    public $categories;
    public $nscList = ["cours" => [], "level" => [], "examens" => []];
    public $now;
    public $toDay;
    public $etudiantSession;
    public $sessionSelected = null;
    public $moyenPaiement;
    public $paiement_id = 0;
    public $statue = "Totalement";
    public float $montantInscription = 0;
    public float $montantAdhesion;
    public float $montantExam = 0;
    public float $montantPaye = 0;
    public float $montantRestant = 0;
    public string $typeInscription = "cours";
    public $adhesionSelect;
    public bool $promotionActive = false;

    public bool $noMember = True;
    public bool $MemberPmb = false;

    protected $listeners = [
        'updateMontant' => 'updateMontant',
        'montantUpdated' => '$refresh' // Rafraîchir la vue quand le montant est mis à jour
    ];

    public function defineStatue($nomStatue)
    {
        $this->statue = $nomStatue;
    }

    public function defineMoyenPai($nomMoyenPai)
    {
        $this->moyenPaiement = $nomMoyenPai;
    }

    public function __construct()
    {
        $this->now = Carbon::now();
        $this->toDay = Carbon::today();
        $this->levels = Level::all();
        $this->listSession = Session::all();
        $this->categories = Categorie::all();
        foreach (Cour::all() as $cour) {
            array_push($this->nscList['cours'], ['cour_id' => $cour->id, 'cour_libelle' => $cour->libelle, 'cour_horaire' => $cour->horaire, 'active' => false]);
        };

        foreach (Examen::all() as $examen) {
            array_push($this->nscList['examens'], ['id' => $examen->id, 'libelle' => $examen->libelle, "level" => $examen->level->libelle, 'session_id' => $examen->session_id, 'active' => false]);
        }

        if ($this->listSession->toArray() == null) {
            $this->dispatch("showModalSimpleMsg", ['message' => "Avant d'inscrire un étudiant, soyer sûr qu'il y a de la session active !", 'type' => 'warning']);
            // return redirect(route('session'));
        }
        
    }

    public function initData(Adhesion $adhesion)
    {
        $this->search = "";        
        // $this->reset("noMember");
        $this->noMember = false;
        $this->MemberPmb = true;
        $this->newEtudiant = $adhesion->toArray();
        $this->adhesionSelect = $adhesion;
        $this->newEtudiant['level_id'] = '1';
    }

    public function resetData()
    {
        $this->search = "";        
        $this->reset("noMember");
        $this->reset("MemberPmb");
        $this->reset("newEtudiant");
        $this->reset("adhesionSelect");
    }

    public function updatedSearch()
    {
        // $this->reset($this->memberResult);

        $this->memberResult = Adhesion::whereRaw("CONCAT(TRIM(BOTH ' ' FROM nom), ' ', TRIM(BOTH ' ' FROM prenom)) LIKE ?", ["%{$this->search}%"])
            ->orWhereRaw("TRIM(BOTH ' ' FROM numCarte) LIKE ?", ["%{$this->search}%"])
            ->get();
    }

    // Fonction pour les etape du formulaire de l'enregistrement des étudiants
    public function bsSteepPrevNext($crèment)
    {
        if ($crèment == 'next') {
            if ($this->bsSteepActive == 1) 
            {
                $this->MemberPmb ? "" : $this->validate();
                $this->bsSteepActive += 1;
                return null;
            }
            elseif ($this->bsSteepActive == 2)
            {
                $this->sessionSelected = Session::find($this->etudiantSession);
                if($this->sessionSelected == null || $this->sessionSelected == "") {
                    $this->dispatch("showModalSimpleMsg", ['message' => "Veuillez sélectionner une session", 'type' => 'warning']);
                } else {
                    $this->updateMontant(); // Mettre à jour le montant après avoir sélectionné une session
                    $this->bsSteepActive += 1;
                }
            }
            elseif ($this->bsSteepActive == 3) 
            {
                if ($this->moyenPaiement == "") {
                    $this->dispatch("showModalSimpleMsg", ['message' => "Veuillez sélectionner un moyen de paiement", 'type' => 'warning']);
                } else {
                    $this->submitNewEtudiant();
                    $this->bsSteepActive += 1;
                }
                return null;
            } 
            elseif ($this->bsSteepActive == 4) 
            {
                return redirect(route('etudiants-list'));
            } 
            else 
            {
                $this->bsSteepActive += 1;
            }
        } else {
            $this->bsSteepActive -= 1;
        }
    }

    // Nos fonction de validation
    protected function rules()
    {
        $rule = [
            'photo' => ['image', 'max:1024', 'nullable'],
            'newEtudiant.nom' => ['required'],
            'newEtudiant.prenom' => 'required',
            'newEtudiant.sexe' => ['required'],
            'newEtudiant.ville' => ['required'],
            'newEtudiant.pays' => ['required'],
            'newEtudiant.dateNaissance' => ['required'],
            'newEtudiant.profession' => ['nullable'],
            'newEtudiant.email' => ['email'],
            'newEtudiant.telephone1' => ['min:10', 'max:10', 'nullable'],
            'newEtudiant.telephone2' => ['min:10', 'max:10', 'nullable'],
            'newEtudiant.adresse' => ['required'],
            'newEtudiant.numCarte' => [Rule::unique('adhesions', 'numCarte')],
            'newEtudiant.categorie_id' => ['required'],
            'newEtudiant.user_id' => ['integer'],
            'newEtudiant.level_id' => ['integer'],
            'newEtudiant.session_id' => ['integer'],

        ];

        return $rule;
    }

    // Function pour afficher les cours disponible dans la session sélectionnée
    public function updateCoursList()
    {
        $this->montantInscription = 0;
        if ($this->etudiantSession != null && $this->etudiantSession != 'null') {
            $this->nscList['cours'] = [];
            $this->nscList['examens'] = [];
            $this->sessionSelected = Session::find($this->etudiantSession);
            $cours = Session::find($this->etudiantSession)->cours;
            foreach ($cours as $cour) {
                array_push($this->nscList['cours'], ['cour_id' => $cour->id, 'cour_libelle' => $cour->libelle, 'cour_horaire' => $cour->horaire, 'active' => false]);
            };
            foreach (Examen::all() as $examen) {
                if ($examen->session_id == $this->etudiantSession) {
                    array_push($this->nscList['examens'], ['id' => $examen->id, 'libelle' => $examen->libelle, "level" => $examen->level->libelle, 'session_id' => $examen->session_id, 'active' => false]);
                }
            }
        }

        if ($this->sessionSelected->montantPromo != null && $this->sessionSelected->dateFinPromo > $this->now) {
            $this->promotionActive = true;
        }else{
            $this->promotionActive = false;
        }

        $this->dispatch("updateMontant");
        // Définir le montant d'inscription
        // if ($this->newEtudiant['categorie_id'] == '1') {
        //     $montantAdhesion = DB::table('prices')->where('id', 1)->value('montant');
        // }
        // if ($this->newEtudiant['categorie_id'] == '2') {
        //     $montantAdhesion = DB::table('prices')->where('id', 2)->value('montant');
        // }
        // if ($this->newEtudiant['categorie_id'] == '3') {
        //     $montantAdhesion = DB::table('prices')->where('id', 3)->value('montant');
        // }

    }
    
    public function togglePromotionActive()
    {
        $this->promotionActive = !$this->promotionActive;
        $this->updateMontant();
        $this->dispatch('montantUpdated'); // Émettre un événement pour forcer le rafraîchissement
    }

    public function updateMontant()
    {
        // Mettre à jour le montant d'adhésion
        $price = Price::withWhereHas('categories', function ($query) {
            $query->where('id', $this->newEtudiant['categorie_id']);
        })->first();
        $this->montantAdhesion = $price->montant;

        // Mettre à jour le montant d'inscription en fonction de la promotion
        if ($this->typeInscription == 'cours' && $this->sessionSelected) {
            $this->montantInscription = $this->promotionActive 
                ? $this->sessionSelected->montantPromo 
                : $this->sessionSelected->montant;
        }

        // pour l'inscription au examen
        if ($this->typeInscription == 'examens') {
            $this->montantInscription = 0;
            $this->montantExam = 0;
            if ($this->nscList['examens'] != null) {
                foreach ($this->nscList['examens'] as $examen) {
                    if ($examen['active']) {
                        $examenData = Examen::find($examen['id']);
                        $this->montantInscription += $examenData->price->montant;
                        $this->montantExam += $examenData->price->montant;
                    }
                }
            }
           
        }else{
            if ($this->promotionActive == true) {
                $this->montantInscription = $this->sessionSelected->montantPromo;
            }else{
                $this->montantInscription = $this->sessionSelected->montant;
            }
        }

        $this->noMember ? $this->montantInscription = ($this->montantInscription + $this->montantAdhesion) : "";
        
        // dd($this->promotionActive, $this->montantInscription);
    }

    // public function updateMontantRestant()
    // {
    //     if ($this->montantPaye > $this->montantInscription) {
    //         $this->dispatch("showModalSimpleMsg", ['message' => "Montant payé supérieur au montant de l'inscription", 'type' => 'warning']);
    //         $this->montantPaye = 0;
    //     }
    //     $this->montantRestant = 0;
    //     $this->montantRestant = $this->montantInscription - $this->montantPaye;
    // }

    // Enregistrement un nouveau étudiant
    public function submitNewEtudiant()
    {
        $categorie_indication = [
            1 => "JN",
            2 => "PR",
            3 => "PR",
            4 => "ME",
            5 => "ET",
            6 => "CL",
            7 => "AD",
            8 => "VL",
        ];

        $this->newEtudiant['user_id'] = Auth::user()->id;
        $this->newEtudiant['session_id'] = $this->etudiantSession;
         
        // $this->newEtudiant['numCarte'] = "AF-" . $categorie_indication[$this->newEtudiant['categorie_id']] . "." . random_int(100, 9000);
        $idCourOrExam = null;

        $this->MemberPmb ? "" : $this->validate();

        if ($this->photo != '') {
            $photoName = $this->photo->store('profil', 'public');
            $this->newEtudiant['profil'] = $photoName;
        }
        
        if ($this->MemberPmb)
        {
            if (Etudiant::where("adhesion_id", $this->adhesionSelect->id)->first() != null)
            {
                $newEtud = Etudiant::where("adhesion_id", $this->adhesionSelect->id)->first();                
            }
            else
            {
                $newEtud = Etudiant::create(["adhesion_id" => $this->adhesionSelect->id, "user_id" => Auth::user()->id, "session_id" => $this->etudiantSession, "level_id" => $this->newEtudiant['level_id']]);
            }
        }
        else
        {
            $this->newEtudiant["numCarte"] = "AF-" .  $categorie_indication[$this->newEtudiant['categorie_id']] . '.' . random_int(100, 9000);
            $newAdhesion = Adhesion::create($this->newEtudiant);
            $newEtud = Etudiant::create(["adhesion_id" => $newAdhesion->id, "user_id" => Auth::user()->id, "session_id" => $this->etudiantSession, "level_id" => $this->newEtudiant['level_id']]);
        }
        
        

        // inclure l'étudiant dans la session
        $newEtud->session()->attach($this->etudiantSession);

        // $newEtud = Etudiant::where('email', $this->newEtudiant['email'])->first();

        if ($this->nscList['examens'] != null) {
            foreach ($this->nscList['examens'] as $examen) {
                if ($examen['active']) {
                    $newEtud->examens()->attach($examen['id']);
                    $idCourOrExam = $examen['id'];
                }
            }
        }
        if ($this->nscList['cours'] != null) {
            foreach ($this->nscList['cours'] as $cour) {
                if ($cour['active']) {
                    $newEtud->cours()->attach($cour['cour_id']);
                    $idCourOrExam = $cour['cour_id'];
                }
            }
        }

        $montant = $this->sessionSelected->montant;

        $inscrOuReinscr = "";
        if ($this->noMember) {
            $inscrOuReinscr = "Adhésion + Inscription";
        } else {
            $inscrOuReinscr = "Inscription";
        }

        $numRecue = Paiement::latest('id')->first() != null ? "AFD" . date('y') . "N°" . str_pad(Paiement::latest('id')->first()->id + 1, 4, "0", STR_PAD_LEFT) : "AFD" . date('y') . "N°" . str_pad(1, 4, "0", STR_PAD_LEFT);

        // Pour la base donné de paiement               
        $paiementData = 
        [
            'montant' => $this->montantInscription,
            'montantRestant' => $this->montantRestant != 0 ? $this->montantRestant : 0,
            'statue' => $this->statue,
            'motif' => $inscrOuReinscr . " du " . $this->newEtudiant['nom'],
            'moyenPaiement' => $this->moyenPaiement,
            'type' => $inscrOuReinscr . ' a un ' . $this->typeInscription,
            'numRecue' => $numRecue,
            'user_id' => Auth::user()->id
        ];
        $paiement = Paiement::create($paiementData);
        $this->paiement_id = $paiement->id;

        // Pour la base donné de inscription
        $inscriValue = 
        [
            'adhesion_id' => $newEtud->adhesion_id,
            // 'session_id' => $this->sessionSelected->id,
            'idCourOrExam' => $idCourOrExam,
            'statut' => $this->montantRestant == 0 ? true : false,
            'type' => $this->typeInscription == "cours" ? "cours" : "examen",
        ];

        $inscription = Inscription::create($inscriValue);
        $inscription->session()->attach($this->sessionSelected->id);
        $inscription->paiements()->attach($this->paiement_id);

        // if ($this->typeInscription == 'cours') {
        //     $inscription->sessions()->attach($this->sessionSelected->id);
        // }

        $this->dispatch("ShowSuccessMsg", ['message' => 'Etudiant enregistrer avec success!', 'type' => 'success']);
        $this->photo = '';
        // $this->bsSteepActive += 1;
    }

    // Creation du pdf pour la reçu de paiement
    public function generatePDF()
    {
        $datas = [
            "etudiant" => Etudiant::find(1),
            "auth" => auth()->user(),
            "paiements" => Paiement::find(1),
        ];

        $pdf = Pdf::loadView('generate-pdf', $datas);
        return $pdf->download('invoice.pdf');
        // return view('/generate-pdf', $datas);
    }

    // Fonction render
    public function render()
    {

        return view('livewire.etudiants.new-etudiant');
    }
}
