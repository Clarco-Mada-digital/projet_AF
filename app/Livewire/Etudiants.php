<?php

namespace App\Livewire;

use App\Models\Adhesion;
use App\Models\Cour;
use App\Models\Etudiant;
use App\Models\Examen;
use App\Models\Inscription;
use App\Models\Level;
use App\Models\Paiement;
use App\Models\Session;
use Carbon\Carbon;
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
    public string $filteredBySessions = "";
    public string $filteredByPaiement = "";
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
    public bool $payRestant = False;
    public $paiementSelected;
    public $inscriptionSelected;
    public $montantPayer;
    public $montantRestant;
    public string $paiementStatus = 'OK';

    public $allLevel;
    public $sessions;
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

            $tenSecondDel = now()->subSecond(10)->timestamp;

            if ($tenSecondDel > $storage->lastModified($pathFileName)) {
                $storage->delete($pathFileName);
            }
        }
    }

    protected function rules()
    {
        $rule = [
            'photo' => ['image', 'max:1024', 'nullable'],
            'editEtudiant.adhesion.nom' => ['required'],
            'editEtudiant.adhesion.prenom' => 'required',
            'editEtudiant.adhesion.sexe' => ['required'],
            'editEtudiant.adhesion.nationalite' => ['required'],
            'editEtudiant.adhesion.dateNaissance' => ['required'],
            'editEtudiant.profession' => [''],
            'editEtudiant.adhesion.email' => ['required', 'email', Rule::unique('Adhesions', 'email')->ignore($this->editEtudiant['adhesion']['id'])],
            'editEtudiant.adhesion.telephone1' => ['min:10', 'max:10', 'nullable'],
            'editEtudiant.adhesion.telephone2' => ['min:10', 'max:10', 'nullable'],
            'editEtudiant.adhesion.adresse' => ['required'],
            'editEtudiant.adhesion.numCarte' => [Rule::unique('Adhesions', 'numCarte')->ignore($this->editEtudiant['adhesion']['id'])],
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

        $this->nscList = ["cours" => [], "examens" => []];
        $this->editEtudiant['level_id'] = Etudiant::find($this->editEtudiant['id'])->level->id;

        if ($cours != [])
        {
            foreach (Cour::all() as $cour) {
                if (in_array($cour->id, $cours)) {
                    array_push($this->nscList['cours'], ['cour_id' => $cour->id, 'cour_libelle' => $cour->libelle, 'cour_horaire' => $cour->horaire, 'active' => true]);
                } else {
                    array_push($this->nscList['cours'], ['cour_id' => $cour->id, 'cour_libelle' => $cour->libelle, 'cour_horaire' => $cour->horaire, 'active' => false]);
                }
            }
        }
        
        if ($examen!= [])
        {
            foreach (Examen::all() as $exam) {
                if (in_array($exam->id, $examen)) {
                    array_push($this->nscList['examens'], ['examen_id' => $exam->id, 'examen_libelle' => $exam->libelle, 'active' => true]);
                } else {
                    array_push($this->nscList['examens'], ['examen_id' => $exam->id, 'examen_libelle' => $exam->libelle, 'active' => false]);
                }
            }
        }

        

        // dd($this->coursList);

    }

    public function initDataEtudiant($id)
    {
        $this->editEtudiant = Etudiant::find($id);
        $adhesion = $this->editEtudiant->adhesion;
        $this->editEtudiant = $this->editEtudiant->toArray();
        $this->editEtudiant['adhesion'] = $adhesion->toArray();
        $this->listSession = Session::all()->toArray();
        $this->etudiantSession = Etudiant::find($id)->session;
        // dd($this->etudiantSession);
        // $cours = $this->etudiantSession->toArray();
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
            $this->editEtudiant['adhesion']['profil'] = $photoName;

            // $imageName = "profil/". Str::uuid() . $this->editEtudiant['nom'] . "webp";
            // Image::make($this->photo)->save($imageName, 60);
            // $image = Image::make(public_path('storage/'.$photoName))->fit(200, 200);
            // $image->save();
        }
        // suprimer les cours appartient au utilisateur au paravant
        // DB::table("etudiant_cours")->where("etudiant_id", $this->editEtudiant['id'])->delete();

        Adhesion::find($this->editEtudiant['adhesion']['id'])->update($this->editEtudiant['adhesion']);
        Etudiant::find($this->editEtudiant['id'])->update(['level_id', $this->editEtudiant['level_id']]);

        // Ajout des cour au etudiant
        // foreach ($this->nscList['cours'] as $cour) {
        //     if ($cour['active']) {
        //         Etudiant::find($this->editEtudiant['id'])->cours()->attach($cour['cour_id']);
        //     }
        // }
        // $validateAtributes['editEtudiant']['user_id'] = Auth::user()->profil;

        $this->dispatch("ShowSuccessMsg", ['message' => 'Etudiant modifier avec success!', 'type' => 'success']);
        $this->photo = '';

        $this->toogleStateName('view');
    }

    public function toogleFormPayRestant(Paiement $paiement = null, Inscription $inscription = null)
    {
        if ($this->payRestant)
        {
            $this->payRestant = !$this->payRestant;
            $this->montantPayer = 0;
            $this->montantRestant = 0;
            $this->montantPayer = 0;
        }
        else
        {
            $this->payRestant = !$this->payRestant;
            $this->paiementSelected = $paiement;
            $this->inscriptionSelected = $inscription;
        }
        
    }
    public function payRestantSubmit()
    {
        $this->montantRestant = $this->paiementSelected->montantRestant;
        if (floatval($this->montantPayer) > floatval($this->montantRestant)) {
            $this->dispatch("showModalSimpleMsg", ['message' => "Le montant payé ne doit pas dépasser le montant restant", 'type' => 'warning']);
        } else {
            $this->paiementSelected->montantRestant = $this->montantRestant - $this->montantPayer;
            if ($this->paiementSelected->montantRestant == 0) {
                $this->paiementSelected->statue = 'Totalement';
                $this->inscriptionSelected->statut = true;
                $this->inscriptionSelected->save();
            }
            $this->paiementSelected->save();
            $paiementData = [
                'montant' => $this->montantPayer,
                'montantRestant' => 0,
                'statue' => "Totalement",
                'motif' => "Suite au paiement du reçue n° : ".$this->paiementSelected->numRecue,
                'moyenPaiement' => "Espèce",
                'type' => "Réglage du paiement restant",
                'numRecue' => "AFPN°" . random_int(50, 9000),
                'user_id' => Auth::user()->id
            ];
            $myPaiement = Paiement::create($paiementData);
            $this->inscriptionSelected->paiements()->attach($myPaiement->id);
            
            $this->dispatch("ShowSuccessMsg", ['message' => 'Paiement effectué avec success!', 'type' => 'success']);
            $this->toogleFormPayRestant();
            $this->montantPayer = 0;
            $this->montantRestant = 0;
            $this->montantPayer = 0;
        }
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
        $this->sessions = Session::all();

        if ($this->filteredByCourExamen == 'examens') 
        {
            $etudiants = Etudiant::with("session", "level", "cours", "examens")
                ->whereHas("adhesion", function ($query) {
                    $query->where(function ($query) {
                        $query->where("nom", "LIKE", "%{$this->search}%")
                            ->orWhere("prenom", "LIKE", "%{$this->search}%")
                            ->orWhere("numCarte", "LIKE", "%{$this->search}%");
                    });
                })
                ->where([['level_id', 'LIKE', "%{$this->filteredByLevel}%"]])
                ->whereHas("examens", function ($qr) {
                    $qr->with('session')->whereHas("session", function($q){
                        $q->where("id", "LIKE", "%{$this->filteredBySessions}%")
                        ->where('type', 'LIKE', 'examens')
                        ->with("inscriptions")->whereHas("inscriptions", function ($query) {
                            $query->where("statut", "LIKE", "%{$this->filteredByPaiement}%");
                        });
                    });                    
                }) 
                ->paginate(5);
        }
        elseif ($this->filteredByCourExamen == 'cours')
        {
            $etudiants = Etudiant::with("session", "level", "cours", "examens")
                ->whereHas("adhesion", function ($query) {
                    $query->where(function ($query) {
                        $query->where("nom", "LIKE", "%{$this->search}%")
                            ->orWhere("prenom", "LIKE", "%{$this->search}%")
                            ->orWhere("numCarte", "LIKE", "%{$this->search}%");
                    });
                })
                ->where([['level_id', 'LIKE', "%{$this->filteredByLevel}%"]])                  
                ->whereHas("session", function ($res) {
                    // dd($qr);
                    return $res->where("id", "LIKE", "%{$this->filteredBySessions}%")
                    ->where('type', 'LIKE', 'cours')
                    ->with("inscriptions")
                    ->whereHas("inscriptions", function ($qr) {
                        $qr->where("statut", "LIKE", "%{$this->filteredByPaiement}%");
                    });
                })
                                       
                ->paginate(5);
        } 
        else 
        {
            $etudiants = Etudiant::with("session", "level", "cours", "examens", "adhesion")
                ->whereHas("adhesion", function ($query) {
                    $query->where(function ($query) {
                        $query->where("nom", "LIKE", "%{$this->search}%")
                            ->orWhere("prenom", "LIKE", "%{$this->search}%")
                            ->orWhere("numCarte", "LIKE", "%{$this->search}%");
                    });
                })
                ->whereHas('session', function ($q){
                    $q->with('inscriptions')->whereHas("inscriptions", function ($qr) { 
                        $qr->where("statut", "LIKE", "%{$this->filteredByPaiement}%");
                    });
                })                             
                ->where([['level_id', 'LIKE', "%{$this->filteredByLevel}%"]])
                ->paginate(5);
        }

        // dd($etudiants);
        $data = [
            "etudiants" => $etudiants,
        ];

        return view('livewire.etudiants.index', $data);
    }
}
