<?php

namespace App\Livewire;

use App\Models\Etudiant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Etudiants extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public string $search = "";
    public string $orderField ='nom';
    public string $orderDirection ='ASC';

    public $state = 'view';

    public $editEtudiant = [];
     
    protected $queryString = [
        'search' => ['except' => '']
    ];

    protected function rules(){
        $rule = [
            'editEtudiant.nom' => ['required'],
            'editEtudiant.prenom' => 'required',
            'editEtudiant.sexe' => ['required'],
            'editEtudiant.dateNaissance' => ['required'],
            'editEtudiant.email' => ['required','email', Rule::unique('etudiants', 'email')->ignore($this->editEtudiant['id'])],
            'editEtudiant.telephone1' => ['required'],
            'editEtudiant.telephone2' => [''],
            'editEtudiant.adresse' => ['required'],
            
        ];
        return $rule;
    } 

    public function toogleStateName($stateName){
        if ($stateName == 'view'){            
            $this->editEtudiant = [];
            $this->state = 'view';
        }
        if ($stateName == 'edit'){
            $this->state = 'edit';
        }
        if ($stateName == 'new'){
            $this->state = 'new';
        }     
    }

    public function initDataEtudiant($id){
        $this->editEtudiant = Etudiant::find($id)->toArray();
        $this->toogleStateName('edit');
    }

    public function updateEtudiant($id){
        $validateAtributes = $this->validate();
        Etudiant::find($this->editEtudiant['id'])->update($validateAtributes['editEtudiant']);
        // $validateAtributes['editEtudiant']['user_id'] = Auth::user()->profil;

        $this->dispatch("ShowSuccessMsg", ['message'=>'Etudiant modifier avec success!','type'=>'success']);
    }

    public function setOrderField(string $name){
        if ($name === $this->orderField){
            $this->orderDirection = $this->orderDirection === 'ASC' ? 'DESC' : 'ASC';
        }else{
            $this->orderField = $name;
            $this->reset('orderDirection');

        }
    }

    public function render()
    {
        Carbon::setLocale('fr');

        $data = [
            "etudiants" => Etudiant::where("prenom", "LIKE", "%{$this->search}%")
            ->orWhere("nom", "LIKE", "%{$this->search}%")
            ->orderBy($this->orderField, $this->orderDirection)
            ->paginate(5)
        ];

        return view('livewire.etudiants.index',$data)
            ->extends('layouts.mainLayout')
            ->section('content');
    }
}
