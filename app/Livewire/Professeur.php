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
    // Nos importation a utiliser
    use WithFileUploads;
    use WithPagination;

    // Nos variable global
    protected $paginationTheme = "bootstrap";

    public $search;
    public $sectionName = 'list';
    public $photo;
    public $editProfesseur = [];
    public $newProfesseur = [];
    public $editCoursList = ['cours' => []];
    public $orderDirection = 'ASC';
    public $orderField = 'nom';
    public $ProfesseurDeleteid;

    // Nos variable protected
    protected $queryString = [
        'search',
    ];
    protected $listeners = [ "deleteConfirmed"=>'deleteProfesseur' ];

    public function rules()
    {
        if ($this->sectionName == 'new')
        {
            $rule = [
                'photo' => ['image', 'max:1024'],
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
                'photo' => ['image', 'max:1024'],
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
        if ($nameSection == 'edit') 
        {
            $this->photo = '';
            $this->initDataProfesseur($idProfesseur);
            $this->sectionName = $nameSection;
        }
        if ($nameSection == 'list') 
        {
            $this->editProfesseur == [];
            $this->photo = '';
            $this->editCoursList = ['cours' => []];
            $this->sectionName = $nameSection;
        }
        if ($nameSection == 'new') 
        {
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

    
    public function submitNewProfesseur()
    {
        // On recuper le photo s'il y en a.
        $this->validate();
        if ($this->photo != '') {
            $photoName = $this->photo->store('profil', 'public');
            $this->newProfesseur['profil'] = $photoName;
        }
        
        // Verification des validation du formulaire
        
        // Enregistrement du nouveau professeur avec les données valider
        ModelsProfesseur::create($this->newProfesseur);

        // Envoye des notifications pour confirmation que l'enregistrement est avec success et retour vers list
        $this->dispatch("ShowSuccessMsg", ['message' => 'Professeur ajouté avec success!', 'type' => 'success']);
        $this->toogleSectionName('list');
    }

    public function confirmeDeleteProf(ModelsProfesseur $professeur)
    {
        // Recuperer les porfesseur a suprimer et demande au client la confirmation du supresion
        $this->ProfesseurDeleteid = $professeur->id;

        // Envoye des notifications pour la confirmation de suppression
        $this->dispatch("AlertDeleteConfirmModal", ['message' => "êtes-vous sur de suprimer $professeur->nom $professeur->prenom ! dans la liste des professeurs ?", 'type' => 'warning']);
    }
    public function deleteProfesseur()
    {
        // recuperer le proffesseur a suprimer et le desactiver du base de donné
        $Professeurdel = ModelsProfesseur::where('id', $this->ProfesseurDeleteid);
        $Professeurdel->delete();

        // Envoye des notifications que toute est effectué avec success
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
    
    public function updateProfesseur()
    {
        $this->validate();
        // On recuper le photo s'il y en a.
        if ($this->photo != '') {
            $photoName = $this->photo->store('profil', 'public');
            $this->editProfesseur['profil'] = $photoName;
        }


        ModelsProfesseur::find($this->editProfesseur['id'])->update($this->editProfesseur);

        $this->dispatch("ShowSuccessMsg", ['message' => 'Professeur modifier avec success!', 'type' => 'success']);

        $this->toogleSectionName('list');
    }

    public function render()
    {
        $data = [
            "professeurs" => ModelsProfesseur::where("nom", "LIKE", "%{$this->search}%")
                ->orWhere("prenom", "LIKE", "%{$this->search}%")
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate(5)
            ];
            
            
            return view('livewire.professeurs.index', $data)
            ->extends('layouts.mainLayout')
            ->section('content');
    }
}
