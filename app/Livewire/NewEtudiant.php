<?php

namespace App\Livewire;

use App\Models\Cour;
use Livewire\Component;
use App\Models\Etudiant;
use App\Models\Inscription;
use App\Models\Level;
use App\Models\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;

class NewEtudiant extends Component
{
    use WithFileUploads;

    // ----------- Nos variable --------------
    public $newEtudiant = ['profil' => '', 'level_id'=>''];
    public $photo;
    public int $bsSteepActive = 1;
    public $listSession;
    public $levels;
    public $nscList = ["cours" => [], "level" => []];
    public $now;
    public $etudiantSession;
    public $sessionSelected;
    public $moyenPaiment = 'espece';
    public $statue = 'totale';


    public function __construct()
    {
        $this->now = Carbon::now();
        $this->listSession = Session::all();
        $this->levels = Level::all();
        foreach (Cour::all() as $cour) {
            array_push($this->nscList['cours'], ['cour_id' => $cour->id, 'cour_libelle' => $cour->libelle, 'cour_horaire' => $cour->horaire, 'active' => false]);
        };

        if ($this->listSession->toArray() == null)
            {
                $this->dispatch("showModalSimpleMsg", ['message' => "Avant d'inscrire un étudiant, soyer sûr qu'il y a de la session active !", 'type' => 'warning']);
                // return redirect(route('session'));
            }
    }
    // Fonction pour l'etap du formulaire de l'enregistrement des etudiants
    public function bsSteepPrevNext($crement)
    {
        if ($crement == 'next') {
            if ($this->bsSteepActive == 1) {
                $this->validate();
                $this->bsSteepActive += 1;
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
            'newEtudiant.email' => ['required', 'email', Rule::unique('etudiants', 'email')],
            'newEtudiant.telephone1' => ['required'],
            'newEtudiant.telephone2' => [''],
            'newEtudiant.adresse' => ['required'],
            'newEtudiant.numCarte' => [Rule::unique('etudiants', 'numCarte')],
            'newEtudiant.user_id' => [''],
            'newEtudiant.level_id' => ['integer'],

        ];

        return $rule;
    }

    // Function pour aficher les cours disponible dans la session selectionée
    public function updateCoursList()
    {
        if ($this->etudiantSession != null) {
            $this->nscList['cours'] = [];
            $this->sessionSelected = Session::find($this->etudiantSession);
            $cours = Session::find($this->etudiantSession)->cours;

            if ($this->newEtudiant['level_id'] != null) {
                foreach ($cours as $cour)
                {
                    if ($cour->level_id == $this->newEtudiant['level_id'])
                    {
                        array_push($this->nscList['cours'], ['cour_id' => $cour->id, 'cour_libelle' => $cour->libelle, 'cour_horaire' => $cour->horaire, 'active' => false]);
                        // dd($this->nscList['cours']);
                    }
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
    }

    // Enregistrement un nouveau etudiant
    public function submitNewEtudiant()
    {
        $this->newEtudiant['user_id'] = Auth::user()->id;
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
        // Pour la base donné de inscription
        $montant = $this->sessionSelected->montant;
        $inscriValue = ['montant' => $montant, 'dateInscription' => $this->now, 'moyentPaiement' => $this->moyenPaiment, 'statue' => $this->statue, 'etudiant_id' => $newEtud->id];

        $inscription = Inscription::create($inscriValue);
        $inscription->sessions()->attach($this->sessionSelected->id);

        $this->dispatch("ShowSuccessMsg", ['message' => 'Enregistrement avec success!', 'type' => 'success']);
        $this->photo = '';

        return redirect(route('etudiants-list'));
    }

    // Fonction render
    public function render()
    {
        return view('livewire.etudiants.new-etudiant');
    }
}
