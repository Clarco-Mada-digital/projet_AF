<?php

namespace App\Livewire;

use App\Models\Cour;
use App\Models\Etudiant;
use App\Models\Examen;
use App\Models\Inscription;
use App\Models\Level;
use App\Models\Session;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;

#[Layout('layouts.mainLayout')]
class Etudiants extends Component
{
    use WithPagination;
    use WithFileUploads;

    public string $search = "";
    public string $filteredByLevel = "";
    public string $filteredByCourExamen = "";
    protected $paginationTheme = "bootstrap";

    public string $orderField = 'nom';
    public string $orderDirection = 'ASC';
    public $state = 'view';
    public $editEtudiant = [];
    public $newEtudiant = ['profil' => ''];
    public $photo;
    public $listSession;
    public int $bsSteepActive = 1;
    public $etudiantSession;

    public $dataInscri = [];

    public $allLevel;
    public $nscList = ["cours" => [], "level" => [], "examens" => []];



    protected $queryString = [
        'search' => ['except' => '']
    ];
    // Supprimer les anciens doc dans le ficher temp
    protected function cleanupOldUploads()
    {
        $storage = Storage::disk('local');

        foreach ($storage->allFiles("livewire-tmp") as $pathFileName) {
            if (!$storage->exists($pathFileName)) continue;

            $fiveSecondDel = now()->subSecond(10)->timestamp;

            if ($fiveSecondDel > $storage->lastModified($pathFileName)) {
                $storage->delete($pathFileName);
            }
        }
    }   

    protected function rules()
    {
        $rule = [
            'photo' => ['image', 'max:1024', 'nullable'],
            'editEtudiant.nom' => ['required'],
            'editEtudiant.prenom' => 'required',
            'editEtudiant.sexe' => ['required'],
            'editEtudiant.nationalite' => ['required'],
            'editEtudiant.dateNaissance' => ['required'],
            'editEtudiant.profession' => [''],
            'editEtudiant.email' => ['required', 'email', Rule::unique('etudiants', 'email')->ignore($this->editEtudiant['id'])],
            'editEtudiant.telephone1' => ['required'],
            'editEtudiant.telephone2' => [''],
            'editEtudiant.adresse' => ['required'],
            'editEtudiant.numCarte' => [Rule::unique('etudiants', 'numCarte')->ignore($this->editEtudiant['id'])],
            'editEtudiant.user_id' => [''],
            'editEtudiant.level_id' => [''],

        ];

        return $rule;
    }


    public function toogleStateName($stateName)
    {
        if ($stateName == 'view') {
            $this->nscList = ["cours" => [], "level" => [], "examens" => []];
            $this->state = 'view';
        }
        if ($stateName == 'edit') {
            $this->state = 'edit';
            $this->populateNscList();
        }
        if ($stateName == 'new') {
            // dd(Session::all());
            if (Session::all()->toArray() == null) {
                $this->dispatch("showModalSimpleMsg", ['message' => "Avant d'inscrire un étudiant, soyer sûr qu'il y a de la session active !", 'type' => 'warning']);
            } else {
                return redirect(route('etudiants-nouveau'));
            }
        }
    }

    public function populateNscList()
    {
        // metre la liste de nos cours dans un variable          
        $mapData = function ($value) {
            return $value['id'];
        };

        $cours = array_map($mapData, Etudiant::find($this->editEtudiant['id'])->cours->toArray());
        $examen = array_map($mapData, Etudiant::find($this->editEtudiant['id'])->examens->toArray());

        $this->editEtudiant['level_id'] = Etudiant::find($this->editEtudiant['id'])->level->id;

        foreach (Cour::all() as $cour) {
            if (in_array($cour->id, $cours)) {
                array_push($this->nscList['cours'], ['cour_id' => $cour->id, 'cour_libelle' => $cour->libelle, 'cour_horaire' => $cour->horaire, 'active' => true]);
            } else {
                array_push($this->nscList['cours'], ['cour_id' => $cour->id, 'cour_libelle' => $cour->libelle, 'cour_horaire' => $cour->horaire, 'active' => false]);
            }
        }

        foreach (Examen::all() as $exam) {
            if (in_array($exam->id, $examen)) {
                array_push($this->nscList['examens'], ['examen_id' => $exam->id, 'examen_libelle' => $exam->libelle, 'active' => true]);
            } else {
                array_push($this->nscList['examens'], ['examen_id' => $exam->id, 'examen_libelle' => $exam->libelle, 'active' => false]);
            }
        }

        // dd($this->coursList);

    }

    public function initDataEtudiant($id)
    {
        $this->editEtudiant = Etudiant::find($id)->toArray();
        $this->listSession = Session::all()->toArray();
        $this->etudiantSession = Inscription::where('etudiant_id', $this->editEtudiant['id'])->first()->sessions;
        $cours = $this->etudiantSession->toArray();
        // dd($cours);
        // foreach ($cours as $cour) {
        //     array_push($this->nscList['cours'], ['cour_id' => $cour->id, 'cour_libelle' => $cour->libelle, 'cour_horaire' => $cour->horaire, 'active' => false]);
        // }
        $this->toogleStateName('edit');
    }

    public function updateEtudiant($id)
    {
        $this->validate();
        if ($this->photo != '') {
            $photoName = $this->photo->store('profil', 'public');
            $this->editEtudiant['profil'] = $photoName;

            // $imageName = "profil/". Str::uuid() . $this->editEtudiant['nom'] . "webp";
            // Image::make($this->photo)->save($imageName, 60);
            // $image = Image::make(public_path('storage/'.$photoName))->fit(200, 200);
            // $image->save();
        }
        // suprimer les cours appartient au utilisateur au paravant
        DB::table("etudiant_cours")->where("etudiant_id", $this->editEtudiant['id'])->delete();

        Etudiant::find($this->editEtudiant['id'])->update($this->editEtudiant);

        // Ajout des cour au etudiant
        foreach ($this->nscList['cours'] as $cour) {
            if ($cour['active']) {
                Etudiant::find($this->editEtudiant['id'])->cours()->attach($cour['cour_id']);
            }
        }
        // $validateAtributes['editEtudiant']['user_id'] = Auth::user()->profil;

        $this->dispatch("ShowSuccessMsg", ['message' => 'Etudiant modifier avec success!', 'type' => 'success']);
        $this->photo = '';

        $this->toogleStateName('view');
    }

    public function setOrderField(string $name)
    {
        if ($name === $this->orderField) {
            $this->orderDirection = $this->orderDirection === 'ASC' ? 'DESC' : 'ASC';
        } else {
            $this->orderField = $name;
            $this->reset('orderDirection');
        }
    }

    public function render()
    {
        Carbon::setLocale('fr');

        $this->allLevel = Level::all();

        $etudiants = Etudiant::where(function (Builder $query) {
            $query->where("nom", "LIKE", "%{$this->search}%")
                ->orWhere("prenom", "LIKE", "%{$this->search}%")
                ->orWhere("numCarte", "LIKE", "%{$this->search}%");
            })
            ->where([['level_id', 'LIKE', "%{$this->filteredByLevel}%"]])
            ->paginate(5);

        $data = [
            "etudiants" => $etudiants,
        ];

        return view('livewire.etudiants.index', $data);
    }
}
