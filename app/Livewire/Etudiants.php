<?php

namespace App\Livewire;

use App\Models\Cour;
use App\Models\Etudiant;
use App\Models\Level;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Etudiants extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = "bootstrap";

    public string $search = "";
    public string $orderField = 'nom';
    public string $orderDirection = 'ASC';
    public $state = 'view';
    public $editEtudiant = [];
    public $newEtudiant = ['profil' => ''];
    public $photo;
    public int $bsSteepActive = 1;

    public $allLevel;
    public $nscList = ["cours" => [], "level" => []];



    protected $queryString = [
        'search' => ['except' => '']
    ];
    

    protected function rules()
    {
        $rule = [
            'editEtudiant.profil' => [''],
            'editEtudiant.nom' => ['required'],
            'editEtudiant.prenom' => 'required',
            'editEtudiant.sexe' => ['required'],
            'editEtudiant.nationalite' => ['required'],
            'editEtudiant.dateNaissance' => ['required'],
            'editEtudiant.profession' => [''],
            'editEtudiant.email' => ['required', 'email', Rule::unique('etudiants', 'email')->ignore($this->editEtudiant['id'])],
            'editEtudiant.telephone1' => ['required'],
            'editEtudiant.telephone2' => [''],
            'editEtudiant.adresse' => ['required'],
            'editEtudiant.numCarte' => [Rule::unique('etudiants', 'numCarte')->ignore($this->editEtudiant['id'])],
            'editEtudiant.user_id' => [''],
            'editEtudiant.level_id' => [''],

        ];

        return $rule;
    }


    public function toogleStateName($stateName)
    {
        if ($stateName == 'view') {
            $this->nscList = ["cours" => [], "level" => []];
            $this->state = 'view';
        }
        if ($stateName == 'edit') {
            $this->state = 'edit';
            $this->populateNscList();
        }
    }

    public function populateNscList()
    {
        // metre la liste de nos cours dans un variable          
        $mapData = function ($value) {
            return $value['id'];
        };

        $cours = array_map($mapData, Etudiant::find($this->editEtudiant['id'])->cours->toArray());

        $this->editEtudiant['level_id'] = Etudiant::find($this->editEtudiant['id'])->level->id;

        foreach (Cour::all() as $cour) {
            if (in_array($cour->id, $cours)) {
                array_push($this->nscList['cours'], ['cour_id' => $cour->id, 'cour_libelle' => $cour->libelle, 'cour_horaire' => $cour->horaire, 'active' => true]);
            } else {
                array_push($this->nscList['cours'], ['cour_id' => $cour->id, 'cour_libelle' => $cour->libelle, 'cour_horaire' => $cour->horaire, 'active' => false]);
            }
        }

        // dd($this->coursList);

    }

    public function initDataEtudiant($id)
    {
        $this->editEtudiant = Etudiant::find($id)->toArray();
        $this->toogleStateName('edit');
    }

    public function submitNewEtudiant()
    {
        $this->newEtudiant['user_id'] = Auth::user()->id;
        $this->newEtudiant['numCarte'] = "AF-" . random_int(100, 9000);
        $photoName = $this->photo->store('photos', 'public');
        $this->newEtudiant['profil'] = $photoName;

        $validateAtributes = $this->validate();

        Etudiant::create($validateAtributes['newEtudiant']);

        // foreach ($this->nscList['cours'] as $cour) {
        //     if ($cour['active']) {
        //         Etudiant::find($this->newEtudiant['nom'])->cours()->attach($cour['cour_id']);
        //     }
        // }

        $this->dispatch("ShowSuccessMsg", ['message' => 'Enregistrement avec success!', 'type' => 'success']);
        $this->photo = '';
    }

    public function updateEtudiant($id)
    {
        if ($this->photo != '') {
            $photoName = $this->photo->store('photos', 'public');
            $this->editEtudiant['profil'] = $photoName;
        }
        $validateAtributes = $this->validate();
        // suprimer les cours appartient au utilisateur au paravant
        DB::table("etudiant_cours")->where("etudiant_id", $this->editEtudiant['id'])->delete();

        Etudiant::find($this->editEtudiant['id'])->update($validateAtributes['editEtudiant']);

        // Ajout des cour au etudiant
        foreach ($this->nscList['cours'] as $cour) {
            if ($cour['active']) {
                Etudiant::find($this->editEtudiant['id'])->cours()->attach($cour['cour_id']);
            }
        }
        // $validateAtributes['editEtudiant']['user_id'] = Auth::user()->profil;

        $this->dispatch("ShowSuccessMsg", ['message' => 'Etudiant modifier avec success!', 'type' => 'success']);
        $this->photo = '';

        $this->toogleStateName('view');
    }

    public function setOrderField(string $name)
    {
        if ($name === $this->orderField) {
            $this->orderDirection = $this->orderDirection === 'ASC' ? 'DESC' : 'ASC';
        } else {
            $this->orderField = $name;
            $this->reset('orderDirection');
        }
    }

    public function render()
    {
        Carbon::setLocale('fr');

        $this->allLevel = Level::all();

        $data = [
            "etudiants" => Etudiant::where("prenom", "LIKE", "%{$this->search}%")
                ->orWhere("nom", "LIKE", "%{$this->search}%")
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate(5)
        ];

        return view('livewire.etudiants.index', $data)
            ->extends('layouts.mainLayout')
            ->section('content');
    }
}
