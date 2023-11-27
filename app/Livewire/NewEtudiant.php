<?php

namespace App\Livewire;

use App\Models\Cour;
use Livewire\Component;
use App\Models\Etudiant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;

class NewEtudiant extends Component
{
    use WithFileUploads;

    public $newEtudiant = ['profil' => ''];
    public $photo;
    public int $bsSteepActive = 1;
    public $nscList = ["cours" => [], "level" => []];


    public function __construct()
    {
        foreach (Cour::all() as $cour) {
            array_push($this->nscList['cours'], ['cour_id' => $cour->id, 'cour_nom' => $cour->nom, 'cour_horaire' => $cour->horaire, 'active' => false]);
        };
    }
    public function bsSteepPrevNext($crement)
    {
        if ($crement == 'next') {
            $this->bsSteepActive += 1;
        } else {
            $this->bsSteepActive -= 1;
        }
    }

    protected function rules()
    {
        $rule = [
            'newEtudiant.profil' => ['string'],
            'newEtudiant.nom' => ['required'],
            'newEtudiant.prenom' => 'required',
            'newEtudiant.sexe' => ['required'],
            'newEtudiant.nationalite' => ['required'],
            'newEtudiant.dateNaissance' => ['required'],
            'newEtudiant.profession' => [''],
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

    public function submitNewEtudiant()
    {
        $this->newEtudiant['user_id'] = Auth::user()->id;
        $this->newEtudiant['numCarte'] = "AF-" . random_int(100, 9000);
        $photoName = $this->photo->store('photos', 'public');
        $this->newEtudiant['profil'] = $photoName;

        $validateAtributes = $this->validate();

        $newEtud = Etudiant::create($validateAtributes['newEtudiant']);
        // $newEtud = Etudiant::where('email', $this->newEtudiant['email'])->first();

        foreach ($this->nscList['cours'] as $cour) {
            if ($cour['active']) {
                $newEtud->cours()->attach($cour['cour_id']);
            }
        }

        $this->dispatch("ShowSuccessMsg", ['message' => 'Enregistrement avec success!', 'type' => 'success']);
        $this->photo = '';

        return redirect(route('etudiants-list'));
    }

    public function render()
    {
        return view('livewire.etudiants.new-etudiant');
    }
}
