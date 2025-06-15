<?php

namespace App\Livewire;

use App\Models\Categorie;
use App\Models\Cour;
use App\Models\Etudiant;
use App\Models\Level;
use App\Models\Professeur;
use App\Models\Salle;
use Illuminate\Support\Facades\Storage;
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
    public $exportType;
    public $newSalleName;
    public $newSalleDescription;

    // Fonction constructeur
    public function __construct()
    {
        $this->professeurs = Professeur::all()->toArray();
        $this->levels = Level::all()->toArray();
        $this->categories = Categorie::all()->toArray();
        $this->salles = Salle::all()->toArray();
    }

    public function rules()
    {
        $rule = [
            'editCour.code' => ['required'],
            'editCour.libelle' => ['required'],
            'editCour.categorie_id' => ['required'],
            'editCour.salle_id' => ['required'],
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

    /**
     * Ajoute une nouvelle salle depuis le modal
     */
    public function addNewSalle()
    {
        $this->validate([
            'newSalleName' => 'required|string|max:255|unique:salles,nom',
            'newSalleDescription' => 'nullable|string',
        ]);

        $salle = Salle::create([
            'nom' => $this->newSalleName,
            'description' => $this->newSalleDescription,
        ]);

        // Mettre à jour la liste des salles
        $this->salles = Salle::orderBy('id')->get()->toArray();
        
        // Sélectionner automatiquement la nouvelle salle
        $this->editCour['salle_id'] = $salle->id;

        // Émettre un événement pour fermer le modal
        $this->dispatch('salleAdded');

        // Reset la valeur des inputs
        $this->newSalleName = '';
        $this->newSalleDescription = '';
        
        $this->dispatch("ShowSuccessMsg", ['message' => 'La salle a été ajoutée avec succès!', 'type' => 'success']);
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

    // Fonction pour exporter la liste des étudiants
    public function exportStudentList($courId)
    {
        $cour = Cour::findOrFail($courId);
        $students = $cour->etudiants;
        
        $data = [];
        foreach ($students as $student) {
            $data[] = [
                'id' => $student->id,
                'nom' => $student->adhesion->nom,
                'prenom' => $student->adhesion->prenom,
                'niveau' => $student->level->libelle
            ];
        }

        switch ($this->exportType) {
            case 'csv':
                return $this->exportAsCsv($data, $cour);
                break;
            case 'text':
                return $this->exportAsText($data, $cour);
                break;
            case 'pdf':
                return $this->exportAsPdf($data, $cour);
                break;
            case 'md':
                return $this->exportAsMarkdown($data, $cour);
                break;
            default:
                return $this->exportAsCsv($data, $cour);
        }
    }

    private function exportAsCsv($data, $cour)
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="students_' . $cour->id . '_' . $cour->libelle . '_' . now()->format('Y-m-d') . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            
            // Headers
            fputcsv($file, ['ID', 'Nom', 'Prénom', 'Niveau']);
            
            // Data
            foreach ($data as $row) {
                fputcsv($file, [
                    $row['id'],
                    $row['nom'],
                    $row['prenom'],
                    $row['niveau']
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportAsText($data, $cour)
    {
        $content = "Liste des étudiants - Cours ID: {$cour->id}({$cour->libelle})\n\n";
        $content .= "ID\tNom\tPrénom\tNiveau\n";
        $content .= str_repeat("-", 50) . "\n";
        foreach ($data as $row) {
            $content .= "{$row['id']}\t{$row['nom']}\t{$row['prenom']}\t{$row['niveau']}\n";
        }
        
        $filename = "students_{$cour->id}_{$cour->libelle}".now()->format('Y-m-d').".txt";

         // Créer le fichier temporairement
         Storage::put("temp/{$filename}", $content);
        
         // Télécharger et supprimer
         return Storage::download("temp/{$filename}", $filename, [
             'Content-Type' => 'text/plain',
         ]);
    }

    private function exportAsMarkdown($data, $cour)
    {
        $content = "# Liste des étudiants - Cours ID: {$cour->id}({$cour->libelle})\n\n";
        $content .= "| ID | Nom | Prénom | Niveau |\n";
        $content .= "| --- | --- | --- | --- |\n";
        foreach ($data as $row) {
            $content .= "| {$row['id']} | {$row['nom']} | {$row['prenom']} | {$row['niveau']} |\n";
        }
        
        $filename = "students_{$cour->id}_{$cour->libelle}".now()->format('Y-m-d').".md";
        
        // Créer le fichier temporairement
        Storage::put("temp/{$filename}", $content);
        
        // Télécharger et supprimer
        return Storage::download("temp/{$filename}", $filename, [
            'Content-Type' => 'text/markdown',
        ]);
    }

    private function exportAsPdf($data, $cour)
    {
        // La génération PDF nécessite l'installation de mPDF ou DomPDF
        // Pour l'instant, on redirige vers le format CSV par défaut
        return $this->exportAsCsv($data, $cour);
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
