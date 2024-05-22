<?php

namespace App\Livewire;

use App\Models\Categorie;
use App\Models\Cour;
use App\Models\Etudiant;
use App\Models\Level;
use App\Models\Professeur;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;


#[Layout('layouts.mainLayout')]
class Cours extends Component
{
    use WithPagination;

    protected $paginationTheme = "bootstrap";
    protected $listeners = ["deleteConfirmed" => 'deleteCour'];

    public string $search = "";
    public $salles;
    public $state = 'view';
    public $professeurs;
    public $levels;
    public $categories;
    public $editCour = ['levels' => []];
    public $dateInput;
    public $dateHeurCour;
    public $heurDebInput;
    public $heurFinInput;
    public $courDelete;
    public $viewListStudent = False;
    public $studentListAdd = False;
    public $studentList = [];
    public $eutdiantCours;

    // Fonction constructeur
    public function __construct()
    {
        $this->professeurs = Professeur::all()->toArray();
        $this->levels = Level::all()->toArray();
        $this->categories = Categorie::all()->toArray();
        $this->salles = ['Salle 01', 'Salle 02', 'Salle 03', 'Salle 04','Salle 05','Salle 06','Salle 07','Salle 08','Salle 09','Salle 10', 'Salle de réunion', 'Salle de spectacle', 'Médiathèque', 'Hall'];
    }

    public function rules()
    {
        $rule = [
            'editCour.code' => ['required'],
            'editCour.libelle' => ['required'],
            'editCour.categorie_id' => ['required'],
            'editCour.salle' => ['string'],
            'editCour.horaire' => ['string'],
            'editCour.professeur_id' => ['required'],

        ];

        return $rule;
    }

    public function toogleStudentListAdd()
    {
        $this->studentListAdd =!$this->studentListAdd;
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
        if ($stateName == 'list') {
            $this->state = 'list';
        }
    }

    public function initStudentList($value, $cour)
    {
        if($value == "True"){$this->viewListStudent = True; }else{$this->viewListStudent = False;}
        // $cour = Cour::find($cour);
        $this->eutdiantCours = Etudiant::with("session")->get(); 
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

        // dd($this->editCour);
        $this->editCour['horaireDuCour'] = $this->dateHeurCour;
        Cour::find($this->editCour['id'])->update($this->editCour);
        $this->dispatch("ShowSuccessMsg", ['message' => 'Cour modifier avec success!', 'type' => 'success']);
        
        $this->toogleStateName('view');
    }

    public function addStudentCours(Cour $cour)
    {
        foreach ($this->studentList as $student)
        {            
            $etudiant = Etudiant::find($student);
            $stydentInCours =[];
            foreach($cour->etudiants as $student)
            {
                array_push($stydentInCours, $student->id);
            }
            if(!in_array($etudiant->id, $stydentInCours))
            {
                $etudiant->cours()->attach($cour->id);                
            }
        
        }
        $this->dispatch("ShowSuccessMsg", ['message' => 'Etudiant ajouter avec success!', 'type' => 'success']);
    }

    public function removeToCours(Cour $cour, Etudiant $student)
    {
        $cour->etudiants()->detach($student);
        $this->dispatch("ShowSuccessMsg", ['message' => 'Etudiant supprimer avec success!', 'type' => 'success']);
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

        return view('livewire.cours.index', $data);
    }
}
