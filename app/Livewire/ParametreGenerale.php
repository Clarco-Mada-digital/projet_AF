<?php

namespace App\Livewire;

use App\Models\Categorie;
use App\Models\Examen;
use App\Models\Level;
use App\Models\Price;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

#[Layout('layouts.mainLayout')]
class ParametreGenerale extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";
    public string $orderField = 'nom';
    public string $orderFieldLibelle = 'libelle';
    public string $orderDirection = 'ASC';

    public string $searchNiveaux = "";
    public string $searchCategories = "";
    public string $searchTarifs = "";
    public string $searchExamens = "";
    public string $newLevel;
    public string $newCategorie;
    public string $newExamen;
    public string $newTarifs;
    public $dataTarifs = ["level_id" => []];
    public $dataExamens = ["price_id" => ""];
    public $editLevel;
    public $editCategorie;
    public $editTarif;
    public $editExamen;
    public $editLevelId;
    public $editCategorieId;
    public $editTarifId;
    public $editExamenId;
    public string $titleModal = "";
    public string $submitFunction = "";
    public string $champ = "";
    public bool $edit = false;

    public bool $showNewLevelForm = false;
    public bool $showEditLevelForm = false;

    public $levelDelete;
    public $categorieDelete;
    public $tarifDelete;
    public $examenDelete;

    // Emit du js
    protected $listeners = ["deleteConfirmedLevel" => 'deleteLevel', "deleteConfirmedCategorie" => 'deleteCategorie', "deleteConfirmedTarifs" => "deleteTarif", "deleteConfirmedExamens" => "deleteExamen"];

    public $levels;
    public $prices;
    public function __construct()
    {
        $this->levels = Level::all();
        $this->prices = Price::all();
    }

    public function initModal($key)
    {
        $this->edit = false;
        $this->champ = "";
        $this->dataTarifs = ["level_id" => []];
        $this->resetErrorBag();
        $this->titleModal = Str::lower("Nouveau " . $key);

        if ($key == "Niveaux") {
            $this->newLevel = "";
            $this->champ = 'newLevel';
            $this->submitFunction = "addNewLevel";
        } elseif ($key == "Categories") {
            $this->newCategorie = "";
            $this->champ = 'newCategorie';
            $this->submitFunction = "addNewCategorie";
        } elseif ($key == "Tarifs") {
            $this->newTarifs = "";
            $this->champ = 'newTarifs';
            $this->submitFunction = "addNewTarif";
        } elseif ($key == "Examens") {
            $this->newExamen = "";
            $this->champ = 'newExamen';
            $this->submitFunction = "addNewExamen";
        }
    }

    public function editModal($key, $id)
    {
        $this->edit = true;
        $this->champ = "";
        $this->dataTarifs = ["level_id" => []];
        $this->resetErrorBag();
        $this->titleModal = Str::lower("Edit " . $key);

        if ($key == "Niveaux") {
            $this->editLevelId = Level::find($id);
            $this->editLevel = $this->editLevelId->libelle;
            $this->champ = 'editLevel';
            $this->submitFunction = "updateLevel";
        }
        if ($key == "Categories") {
            $this->editCategorieId = Categorie::find($id);
            $this->editCategorie = $this->editCategorieId->libelle;
            $this->champ = 'editCategorie';
            $this->submitFunction = "updateCategorie";
        }
        if ($key == "Tarifs") {
            $this->editTarifId = Price::find($id);
            $this->editTarif = $this->editTarifId->nom;
            $this->champ = 'editTarif';
            $this->dataTarifs = $this->editTarifId->toArray();
            $this->submitFunction = "updateTarif";
        }
        if ($key == "Examens") {
            $this->editExamenId = Examen::find($id);
            $this->editExamen = $this->editExamenId->libelle;
            $this->champ = 'editExamen';
            $this->dataTarifs = $this->editExamenId->toArray();
            $this->submitFunction = "updateExamen";
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

    public function updateLevel()
    {
        $this->validate(['editLevel' => ['required']], messages: ['required' => 'Ce champ est obligatoire !']);

        $this->editLevelId->update(['libelle' => $this->editLevel]);

        $this->dispatch("ShowSuccessMsg", ['message' => 'Edition avec success!', 'type' => 'success']);

        // $this->editLevel = "";
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
            $this->dispatch("AlertDeleteConfirmModal", ['message' => "êtes-vous sur de supprimer " .
                $this->levelDelete->libelle . " ! dans la liste des niveau ?", 'type' => 'warning', 'thinkDelete' => 'Level']);
        }
        if ($typeThinkDeleted == "Categories") {
            $this->categorieDelete = Categorie::find($thinkDeleted);
            // dd($this->levelDelete);
            $this->dispatch("AlertDeleteConfirmModal", ['message' => "êtes-vous sur de supprimer " . $this->categorieDelete->libelle . " ! dans la liste des catégorie ?", 'type' => 'warning', 'thinkDelete' => 'Categorie']);
        }
        if ($typeThinkDeleted == "Tarifs") {
            $this->tarifDelete = Price::find($thinkDeleted);

            if ($thinkDeleted == 1 || $thinkDeleted == 2 || $thinkDeleted == 3) {
                $this->dispatch("showModalSimpleMsg", ['message' => "Vous ne pouvez pas supprimer cette tarification !", 'type' => 'error']);
            } else {
                // dd($this->tarifDelete);
                $this->dispatch("AlertDeleteConfirmModal", ['message' => "êtes-vous sur de supprimer " . $this->tarifDelete->nom . " ! dans la liste des tarification ?", 'type' => 'warning', 'thinkDelete' => 'Tarifs']);
            }
        }
        if ($typeThinkDeleted == "Examens") { 
            $this->examenDelete = Examen::find($thinkDeleted);
            // dd($this->levelDelete);
            $this->dispatch("AlertDeleteConfirmModal", ['message' => "êtes-vous sur de supprimer " . $this->examenDelete->libelle . " ! dans la liste des examens ?", 'type' => 'warning', 'thinkDelete' => 'Examens']);
        }
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

    public function updateCategorie()
    {
        $this->validate(['editCategorie' => ['required']], messages: ['required' => 'Ce champ est obligatoire !']);

        $this->editCategorieId->update(['libelle' => $this->editCategorie]);

        $this->dispatch("ShowSuccessMsg", ['message' => 'Edition avec success!', 'type' => 'success']);

        // $this->editLevel = "";
    }

    public function deleteCategorie()
    {
        // $LevelDeleted = Level::where('id', $this->levelDelete);
        $this->categorieDelete->delete();

        // Envoyé des notifications que toute est effectué avec success
        $this->dispatch("ShowSuccessMsg", ['message' => 'Catégorie supprimer avec success!', 'type' => 'success']);
    }

    // section tarifs
    public function addNewTarif()
    {
        $this->validate(
            [
                'newTarifs' => ['required'],
                'dataTarifs.montant' => ['required'],
            ],
            messages: ['required' => 'Ce champ est obligatoire !']
        );
        $this->dataTarifs['montant'] = str_replace(',', '.', $this->dataTarifs['montant']);
        $this->dataTarifs['nom'] = $this->newTarifs;

        $newTarification = Price::create($this->dataTarifs);

        foreach ($this->dataTarifs['level_id'] as $level) {
            $newTarification->levels()->attach($level);
        }

        $this->dispatch("ShowSuccessMsg", ['message' => 'Creation de tarif avec success!', 'type' => 'success']);

        $this->newTarifs = "";
        $this->dataTarifs = ["level_id" => []];
    }

    public function updateTarif()
    {
        $this->validate(
            [
                'editTarif' => ['required'],
                'dataTarifs.montant' => ['required'],
            ],
            messages: ['required' => 'Ce champ est obligatoire !']
        );

        $this->dataTarifs['montant'] = str_replace(',', '.', $this->dataTarifs['montant']);
        $this->dataTarifs['nom'] = $this->editTarif;
        $this->dataTarifs['level_id'] = $this->editTarifId->levels;

        // supprimer les tarif relier enregistre
        DB::table("price_levels")->where("price_id", $this->editTarifId->id)->delete();

        $this->editTarifId->update($this->dataTarifs);

        foreach ($this->dataTarifs['level_id'] as $level) {
            $this->editTarifId->levels()->attach($level);
        }

        $this->dispatch("ShowSuccessMsg", ['message' => 'Modification avec success!', 'type' => 'success']);

        $this->dataTarifs = ["level_id" => []];
    }

    public function deleteTarif()
    {
        $this->tarifDelete->delete();

        // Envoyé des notifications que toute est effectué avec success
        $this->dispatch("ShowSuccessMsg", ['message' => 'Tarif supprimer avec success!', 'type' => 'success']);
    }

    // section examen
    public function addNewExamen()
    {
        $this->validate(
            [
                'newExamen' => ['required'],
                'dataExamens.price_id' => ['required'],
            ],
            messages: ['required' => 'Ce champ est obligatoire !']
        );
        Examen::create(["libelle" => $this->newExamen, "price_id" => $this->dataExamens['price_id']]);

        $this->dispatch("ShowSuccessMsg", ['message' => 'Creation de examen avec success!', 'type' => 'success']);

        $this->newExamen = "";
        $this->dataExamens = ["price_id" => ""];
    }

    public function updateExamen()
    {
        $this->validate(
            [
                'editExamen' => ['required'],
                'dataExamens.price_id' => ['required'],
            ],
            messages: ['required' => 'Ce champ est obligatoire !']
        );
        $this->editExamenId->update(["libelle" => $this->editExamen, "price_id" => $this->dataExamens['price_id']]);

        $this->dispatch("ShowSuccessMsg", ['message' => 'Modification avec success!', 'type' => 'success']);

        $this->dataExamens = ["price_id" => ""];
    }

    public function deleteExamen()
    {
        $this->examenDelete->delete();

        // Envoyé des notifications que toute est effectué avec success
        $this->dispatch("ShowSuccessMsg", ['message' => 'Examen supprimer avec success!', 'type' => 'success']);

    }

    // function sortField
    public function setOrderField(string $name)
    {

        if ($name === $this->orderField || $name === $this->orderFieldLibelle) {
            $this->orderDirection = $this->orderDirection === 'ASC' ? 'DESC' : 'ASC';
        } else {
            $this->orderField = $name;
            $this->orderFieldLibelle = $name;
            $this->reset('orderDirection');
        }
    }

    public function render()
    {
        $data = [
            "Niveaux" => Level::where("libelle", "LIKE", "%{$this->searchNiveaux}%")
                ->paginate(5),
            "Categories" => Categorie::where('libelle', 'LIKE', "%{$this->searchCategories}%")
                ->paginate(5),
            "Tarifs" => Price::where('nom', 'LIKE', "%{$this->searchTarifs}%")
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate(5),
            "Examens" => Examen::where('libelle', 'LIKE', "%{$this->searchExamens}%")
                ->paginate(5),
        ];
        $datas = [
            "allData" => $data,
        ];
        return view('livewire.parametres.parametre-generale', $datas);
    }
}
