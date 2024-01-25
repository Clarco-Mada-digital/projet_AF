<?php

namespace App\Livewire;

use App\Models\Level;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;


#[Layout('layouts.mainLayout')]
class Niveaux extends Component
{
    use WithPagination;

    public string $search = "";

   
    public string $newLevel;
  
    public string $editLevel;
    public string $editLevelId;

    public bool $showNewLevelForm = false;
    public bool $showEditLevelForm = false;

    public $levelDelete;
    protected $listeners = ["deleteConfirmed" => 'deleteLevel'];

    public function toogleFormLevel()
    {
        $this->newLevel = "";
        $this->showNewLevelForm = !$this->showNewLevelForm;
        // dd($this->showNewLevelForm);
    }
    public function toogleEditLevel(Level $editLevel, $open = true)
    {
        if (!$open) {
            $this->showEditLevelForm = false;
        } else {
            $this->showEditLevelForm ? [$this->editLevel = $editLevel->libelle, $this->editLevelId = $editLevel->id] : [$this->editLevel = $editLevel->libelle, $this->editLevelId = $editLevel->id, $this->showEditLevelForm = !$this->showEditLevelForm];
        }
    }

    public function addNewLevel()
    {
        $this->validate(['newLevel'=>['required']], messages:['required'=>'Ce champ est obligatoire !']);

        Level::create(["libelle" => $this->newLevel]);

        $this->dispatch("ShowSuccessMsg", ['message' => 'Creation de niveau avec success!', 'type' => 'success']);

        $this->newLevel = "";
        $this->toogleFormLevel();
    }

    public function submitEditLevel()
    {        
        $levelEdit = Level::where('id', $this->editLevelId);
        $this->validate(['editLevel'=>['required']], messages:['required'=>'Ce champ est obligatoire !']);

        $levelEdit->update(['libelle'=>$this->editLevel]);

        $this->dispatch("ShowSuccessMsg", ['message' => 'Modification de niveau avec success!', 'type' => 'success']);

        $this->editLevel = "";
        $this->showEditLevelForm = false;
    }

    public function confirmeDeleteLevel(Level $LevelDeleted)
    {
        $this->levelDelete = $LevelDeleted->id;

        // Envoyé des notifications pour la confirmation de suppression
        $this->dispatch("AlertDeleteConfirmModal", ['message' => "êtes-vous sur de supprimer $LevelDeleted->nom ! dans la liste des niveau ?", 'type' => 'warning']);
    }
    public function deleteLevel()
    {
        $LevelDeleted = Level::where('id', $this->levelDelete);
        $LevelDeleted->delete();

        // Envoyé des notifications que toute est effectué avec success
        $this->dispatch("ShowSuccessMsg", ['message' => 'Niveau supprimer avec success!', 'type' => 'success']);
    }

    public function render()
    {
        $data = [
            "niveaux" => Level::where("libelle", "LIKE", "%{$this->search}%")
                ->paginate(5)
        ];

        return view('livewire.niveaux.index', $data);
    }
}
