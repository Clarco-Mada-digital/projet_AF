<?php

namespace App\Livewire;

use App\Models\Cour;
use Livewire\Component;
use App\Models\Etudiant;
use App\Models\Inscription;
use App\Models\Level;
use App\Models\Paiement;
use App\Models\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
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
    public $nscList = ["cours" => [], "level" => []];
    public $now;
    public $etudiantSession;
    public $sessionSelected;
    public $moyenPaiement = 'Espèce';
    public $statue = 'Totalement';
    public float $montantInscription;
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
        foreach (Cour::all() as $cour) {
            array_push($this->nscList['cours'], ['cour_id' => $cour->id, 'cour_libelle' => $cour->libelle, 'cour_horaire' => $cour->horaire, 'active' => false]);
        };

        if ($this->listSession->toArray() == null) {
            $this->dispatch("showModalSimpleMsg", ['message' => "Avant d'inscrire un étudiant, soyer sûr qu'il y a de la session active !", 'type' => 'warning']);
            // return redirect(route('session'));
        }
    }

    // Fonction pour les etape du formulaire de l'enregistrement des étudiants
    public function bsSteepPrevNext($crèment)
    {
        if ($crèment == 'next') {
            if ($this->bsSteepActive == 1) 
            {
                $this->validate();
                $this->bsSteepActive += 1;
            }
            elseif ($this->bsSteepActive == 3)
            {
                $this->submitNewEtudiant();
            }
            elseif ($this->bsSteepActive == 4)
            {
                return redirect(route('etudiants-list'));
            }
            else {
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
            'newEtudiant.email' => ['required', 'email', Rule::unique('etudiants', 'email')],
            'newEtudiant.telephone1' => ['required'],
            'newEtudiant.telephone2' => [''],
            'newEtudiant.adresse' => ['required'],
            'newEtudiant.numCarte' => [Rule::unique('etudiants', 'numCarte')],
            'newEtudiant.user_id' => ['integer'],
            'newEtudiant.level_id' => ['integer'],
            'newEtudiant.session_id' => ['integer'],

        ];

        return $rule;
    }

    // Function pour afficher les cours disponible dans la session sélectionnée
    public function updateCoursList()
    {
        if ($this->etudiantSession != null) {
            $this->nscList['cours'] = [];
            $this->sessionSelected = Session::find($this->etudiantSession);
            $cours = Session::find($this->etudiantSession)->cours;
            
            if ($this->newEtudiant['level_id'] != null && $cours != null) {
                foreach ($cours as $cour) {
                    foreach($cour->level as $level) {
                        if ($level->id == $this->newEtudiant['level_id']) {
                            array_push($this->nscList['cours'], ['cour_id' => $cour->id, 'cour_libelle' => $cour->libelle, 'cour_horaire' => $cour->horaire, 'active' => false]);
                        }
                    }
                    // if ($this->newEtudiant['level_id'] in $cour->level_id) {
                    //     array_push($this->nscList['cours'], ['cour_id' => $cour->id, 'cour_libelle' => $cour->libelle, 'cour_horaire' => $cour->horaire, 'active' => false]);
                    //     // dd($this->nscList['cours']);
                    // }
                }

                // $cours = $cour[0]->level_id == $this->newEtudiant['level_id'];
                // dd($cours);
                // dd($cours[0]->level_id);
                // dd($this->newEtudiant['level_id']);

            } else {
                foreach ($cours as $cour) {
                    array_push($this->nscList['cours'], ['cour_id' => $cour->id, 'cour_libelle' => $cour->libelle, 'cour_horaire' => $cour->horaire, 'active' => false]);
                }
            }
        }

        // Définir le montant d'inscription
        if ($this->sessionSelected != null) {
            if ($this->sessionSelected->montantPromo != null && $this->sessionSelected->dateFinPromo > $this->now) {
                $this->montantInscription = $this->sessionSelected->montantPromo;
            } else {
                $this->montantInscription = $this->sessionSelected->montant;
            }

            $this->noMember ? $this->montantInscription = ($this->montantInscription + 10000) : "";
        }
    }

    // Enregistrement un nouveau étudiant
    public function submitNewEtudiant()
    {
        $this->newEtudiant['user_id'] = Auth::user()->id;
        $this->newEtudiant['session_id'] = $this->etudiantSession;
        $this->newEtudiant['numCarte'] = "AF-" . random_int(100, 9000);

        $this->validate();

        if ($this->photo != '') {
            $photoName = $this->photo->store('profil', 'public');
            $this->newEtudiant['profil'] = $photoName;
        }


        $newEtud = Etudiant::create($this->newEtudiant);
        // $newEtud = Etudiant::where('email', $this->newEtudiant['email'])->first();

        foreach ($this->nscList['cours'] as $cour) {
            if ($cour['active']) {
                $newEtud->cours()->attach($cour['cour_id']);
            }
        }
        
        $montant = $this->sessionSelected->montant;
        

        // Pour la base donné de paiement
        $paiementData = [
            'montant' => $this->montantInscription,
            'statue' => $this->statue,
            'motif' => "Inscription du " . $this->newEtudiant['nom'],
            'moyenPaiement' => $this->moyenPaiement,
            'type' => 'Inscription a un '. $this->typeInscription,
            'numRecue' => "AFPN°" . random_int(50, 9000),
            'user_id' => Auth::user()->id
        ];
        $paiement = Paiement::create($paiementData);

        // Pour la base donné de inscription
        $inscriValue = [
            'etudiant_id' => $newEtud->id,
            'paiement_id' => $paiement->id
        ];

        $inscription = Inscription::create($inscriValue);
        $inscription->sessions()->attach($this->sessionSelected->id);

        $this->dispatch("ShowSuccessMsg", ['message' => 'Etudiant enregistrer avec success!', 'type' => 'success']);
        $this->photo = '';

        $this->bsSteepActive += 1;
    }

    // Fonction render
    public function render()
    {
        return view('livewire.etudiants.new-etudiant');
    }
}
