<?php

namespace App\Livewire;

use App\Models\Cour;
use App\Models\Level;
use App\Models\Professeur;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Cours extends Component
{

    public string $search = "";
    public $state = 'view';
    public $professeurs;
    public $levels;
    public $editCour = [];

    public function __construct()
    {
        $this->professeurs = Professeur::all()->toArray();
        $this->levels = Level::all()->toArray();
    }

    public function rules()
    {
        $rule = [
            'editCour.code' => ['required', Rule::unique('cours', 'code')->ignore($this->editCour['id'])],
            'editCour.libelle' => ['required'],
            'editCour.categorie' => ['required'],
            'editCour.salle' => ['string'],
            'editCour.horaire' => ['required'],
            'editCour.professeur_id' => ['required'],
            'editCour.level_id' => ['required']

        ];

        return $rule;
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
    }

    public function initEditCour($id)
    {
        $this->editCour = Cour::find($id)->toArray();
        $this->toogleStateName('edit');
    }

    public function updateCour()
    {
        $this->validate();
        // dd($this->editCour);

        Cour::find($this->editCour['id'])->update($this->editCour);
        $this->dispatch("ShowSuccessMsg", ['message' => 'Cour modifier avec success!', 'type' => 'success']);
        
        $this->toogleStateName('view');
    }

    public function render()
    {
        $data = [
            "cours" => Cour::where("libelle", "LIKE", "%{$this->search}%")
                ->orWhere("code", "LIKE", "%{$this->search}%")
                ->paginate(5)
        ];

        return view('livewire.cours.index', $data)
            ->extends('layouts.mainLayout')
            ->section('content');
    }
}
