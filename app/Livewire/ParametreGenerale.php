<?php

namespace App\Livewire;

use App\Models\Categorie;
use App\Models\Level;
use App\Models\Permission;
use App\Models\Price;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

#[Layout('layouts.mainLayout')]
class ParametreGenerale extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public string $searchNiveaux = "";
    public string $searchCategories = "";
    public string $searchTarifs = "";
    public string $searchPermissions = "";
    public string $newLevel;
    public string $newCategorie;
    public string $editLevel;
    public string $editLevelId;
    public string $titleModal = "";
    public string $submitFunction = "";
    public string $champ = "";

    public bool $showNewLevelForm = false;
    public bool $showEditLevelForm = false;

    public $levelDelete;
    public $categorieDelete;
    protected $listeners = ["deleteConfirmedLevel" => 'deleteLevel', "deleteConfirmedCategorie" => 'deleteCategorie'];

    public $levels;
    public function __construct() {
        $this->levels = Level::all();
    }

    public function initModal($key)
    {
        $this->titleModal = Str::lower("Nouveau ".$key);

        if ($key == "Niveaux")
        {
            $this->newLevel = "";
            $this->champ = 'newLevel';
            $this->submitFunction = "addNewLevel";
        }
        elseif ($key == "Categories")
        {
            $this->newCategorie = "";
            $this->champ = 'newCategorie';
            $this->submitFunction = "addNewCategorie";
        }
        
    }

    public function toogleEditLevel(Level $editLevel, $open = true)
    {
        if (!$open) {
            $this->showEditLevelForm = false;
        } else {
            $this->showEditLevelForm ? [$this->editLevel = $editLevel->libelle, $this->editLevelId = $editLevel->id] : [$this->editLevel = $editLevel->libelle, $this->editLevelId = $editLevel->id, $this->showEditLevelForm = !$this->showEditLevelForm];
        }
    }

    // section niveau 
    public function addNewLevel()
    {
        $this->validate(['newLevel' => ['required']], messages: ['required' => 'Ce champ est obligatoire !']);

        Level::create(["libelle" => $this->newLevel]);

        $this->dispatch("ShowSuccessMsg", ['message' => 'Creation de niveau avec success!', 'type' => 'success']);

        $this->newLevel = "";
    }

    public function submitEditLevel()
    {
        $levelEdit = Level::where('id', $this->editLevelId);
        $this->validate(['editLevel' => ['required']], messages: ['required' => 'Ce champ est obligatoire !']);

        $levelEdit->update(['libelle' => $this->editLevel]);

        $this->dispatch("ShowSuccessMsg", ['message' => 'Modification de niveau avec success!', 'type' => 'success']);

        $this->editLevel = "";
        $this->showEditLevelForm = false;
    }

    public function confirmeDeleteLevel($thinkDeleted, $typeThinkDeleted)
    {
        if ($typeThinkDeleted == "Niveaux") {
            $this->levelDelete = Level::find($thinkDeleted);
            // dd($this->levelDelete);
            $this->dispatch("AlertDeleteConfirmModal", ['message' => "êtes-vous sur de supprimer ".
            $this->levelDelete->libelle." ! dans la liste des niveau ?", 'type' => 'warning', 'thinkDelete' => 'Level']);
        }
        if ($typeThinkDeleted == "Categories") {
            $this->categorieDelete = Categorie::find($thinkDeleted);
            // dd($this->levelDelete);
            $this->dispatch("AlertDeleteConfirmModal", ['message' => "êtes-vous sur de supprimer ".$this->categorieDelete->libelle." ! dans la liste des catégorie ?", 'type' => 'warning', 'thinkDelete' => 'Categorie']);
        }

        // Envoyé des notifications pour la confirmation de suppression
        // $this->dispatch("AlertDeleteConfirmModal", ['message' => "êtes-vous sur de supprimer $LevelDeleted->nom ! dans la liste des niveau ?", 'type' => 'warning']);
    }
    public function deleteLevel()
    {
        // $LevelDeleted = Level::where('id', $this->levelDelete);
        $this->levelDelete->delete();

        // Envoyé des notifications que toute est effectué avec success
        $this->dispatch("ShowSuccessMsg", ['message' => 'Niveau supprimer avec success!', 'type' => 'success']);
    }

    // section catégorie
    public function addNewCategorie()
    {
        $this->validate(['newCategorie' => ['required']], messages: ['required' => 'Ce champ est obligatoire !']);

        Categorie::create(["libelle" => $this->newCategorie]);

        $this->dispatch("ShowSuccessMsg", ['message' => 'Creation de categorie avec success!', 'type' => 'success']);

        $this->newCategorie = "";
    }

    public function deleteCategorie()
    {
        // $LevelDeleted = Level::where('id', $this->levelDelete);
        $this->categorieDelete->delete();

        // Envoyé des notifications que toute est effectué avec success
        $this->dispatch("ShowSuccessMsg", ['message' => 'Catégorie supprimer avec success!', 'type' => 'success']);
    }

    public function render()
    {
        $data = [
            "Niveaux" => Level::where("libelle", "LIKE", "%{$this->searchNiveaux}%")->paginate(5),
            "Categories" => Categorie::where('libelle', 'LIKE', "%{$this->searchCategories}%")->paginate(5),
            "Tarifs" => Price::where('nom', 'LIKE', "%{$this->searchTarifs}%")->paginate(5),
            "Permissions" => Permission::where('nom', 'LIKE', "%{$this->searchPermissions}%")->paginate(5),
        ];
        $datas = [
            "allData" => $data,
        ];
        return view('livewire.parametres.parametre-generale', $datas);
    }
}
