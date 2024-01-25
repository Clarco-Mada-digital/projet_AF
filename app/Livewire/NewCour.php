<?php

namespace App\Livewire;

use App\Models\Categorie;
use App\Models\Cour;
use App\Models\Level;
use App\Models\Professeur;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.mainLayout')]
class NewCour extends Component
{
    // Nos variable global
    public $professeurs;
    public $levels;
    public $categories;
    public $newCour = [];
    public $dateInput;
    public $dateHeurCour;
    public $heurDebInput;
    public $heurFinInput;
    public $newLevels = [];

    // Fonction constructeur
    public function __construct()
    {
        $this->professeurs = Professeur::all()->toArray();
        $this->levels = Level::all()->toArray();
        $this->categories = Categorie::all()->toArray();
    }

    public function rules()
    {
        $rule = [
            'newCour.code' => ['required', 'string'],
            'newCour.libelle' => ['required'],
            'newCour.categorie_id' => ['required'],
            'newCour.salle' => ['string'],
            'newCour.professeur_id' => ['string'],
        ];

        return $rule;
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

    // fonction pour l'enregistrement du cour
    public function addNewCour()
    {        
        $this->validate();
        
        $this->newCour['horaireDuCour'] = $this->dateHeurCour;
        
        $myCour = Cour::create($this->newCour);

        if ($this->newLevels != [])
        {
            foreach ($this->newLevels as $level)
            {
                $myCour->level()->attach($level);
            }
        }

        $this->dispatch("ShowSuccessMsg", ['message' => 'Enregistrement avec success!', 'type' => 'success']);
        return redirect(route('cours-list'));
    }

    // Fonction render de view
    public function render()
    {
        return view('livewire.cours.new-cour');
    }
}
