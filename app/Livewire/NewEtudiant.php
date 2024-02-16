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
    public $moyenPaiement = 'Espèce';
    public $paiement_id = 0;
    public $statue = 'Totalement';
    public float $montantInscription = 0;
    public string $typeInscription = "cour";

    public bool $noMember = false;

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
            array_push($this->nscList['examens'], ['id' => $examen->id, 'libelle' => $examen->libelle, 'active' => false]);
        }        

        if ($this->listSession->toArray() == null) {
            $this->dispatch("showModalSimpleMsg", ['message' => "Avant d'inscrire un étudiant, soyer sûr qu'il y a de la session active !", 'type' => 'warning']);
            // return redirect(route('session'));
        }
    }

    // Fonction pour les etape du formulaire de l'enregistrement des étudiants
    public function bsSteepPrevNext($crèment)
    {
        if ($crèment == 'next') {
            if ($this->bsSteepActive == 1) {
                $this->validate();
                $this->bsSteepActive += 1;
                return null;
            } elseif ($this->bsSteepActive == 3) {
                $this->submitNewEtudiant();
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
            'newEtudiant.email' => ['required', 'email'],
            'newEtudiant.telephone1' => ['required'],
            'newEtudiant.telephone2' => [''],
            'newEtudiant.adresse' => ['required'],
            'newEtudiant.numCarte' => [Rule::unique('etudiants', 'numCarte')],
            'newEtudiant.categories' => ['required'],
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
            $this->sessionSelected = Session::find($this->etudiantSession);
            $cours = Session::find($this->etudiantSession)->cours;
            foreach ($cours as $cour) {
                array_push($this->nscList['cours'], ['cour_id' => $cour->id, 'cour_libelle' => $cour->libelle, 'cour_horaire' => $cour->horaire, 'active' => false]);
            }
        }

        // Définir le montant d'inscription
        if ($this->newEtudiant['categories'] == '1') {
            $montantAdhesion = DB::table('prices')->where('id', 1)->value('montant');
        }
        if ($this->newEtudiant['categories'] == '2') {
            $montantAdhesion = DB::table('prices')->where('id', 2)->value('montant');
        }
        if ($this->newEtudiant['categories'] == '3') {
            $montantAdhesion = DB::table('prices')->where('id', 3)->value('montant');
        }

        // pour inscription au cours
        if ($this->sessionSelected != null) {
            if ($this->sessionSelected->montantPromo != null && $this->sessionSelected->dateFinPromo > $this->now) {
                $this->montantInscription = $this->sessionSelected->montantPromo;
            } else {
                $this->montantInscription = $this->sessionSelected->montant;
            }

            $this->noMember ? $this->montantInscription = ($this->montantInscription + $montantAdhesion) : "";
        }
        // pour l'inscription au examen
        if ($this->typeInscription == 'examen') {
            $this->montantInscription = 0;
            if ($this->nscList['examens'] != null) {
                foreach ($this->nscList['examens'] as $examen) {
                    if ($examen['active']) {
                        $examenData = Examen::find($examen['id']);
                        $this->montantInscription += $examenData->price->montant;
                    }
                }
            }
            $this->noMember ? $this->montantInscription = ($this->montantInscription + $montantAdhesion) : "";
        }
    }

    // Enregistrement un nouveau étudiant
    public function submitNewEtudiant()
    {
        $this->newEtudiant['user_id'] = Auth::user()->id;
        $this->newEtudiant['session_id'] = $this->etudiantSession;
        $this->newEtudiant['numCarte'] = "AF-" . random_int(100, 9000);
        $idCourOrExam = null;
        
        $this->validate();
        
        if ($this->photo != '') {
            $photoName = $this->photo->store('profil', 'public');
            $this->newEtudiant['profil'] = $photoName;
        }
        
        
        $newEtud = Etudiant::create($this->newEtudiant);
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
            $inscrOuReinscr = "Inscription";
        } else {
            $inscrOuReinscr = "Reinscription";
        }

        // Pour la base donné de paiement
        $paiementData = [
            'montant' => $this->montantInscription,
            'statue' => $this->statue,
            'motif' => $inscrOuReinscr." du " . $this->newEtudiant['nom'],
            'moyenPaiement' => $this->moyenPaiement,
            'type' => $inscrOuReinscr.' a un ' . $this->typeInscription,
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
        ];

        $inscription = Inscription::create($inscriValue);

        if ($this->typeInscription == 'cour')
        {
            $inscription->sessions()->attach($this->sessionSelected->id);
        }        

        $this->dispatch("ShowSuccessMsg", ['message' => 'Etudiant enregistrer avec success!', 'type' => 'success']);
        $this->photo = '';

        $this->bsSteepActive += 1;
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
