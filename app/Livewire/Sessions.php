<?php

namespace App\Livewire;

use App\Models\Categorie;
use App\Models\Cour;
use App\Models\Examen;
use App\Models\Level;
use App\Models\Professeur;
use App\Models\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;


#[Layout('layouts.mainLayout')]
class Sessions extends Component
{
    use WithPagination;

    protected $paginationTheme = "bootstrap";


    public $search;
    public $formNewSession = False;
    public $formEditSession = False;
    public $newSession = ["type"=>""];
    public $editSession = ["type" => ""];
    public $now;
    public $professeurs;
    public $levels;
    public $categories;
    public $newLevels = [];
    public $coursList = [];
    public $examensList = [];
    public $showFormCours = False;

    public $orderDirection = 'ASC';
    public $orderField = 'nom';

    public $salles;
    public $newCour = [];
    public $newCourList = [];
    public $dateInput;
    public $heurDebInput;
    public $heurFinInput;
    public $dateHeurCour;

    public function __construct()
    {
        $this->professeurs = Professeur::all()->toArray();
        $this->levels = Level::all()->toArray();
        $this->categories = Categorie::all()->toArray();
        $this->now = Carbon::now();
        $sessions = Session::all();
        $this->salles = ['Salle 01', 'Salle 02', 'Salle 03', 'Salle 4','Salle 5','Salle 6','Salle 7','Salle 8','Salle 9','Salle 10', 'Salle de réunion', 'Salle de spectacle', 'Médiathèque', 'Hall'];
        foreach ($sessions as $session) {
            if ($session->statue) {
                if ($session->dateFin < $this->now) {
                    // Désactiver la session qui dépassé la jour par rapport au jour de fin.
                    $session->update(['statue' => false]);

                    // Supprimer les cours appartient au session fermer
                    $session->cours->each(function ($cour) {
                        $cour->delete();
                    });
                    // DB::table("session_cours")->where("session_id", $session->id)->delete();
                }
            }
        }
        $this->initDataCours();
        // $this->cours= Cour::all()->toArray();

    }

    public function rules()
    {
        if ($this->formNewSession) {
            $rule = [
                'newSession.nom' => ['required', Rule::unique('sessions', 'nom')],
                'newSession.dateDebut' => ['required'],
                'newSession.dateFin' => ['required']
            ];
        }
        if ($this->formEditSession) {
            $rule = [
                'editSession.nom' => ['required', Rule::unique('sessions', 'nom')->ignore($this->editSession['id'])],
                'editSession.dateDebut' => ['required'],
                'editSession.dateFin' => ['required']
            ];
        }

        return $rule;
    }

    public function initDataCours()
    {
        $this->coursList = [];
        foreach (Cour::all() as $cour) {
            array_push($this->coursList, ['id' => $cour->id, 'libelle' => $cour->libelle, 'horaire' => $cour->horaire, 'active' => false]);
        }
        $this->examensList = [];
        foreach (Examen::all() as $examen) {
            array_push($this->examensList, ['id' => $examen->id, 'libelle' => $examen->libelle, 'horaire' => $examen->horaire, 'active' => false]);
        }
    }

    public function toogleFormSession()
    {
        if(Auth()->user()->can('sessions.edit'))
        {
            $this->initDataCours();
            $this->formNewSession ? [$this->formNewSession = False, $this->showFormCours = False] : [$this->formNewSession = True, $this->formEditSession = false];
        }else{
            $this->dispatch("showModalSimpleMsg", ['message' => "Vous ne disposez pas des autorisations nécessaires pour effectuer cette action. Si c'est un problème, veuillez en informer l'administrateur !", 'type' => 'warning']);
        }
    }
    public function toogleFormCours()
    {
        $this->showFormCours ? [$this->showFormCours = false] : [$this->showFormCours = true];
    }

    // public function setNewSessionType()
    // {
        
    // }

