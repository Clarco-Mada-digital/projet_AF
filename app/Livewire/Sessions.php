<?php

namespace App\Livewire;

use App\Models\Cour;
use App\Models\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Sessions extends Component
{
    use WithPagination;

    protected $paginationTheme = "bootstrap";


    public $search;
    public $formNewSession = False;
    public $formEditSession = False;
    public $newSession = ["horaireDuCour"=>''];
    public $editSession = [];
    public $now;
    public $cours = [];
    public $showFormCours = False;
    public $orderDirection = 'ASC';
    public $orderField = 'nom';
    public $dateInput;
    public $heurDebInput;
    public $heurFinInput;
    public $dateHeurCour;

    protected $queryString = [
        'search' => ['except' => '']
    ];

    public function __construct()
    {
        $this->now = Carbon::now();
        $sessions = Session::all();
        foreach($sessions as $session)
        {
            if ($session->statue)
            {
                if ($session->dateFin < $this->now)
                {
                    $session->update(['statue' => false]);
                }
            }
        }
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

    public function toogleFormSession()
    {
        if (Cour::all()->toArray() == null) {
            $this->dispatch("showModalSimpleMsg", ['message' => "Avant de créer une nouvelle session, soyer sûr qu'il y a des cours dans la base !", 'type' => 'warning']);
        } else {
            foreach (Cour::all() as $cour) {
                array_push($this->cours, ['id' => $cour->id, 'libelle' => $cour->libelle, 'horaire' => $cour->horaire, 'active' => false]);
            }
            $this->formNewSession == True ? [$this->formNewSession = False, $this->cours = [], $this->showFormCours = False] : $this->formNewSession = True;
        }
    }
    public function toogleFormCours()
    {

        $this->showFormCours == False ? $this->showFormCours = True : $this->showFormCours = False;
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

    public function addNewSession()
    {
        $this->validate();
        $this->newSession['horaireDuCour'] = $this->dateHeurCour;

        // Add nouveau session dans la base
        $mySession = Session::create($this->newSession);

        // add les cours correspondant au session a la base
        foreach ($this->cours as $cour) {
            if ($cour['active']) {
                $mySession->cours()->attach($cour['id']);
            }
        }

        $this->dispatch("ShowSuccessMsg", ['message' => 'Creation de session avec success!', 'type' => 'success']);

        $this->newSession = [];
        $this->cours = [];
        $this->formNewSession = False;
        $this->showFormCours = False;
    }

    public function initUpdateSession(Session $session, $cancel = False)
    {
        $this->cours = [];
        if ($cancel) {
            $this->editSession = [];
            $this->showFormCours = False;
            $this->formEditSession = false;
        } else {
            // metre la liste de nos cours dans un variable          
            $mapData = function ($value) {
                return $value['id'];
            };

            $this->editSession = [];
            $this->formEditSession = True;
            $this->editSession = $session->toArray();

            $cours = array_map($mapData, Session::find($this->editSession['id'])->cours->toArray());
            foreach (Cour::all() as $cour) {
                if (in_array($cour->id, $cours)) {
                    array_push($this->cours, ['id' => $cour->id, 'libelle' => $cour->libelle, 'horaire' => $cour->horaire, 'active' => true]);
                } else {
                    array_push($this->cours, ['id' => $cour->id, 'libelle' => $cour->libelle, 'horaire' => $cour->horaire, 'active' => false]);
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
        DB::table("session_cours")->where("session_id", $this->editSession['id'])->delete();

        // add les cours correspondant au session a la base
        foreach ($this->cours as $cour) {
            if ($cour['active']) {
                Session::find($this->editSession['id'])->cours()->attach($cour['id']);
            }
        }

        $this->dispatch("ShowSuccessMsg", ['message' => 'Session mise à jour avec success!', 'type' => 'success']);

        $this->newSession = [];
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

        $data = [
            "sessions" => Session::where("nom", "LIKE", "%{$this->search}%")
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate(5)
        ];

        return view('livewire.sessions.index', $data)
            ->extends('layouts.mainLayout')
            ->section('content');
    }
}
