<?php

namespace App\Livewire;

use App\Models\Categorie;
use App\Models\Examen;
use App\Models\Level;
use App\Models\Price;
use App\Models\Session;
use App\Models\Salle;
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
    public string $searchSalles = "";
    public string $newLevel;
    public string $newCategorie;
    public string $newExamen;
    public string $newTarifs;
    public string $newSalles;
    public string $descSalle;
    public $dataTarifs = ["level_id" => []];
    public $dataExamens = ["price_id" => ""];
    public $editLevel;
    public $editCategorie;
    public $editTarif;
    public $editExamen;
    public $editSalle;
    public $editLevelId;
    public $editCategorieId;
    public $editTarifId;
    public $editExamenId;
    public $editSalleId;
    public string $editDescSalle;
    public string $titleModal = "";
    public string $submitFunction = "";
    public string $champ = "";
    public bool $edit = false;

    public bool $showNewLevelForm = false;
    public bool $showEditLevelForm = false;

    public $categories;
    public bool $typeTarif = false;
    public $levelDelete;
    public $categorieDelete;
    public $tarifDelete;
    public $examenDelete;
    public $salleDelete;

    // Emit du js
    protected $listeners = ["deleteConfirmedLevel" => 'deleteLevel', "deleteConfirmedCategorie" => 'deleteCategorie', "deleteConfirmedTarifs" => "deleteTarif", "deleteConfirmedExamens" => "deleteExamen", "deleteConfirmedSalles" => "deleteSalle"];

    public $levels;
    public $sessions;
    public $prices;
    public function __construct()
    {
        $this->levels = Level::all();
        $this->sessions = Session::where("statue", "=", "1")->where("type", "=", "examens")->get();
        $this->prices = Price::all();
        $this->categories = Categorie::all();
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
        } elseif ($key == "Salles") {
            $this->newSalle = "";
            $this->champ = 'newSalles';
            $this->submitFunction = "addNewSalle";
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
            $this->sessions = Session::where("statue", "=", "1")->where("type", "=", "examens")->get();
            $this->editExamenId = Examen::find($id);
            $this->editExamen = $this->editExamenId->libelle;
            $this->champ = 'editExamen';
            $this->dataExamens = $this->editExamenId->toArray();
            $this->submitFunction = "updateExamen";
        }
        if ($key == "Salles") {
            $this->editSalleId = Salle::find($id);
            $this->editSalle = $this->editSalleId->nom;
            $this->champ = 'editSalle';
            $this->editDescSalle = $this->editSalleId->description;
            $this->submitFunction = "updateSalle";
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
        if ($typeThinkDeleted == "Salles") { 
            $this->salleDelete = Salle::withCount('cours')->find($thinkDeleted);
            
            if ($this->salleDelete->cours_count > 0) {
                $this->dispatch("showModalSimpleMsg", [
                    'message' => "Impossible de supprimer cette salle car elle est utilisée dans " . $this->salleDelete->cours_count . " cours.", 
                    'type' => 'error'
                ]);
                return;
            }
            
            $this->dispatch("AlertDeleteConfirmModal", [
                'message' => "Êtes-vous sûr de vouloir supprimer la salle " . $this->salleDelete->nom . " ?", 
                'type' => 'warning', 
                'thinkDelete' => 'Salles'
            ]);
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

        if (!$this->typeTarif)
        {
            foreach ($this->dataTarifs['level_id'] as $level) {
                $newTarification->levels()->attach($level);
            }
        }
        else
        {
            foreach ($this->dataTarifs['categorie_id'] as $categorie) {
                $newTarification->categories()->attach($categorie);
            }
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
        // $this->dataTarifs['level_id'] = $this->editTarifId->levels;

        // supprimer les tarif relier enregistre
        DB::table("price_levels")->where("price_id", $this->editTarifId->id)->delete();

        $this->editTarifId->update($this->dataTarifs);

        // Vérifier si 'level_id' existe et n'est pas vide
        if (array_key_exists('level_id', $this->dataTarifs) && !empty($this->dataTarifs['level_id'])) {
            foreach ($this->dataTarifs['level_id'] as $level) {
                $this->editTarifId->levels()->attach($level);
            }
        }

        // Vérifier si 'categorie_id' existe et n'est pas vide
        if (array_key_exists('categorie_id', $this->dataTarifs) && !empty($this->dataTarifs['categorie_id'])) {
            // ajouter un code pour supprimer tous les encien valeur
            $this->editTarifId->categories()->sync($this->dataTarifs['categorie_id']);
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

    public function changeTypeTarif()
    {
        if ($this->typeTarif)
        {$this->dataTarifs['level_id'] = [];}
        else
        {$this->dataTarifs['categorie_id'] = null;}
    }

    // section examen
    public function addNewExamen()
    {
        // dd($this->dataExamens['session_id']);
        $this->validate(
            [
                'newExamen' => ['required'],
                'dataExamens.price_id' => ['required'],
                'dataExamens.level_id' => ['required'],
                'dataExamens.session_id' => ['required'],
            ],
            messages: ['required' => 'Ce champ est obligatoire !']
        );
        Examen::create(["libelle" => $this->newExamen, "price_id" => $this->dataExamens['price_id'], "level_id" => $this->dataExamens['level_id'], "session_id" => $this->dataExamens['session_id']]);

        $this->dispatch("ShowSuccessMsg", ['message' => 'Creation de examen avec success!', 'type' => 'success']);

        $this->newExamen = "";
        $this->dataExamens = ["price_id" => ""];
        $this->dataExamens = ["level_id" => ""];
    }

    public function updateExamen()
    {
        $this->validate(
            [
                'editExamen' => ['required'],
                'dataExamens.price_id' => ['required'],
                'dataExamens.level_id' => ['required'],
            ],
            messages: ['required' => 'Ce champ est obligatoire !']
        );
        $this->editExamenId->update(["libelle" => $this->editExamen, "price_id" => $this->dataExamens['price_id'], "level_id" => $this->dataExamens['level_id'], "session_id" => $this->dataExamens['session_id']]);

        $this->dispatch("ShowSuccessMsg", ['message' => 'Modification avec success!', 'type' => 'success']);

        $this->dataExamens = ["price_id" => ""];
    }

    public function deleteExamen()
    {
        $this->examenDelete->delete();

        // Envoyé des notifications que toute est effectué avec success
        $this->dispatch("ShowSuccessMsg", ['message' => 'Examen supprimer avec success!', 'type' => 'success']);

    }

    //section salle
    public function addNewSalle()
    {
        $this->validate(['newSalles' => ['required']], messages: ['required' => 'Ce champ est obligatoire !']);

        Salle::create(["nom" => $this->newSalles, "description" => $this->descSalle]);

        $this->dispatch("ShowSuccessMsg", ['message' => 'Creation de salle avec success!', 'type' => 'success']);

        $this->newSalles = "";
        $this->descSalle = "";
    }

    public function updateSalle()
    {
        $this->validate(['editSalle' => ['required']], messages: ['required' => 'Ce champ est obligatoire !']);

        $this->editSalleId->update(['nom' => $this->editSalle, "description" => $this->editDescSalle]);

        $this->dispatch("ShowSuccessMsg", ['message' => 'Modification avec success!', 'type' => 'success']);

        $this->editSalle = "";
    }

    public function deleteSalle()
    {
        $this->salleDelete->delete();

        // Envoyé des notifications que toute est effectué avec success
        $this->dispatch("ShowSuccessMsg", ['message' => 'Salle supprimer avec success!', 'type' => 'success']);
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
            "Salles" => Salle::where('nom', 'LIKE', "%{$this->searchSalles}%")
                ->paginate(5),
        ];
        $datas = [
            "allData" => $data,
        ];
        return view('livewire.parametres.parametre-generale', $datas);
    }
}
