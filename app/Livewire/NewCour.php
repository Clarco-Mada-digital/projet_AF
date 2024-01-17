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
    public $newCour = [];
    public $dateInput;
    public $newLevels = [];
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
            'newCour.professeur_id' => ['string'],
        ];

        return $rule;
    }

    // Fonction pour récupérer les heurs du cour
    // public function setDateHourCour()
    // {
    //     if ($this->dateInput == '' || $this->heurDebInput == '' || $this->heurFinInput == ''|| $this->heurDebInput > $this->heurFinInput)
    //     {
    //         $this->dispatch("showModalSimpleMsg", ['message' => "Désolé, quelque chose a mal tourné. Veuillez vérifier les heures que vous avez entrées.", 'type' => 'error']);   
    //         return null;         
    //     }
    //     // Pour une separation dans l'affichage
    //     $dateTimeForma =  $this->dateInput . ' ' . $this->heurDebInput . '-' . $this->heurFinInput;
    //     if($this->dateHeurCour != null){
    //         $this->dateHeurCour .= " | ";
    //     }

    //     // Reset la valeur des inputs
    //     $this->dateHeurCour .= $dateTimeForma;
    //     $this->dateInput = '';
    //     $this->heurDebInput = '';
    //     $this->heurFinInput = '';
    // }

    // // Fonction reset la valeur de Date heur du cour
    // public function resetDateHourCour()
    // {
    //     $this->dateHeurCour = "";
    // }

    // fonction pour l'enregistrement du cour
    public function addNewCour()
    {        
        $this->validate();
        
        // $this->newCour['horaire'] = $this->dateHeurCour;
        
        $myCour = Cour::create($this->newCour);

        if ($this->newLevels != [])
        {
            foreach ($this->newLevels as $level)
            {
                $myCour->level()->attach($level);
            }
        }

        $this->dispatch("ShowSuccessMsg", ['message' => 'Enregistrement avec success!', 'type' => 'success']);
        // $this->newCour = ['horaire'=> ''];
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
