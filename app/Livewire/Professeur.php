<?php

namespace App\Livewire;

use App\Models\Cour;
use App\Models\Professeur as ModelsProfesseur;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Professeur extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $search;
    public $sectionName = 'list';
    public $photo;
    public $editProfesseur = [];
    public $newProfesseur = [];
    public $editCoursList = ['cours' => []];
    public $orderDirection = 'ASC';
    public $orderField = 'nom';
    public $ProfesseurDeleteid;

    protected $queryString = [
        'search',
    ];
    protected $listeners = [ "deleteConfirmed"=>'deleteProfesseur' ];

    public function rules()
    {
        if ($this->sectionName == 'new')
        {
            $rule = [
                'newProfesseur.profil' => [''],
                'newProfesseur.nom' => ['required'],
                'newProfesseur.prenom' => 'required',
                'newProfesseur.sexe' => ['required'],
                'newProfesseur.nationalite' => ['required'],
                'newProfesseur.email' => ['required', 'email', Rule::unique('professeurs', 'email')],
                'newProfesseur.telephone1' => ['required'],
                'newProfesseur.telephone2' => [''],
                'newProfesseur.adresse' => ['required'],
    
            ];
        }
        if ($this->sectionName == 'edit')
        {
            $rule = [
                'editProfesseur.profil' => [''],
                'editProfesseur.nom' => ['required'],
                'editProfesseur.prenom' => 'required',
                'editProfesseur.sexe' => ['required'],
                'editProfesseur.nationalite' => ['required'],
                'editProfesseur.email' => ['required', 'email', Rule::unique('professeurs', 'email')->ignore($this->editProfesseur['id'])],
                'editProfesseur.telephone1' => ['required'],
                'editProfesseur.telephone2' => [''],
                'editProfesseur.adresse' => ['required'],
    
            ];
        }

        return $rule;
    }

    public function toogleSectionName($nameSection, $idProfesseur = null)
    {
        if ($nameSection == 'edit') {
            $this->initDataProfesseur($idProfesseur);
            $this->sectionName = $nameSection;
        }
        if ($nameSection == 'list') {
            $this->editProfesseur == [];
            $this->photo = '';
            $this->editCoursList = ['cours' => []];
            $this->sectionName = $nameSection;
        }
        if ($nameSection == 'new') {
            $this->newProfesseur == [];
            $this->photo = '';
            $this->editCoursList = ['cours' => []];
            $this->sectionName = $nameSection;
        }
    }

    public function initDataProfesseur($professeur)
    {
        // metre la liste de nos cours dans un variable          
        $mapData = function ($value) {
            return $value['id'];
        };

        $this->editProfesseur = ModelsProfesseur::find($professeur)->toArray();
        $cours = array_map($mapData, ModelsProfesseur::find($professeur)->cours->toArray());

        foreach (Cour::all() as $cour) {
            if (in_array($cour->id, $cours)) {
                array_push($this->editCoursList['cours'], ['cour_id' => $cour->id, 'cour_libelle' => $cour->libelle, 'cour_horaire' => $cour->horaire, 'active' => true]);
            } else {
                array_push($this->editCoursList['cours'], ['cour_id' => $cour->id, 'cour_libelle' => $cour->libelle, 'cour_horaire' => $cour->horaire, 'active' => false]);
            }
        }
    }

    public function updateProfesseur()
    {
        // On recuper le photo s'il y en a.
        if ($this->photo != '') {
            $photoName = $this->photo->store('photos', 'public');
            $this->editProfesseur['profil'] = $photoName;
        }

        $validateAtributes = $this->validate();

        ModelsProfesseur::find($this->editProfesseur['id'])->update($validateAtributes['editProfesseur']);

        $this->dispatch("ShowSuccessMsg", ['message' => 'Professeur modifier avec success!', 'type' => 'success']);
        $this->photo = '';

        $this->toogleSectionName('list');
    }

    public function submitNewProfesseur()
    {
        // On recuper le photo s'il y en a.
        if ($this->photo != '') {
            $photoName = $this->photo->store('photos', 'public');
            $this->newProfesseur['profil'] = $photoName;
        }

        $validateAtributes = $this->validate();
        dd($validateAtributes);
    }

    public function confirmeDeleteProf(ModelsProfesseur $professeur)
    {
        $this->ProfesseurDeleteid = $professeur->id;

        $this->dispatch("AlerDeletetConfirmModal", ['message' => "êtes-vous sur de suprimer $professeur->nom $professeur->prenom ! dans la liste des professeurs ?", 'type' => 'warning']);
    }
    public function deleteProfesseur()
    {
        // dd($this->ProfesseurDeleteid);
        $Professeurdel = ModelsProfesseur::where('id', $this->ProfesseurDeleteid);
        $Professeurdel->delete();

        $this->dispatch("ShowSuccessMsg", ['message' => 'Professeur suprimer avec success!', 'type' => 'success']);

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
        $data = [
            "professeurs" => ModelsProfesseur::where("nom", "LIKE", "%{$this->search}%")
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate(5)
        ];


        return view('livewire.professeurs.index', $data)
            ->extends('layouts.mainLayout')
            ->section('content');
    }
}
