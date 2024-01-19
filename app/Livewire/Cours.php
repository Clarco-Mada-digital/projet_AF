<?php

namespace App\Livewire;

use App\Models\Cour;
use App\Models\Level;
use App\Models\Professeur;
use Livewire\Component;
use Livewire\WithPagination;

class Cours extends Component
{
    use WithPagination;

    protected $paginationTheme = "bootstrap";
    protected $listeners = ["deleteConfirmed" => 'deleteCour'];

    public string $search = "";
    public $state = 'view';
    public $professeurs;
    public $levels;
    public $editCour = ['levels' => []];
    public $dateInput;
    public $dateHeurCour;
    public $heurDebInput;
    public $heurFinInput;
    public $courDelete;

    // Fonction constructeur
    public function __construct()
    {
        $this->professeurs = Professeur::all()->toArray();
        $this->levels = Level::all()->toArray();
    }

    public function rules()
    {
        $rule = [
            'editCour.code' => ['required'],
            'editCour.libelle' => ['required'],
            'editCour.categorie' => ['required'],
            'editCour.salle' => ['string'],
            'editCour.horaire' => ['string'],
            'editCour.professeur_id' => ['required'],

        ];

        return $rule;
    }

    public function toogleStateName($stateName)
    {
        if ($stateName == 'view') {
            $this->editCour = [];
            $this->state = 'view';
        }
        if ($stateName == 'edit') {
            $this->state = 'edit';
        }
    }

    // Fonction pour initialiser la valeur du cours
    public function initEditCour($id)
    {
        $this->editCour = Cour::find($id)->toArray();
        $this->dateHeurCour = $this->editCour['horaireDuCour'];
        $this->editCour['levels'] = Cour::find($id)->level->toArray();
        $newTable = [];
        foreach ($this->editCour['levels'] as $level)
        {
            array_push($newTable, $level['id']);
        }
        $this->editCour['levels'] = $newTable;
        $this->toogleStateName('edit');
    }

    // Fonction pour récupérer les heurs du cour
    public function setDateHourCour()
    {
        if ($this->dateInput == '' || $this->heurDebInput == '' || $this->heurFinInput == ''|| $this->heurDebInput > $this->heurFinInput)
        {
            $this->dispatch("showModalSimpleMsg", ['message' => "Désolé, quelque chose a mal tourné. Veuillez vérifier les heures que vous avez entrées.", 'type' => 'error']);   
            return null;         
        }
        // Pour une separation dans l'affichage
        $dateTimeForma =  $this->dateInput . ' ' . $this->heurDebInput . '-' . $this->heurFinInput;
        if($this->dateHeurCour != null){
            $this->dateHeurCour .= " | ";
        }

        // Reset la valeur des inputs
        $this->dateHeurCour .= $dateTimeForma;
        $this->dateInput = '';
        $this->heurDebInput = '';
        $this->heurFinInput = '';
    }

    // Fonction reset la valeur de Date heur du cour
    public function resetDateHourCour()
    {
        $this->dateHeurCour = "";
    }

    // Fonction pour mise a jour du cours
    public function updateCour()
    {
        $this->validate();

        $this->editCour['horaireDuCour'] = $this->dateHeurCour;
        Cour::find($this->editCour['id'])->update($this->editCour);
        $this->dispatch("ShowSuccessMsg", ['message' => 'Cour modifier avec success!', 'type' => 'success']);
        
        $this->toogleStateName('view');
    }

    // Fonction pour supprimer le niveau
    public function confirmeDeleteLevel(Level $courDeleted)
    {
        $this->courDelete = $courDeleted->id;

        // Envoyé des notifications pour la confirmation de suppression
        $this->dispatch("AlertDeleteConfirmModal", ['message' => "êtes-vous sur de supprimer $courDeleted->nom ! dans la liste des niveau ?", 'type' => 'warning']);
    }
    // Fonction pour supprimer le niveau
    public function deleteCour()
    {
        $courDeleted = Cour::where('id', $this->courDelete);
        $courDeleted->delete();

        // Envoyé des notifications que toute est effectué avec success
        $this->dispatch("ShowSuccessMsg", ['message' => 'Niveau supprimer avec success!', 'type' => 'success']);
    }

    public function render()
    {
        $data = [
            "cours" => Cour::where("libelle", "LIKE", "%{$this->search}%")
                ->orWhere("code", "LIKE", "%{$this->search}%")
                ->paginate(5)
        ];

        return view('livewire.cours.index', $data)
            ->extends('layouts.mainLayout')
            ->section('content');
    }
}