    // Fonction pour récupérer les heurs du cour
    public function setDateHourCour()
    {
        if ($this->dateInput == '' || $this->heurDebInput == '' || $this->heurFinInput == '' || $this->heurDebInput > $this->heurFinInput) {
            $this->dispatch("showModalSimpleMsg", ['message' => "Désolé, quelque chose a mal tourné. Veuillez vérifier les heures que vous avez entrées.", 'type' => 'error']);
            return null;
        }
        // Pour une separation dans l'affichage
        $dateTimeForma =  $this->dateInput . ' ' . $this->heurDebInput . '-' . $this->heurFinInput;
        if ($this->dateHeurCour != null) {
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

    public function addNewCour()
    {
        $this->validate([
            'newCour.code' => ['required', 'string', Rule::unique('cours', 'code')],
            'newCour.libelle' => ['required'],
            'newCour.categorie_id' => ['required'],
            'newCour.salle' => ['string'],
            'newCour.professeur_id' => ['string'],
        ]);

        $this->newCour['horaireDuCour'] = $this->dateHeurCour;
        $this->newCour['session_id'] = $this->editSession['id'];
        $myCour = Cour::create($this->newCour);

        array_push($this->newCourList, $myCour->id);

        if ($this->newLevels != []) {
            foreach ($this->newLevels as $level) {
                $myCour->level()->attach($level);
            }
        }

        $this->dispatch("ShowSuccessMsg", ['message' => 'Enregistrement avec success!', 'type' => 'success']);

        $this->coursList = [];
        $this->initDataCours();
        $this->resetDateHourCour();
        $this->newCour = [];
        $this->newLevels = [];
    }

    public function addNewSession()
    {
        $this->validate();
        // $this->newSession['horaireDuCour'] = $this->dateHeurCour;

        // Add nouveau session dans la base
        $mySession = Session::create($this->newSession);

        // add les cours correspondant au session a la base
        if ($this->newSession['type'] == 'cours')
        {
            foreach ($this->coursList as $cour) {
                if ($cour['active']) {
                    $mySession->cours()->attach($cour['id']);
                }
            }
            foreach ($this->newCourList as $cour) {
                $mySession->cours()->attach($cour);
            }
        }
        // add les examens correspondant au session a la base
        if ($this->newSession['type'] == 'examen')
        {
            foreach ($this->examensList as $examen) {
                if ($examen['active']) {
                    $mySession->examens()->attach($examen['id']);
                }
            }
        }
        

        $this->dispatch("ShowSuccessMsg", ['message' => 'Creation de session avec success!', 'type' => 'success']);

        $this->newCourList = [];
        $this->newSession = ['type' => ""];
        $this->coursList = [];
        $this->dateHeurCour = "";
        $this->formNewSession = False;
        $this->showFormCours = False;
    }

    public function initUpdateSession(Session $session, $cancel = False)
    {
        $this->coursList = [];
        $this->examensList = [];
        if ($cancel) {
            $this->editSession = ['type' =>""];
            $this->showFormCours = False;
            $this->formEditSession = false;
        } else {
            // metre la liste de nos cours dans un variable
            $this->formNewSession ? $this->formNewSession = false : "";
            $mapData = function ($value) {
                return $value['id'];
            };

            $this->editSession = [];
            $this->formEditSession = True;
            $this->editSession = $session->toArray();

            $cours = array_map($mapData, Session::find($this->editSession['id'])->cours->toArray());
            foreach (Cour::all() as $cour) {
                if (in_array($cour->id, $cours)) {
                    array_push($this->coursList, ['id' => $cour->id, 'libelle' => $cour->libelle, 'horaire' => $cour->horaire, 'active' => true]);
                } else {
                    array_push($this->coursList, ['id' => $cour->id, 'libelle' => $cour->libelle, 'horaire' => $cour->horaire, 'active' => false]);
                }
            }
            $examens = array_map($mapData, Session::find($this->editSession['id'])->examens->toArray());
            foreach (Examen::all() as $examen) {
                if (in_array($examen->id, $examens)) {
                    array_push($this->examensList, ['id' => $examen->id, 'libelle' => $examen->libelle, 'active' => true]);
                } else {
                    array_push($this->examensList, ['id' => $examen->id, 'libelle' => $examen->libelle, 'active' => false]);
                }
            }
        }
        // dd($this->editSession);
    }

    public function updateSession(Session $session)
    {
        // dd($this->editSession);
        $this->validate();
        $this->editSession['dateFin'] < $this->now ? $this->editSession['statue'] = false : $this->editSession['statue'] = true;
        Session::find($session->id)->update($this->editSession);

        // Vider les ancien donné
        // DB::table("session_cours")->where("session_id", $this->editSession['id'])->delete();

        // add les cours correspondant au session a la base
        // foreach ($this->coursList as $cour) {
        //     if ($cour['active']) {
        //         Session::find($this->editSession['id'])->cours()->attach($cour['id']);
        //     }
        // }

        $this->dispatch("ShowSuccessMsg", ['message' => 'Session mise à jour avec success!', 'type' => 'success']);

        $this->editSession = ['type' => ""];
        $this->formNewSession = False;
        $this->showFormCours = False;
        $this->formEditSession = false;
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
        // $this->coursList = [];


        $data = [
            "sessions" => Session::where("nom", "LIKE", "%{$this->search}%")
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate(5)
        ];

        return view('livewire.sessions.index', $data);
    }
}
