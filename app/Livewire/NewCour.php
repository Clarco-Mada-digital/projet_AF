<?php

namespace App\Livewire;

use App\Models\Cour;
use App\Models\Level;
use App\Models\Professeur;
use Illuminate\Validation\Rule;
use Livewire\Component;


class NewCour extends Component
{
    // Nos variable global
    public $professeurs;
    public $levels;
    public $newCour = ['horaire'=>''];
    public $dateInput;
    public $heurDebInput;
    public $heurFinInput;
    public $dateHeurCour;

    public function __construct()
    {
        $this->professeurs = Professeur::all()->toArray();
        $this->levels = Level::all()->toArray();
    }

    public function rules()
    {
        $rule = [
            'newCour.code' => ['required', 'string', Rule::unique('cours', 'code')],
            'newCour.libelle' => ['required'],
            'newCour.categorie' => ['required'],
            'newCour.salle' => ['string'],
            'dateHeurCour' => ['required'],
            'newCour.professeur_id' => ['required'],
            'newCour.level_id' => ['required']

        ];

        return $rule;
    }

    // Fonction pour recuperer les heurs du cour
    public function setDateHourCour()
    {
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

    // fonction pour l'enregistrement du cour
    public function addNewCour()
    {        
        $this->validate();
        
        $this->newCour['horaire'] = $this->dateHeurCour;
        
        Cour::create($this->newCour);

        $this->dispatch("ShowSuccessMsg", ['message' => 'Enregistrement avec success!', 'type' => 'success']);
        $this->newCour = ['horaire'=> ''];
        return redirect(route('cours-list'));
    }

    // Fonction render de view
    public function render()
    {
        return view('livewire.cours.new-cour')
            ->extends('layouts.mainLayout')
            ->section('content');
    }
}
