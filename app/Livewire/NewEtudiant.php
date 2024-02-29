<?php

namespace App\Livewire;

use App\Models\Categorie;
use App\Models\Cour;
use Livewire\Component;
use App\Models\Etudiant;
use App\Models\Examen;
use App\Models\Inscription;
use App\Models\Level;
use App\Models\Paiement;
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
    public $newEtudiant = ['profil' => '', 'level_id' => '1'];
    public $photo;
    public int $bsSteepActive = 1;
    public $listSession;
    public $levels;
    public $categories;
    public $nscList = ["cours" => [], "level" => [], "examens" => []];
    public $now;
    public $etudiantSession;
    public $sessionSelected;
    public $moyenPaiement;
    public $paiement_id = 0;
    public $statue;
    public float $montantInscription = 0;
    public float $montantAdhesion;
    public float $montantExam = 0;
    public float $montantPaye = 0;
    public float $montantRestant;
    public string $typeInscription = "cour";

    public bool $noMember = false;
    public bool $MemberPmb = false;

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
        $this->listSession = Session::all();
        $this->levels = Level::all();
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

    public function initData(Etudiant $etudiant)
    {
        $this->search = "";
        $this->newEtudiant = $etudiant->toArray();
        $this->reset("noMember");
        $this->MemberPmb = true;
    }

    public function updatedSearch()
    {
        // $this->reset($this->memberResult);

        $this->memberResult = Etudiant::where("nom", "LIKE", "%{$this->search}%")
            ->orWhere("prenom", "LIKE", "%{$this->search}%")
            ->orWhere("numCarte", "LIKE", "%{$this->search}%")
            ->get();
    }

    // Fonction pour les etape du formulaire de l'enregistrement des étudiants
    public function bsSteepPrevNext($crèment)
    {
        if ($crèment == 'next') {
            if ($this->bsSteepActive == 1) {
                $this->MemberPmb ? "" : $this->validate();
                $this->bsSteepActive += 1;
                return null;
            } elseif ($this->bsSteepActive == 3) {
                if ($this->statue == "" || $this->moyenPaiement == "") {
                    $this->dispatch("showModalSimpleMsg", ['message' => "Veuillez sélectionner le statut et le moyen de paiement", 'type' => 'warning']);
                } else {
                    $this->submitNewEtudiant();
                    $this->bsSteepActive += 1;
                }
                return null;
            } elseif ($this->bsSteepActive == 4) {
                return redirect(route('etudiants-list'));
            } else {
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
            'newEtudiant.nationalite' => ['required'],
            'newEtudiant.dateNaissance' => ['required'],
            'newEtudiant.profession' => ['nullable'],
            'newEtudiant.email' => ['email'],
            'newEtudiant.telephone1' => ['min:10', 'max:10', 'nullable'],
            'newEtudiant.telephone2' => ['min:10', 'max:10', 'nullable'],
            'newEtudiant.adresse' => ['required'],
            'newEtudiant.numCarte' => [Rule::unique('etudiants', 'numCarte')],
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

    public function updateMontant()
    {
        $this->montantAdhesion = DB::table('prices')->where('id', $this->newEtudiant['categorie_id'])->value('montant');

        // pour inscription au cours
        if ($this->sessionSelected != null) {
            if ($this->sessionSelected->montantPromo != null && $this->sessionSelected->dateFinPromo > $this->now) {
                $this->montantInscription = $this->sessionSelected->montantPromo;
            } else {
                $this->montantInscription = $this->sessionSelected->montant;
            }

            $this->noMember ? $this->montantInscription = ($this->montantInscription + $this->montantAdhesion) : "";
        }
        // pour l'inscription au examen
        if ($this->typeInscription == 'examen') {
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
            $this->noMember ? $this->montantInscription = ($this->montantInscription + $this->montantAdhesion) : "";
        }

        $this->updateMontantRestant();
    }

    public function updateMontantRestant()
    {
        if ($this->montantPaye > $this->montantInscription) {
            $this->dispatch("showModalSimpleMsg", ['message' => "Montant payé supérieur au montant de l'inscription", 'type' => 'warning']);
            $this->montantPaye = 0;
        }
        $this->montantRestant = 0;
        $this->montantRestant = $this->montantInscription - $this->montantPaye;
    }

    // Enregistrement un nouveau étudiant
    public function submitNewEtudiant()
    {
        $this->newEtudiant['user_id'] = Auth::user()->id;
        $this->newEtudiant['session_id'] = $this->etudiantSession;
        $this->newEtudiant['numCarte'] = "AF-" . random_int(100, 9000);
        $idCourOrExam = null;

        $this->MemberPmb ? "" : $this->validate();

        if ($this->photo != '') {
            $photoName = $this->photo->store('profil', 'public');
            $this->newEtudiant['profil'] = $photoName;
        }


        $this->MemberPmb ? $newEtud = Etudiant::find($this->newEtudiant['id'])  : $newEtud = Etudiant::create($this->newEtudiant);
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

        // Pour la base donné de paiement               
        $paiementData = [
            'montant' => $this->montantInscription,
            'montantRestant' => $this->montantRestant != 0 ? $this->montantRestant : 0,
            'statue' => $this->statue,
            'motif' => $inscrOuReinscr . " du " . $this->newEtudiant['nom'],
            'moyenPaiement' => $this->moyenPaiement,
            'type' => $inscrOuReinscr . ' a un ' . $this->typeInscription,
            'numRecue' => "AFPN°" . random_int(50, 9000),
            'user_id' => Auth::user()->id
        ];
        $paiement = Paiement::create($paiementData);
        $this->paiement_id = $paiement->id;

        // Pour la base donné de inscription
        $inscriValue = [
            'etudiant_id' => $newEtud->id,
            'paiement_id' => $paiement->id,
            'idCourOrExam' => $idCourOrExam,
            'statut' => $this->montantRestant == 0 ? true : false,
            'type' => $this->typeInscription == "cour" ? "cours" : "examen",
        ];

        $inscription = Inscription::create($inscriValue);

        if ($this->typeInscription == 'cour') {
            $inscription->sessions()->attach($this->sessionSelected->id);
        }

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
