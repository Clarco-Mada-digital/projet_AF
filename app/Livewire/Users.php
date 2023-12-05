<?php

namespace App\Livewire;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;
    use WithFileUploads;

    
    public $search;
    public $orderField = 'nom';
    public $orderDirection = 'ASC';
    public $sectionName = 'list';
    public $editUser = [];
    public $photo;

    protected $queryString = [
        'search' => ['except' => '']
    ];

    public function rules()
    {
        if ($this->sectionName == 'edit')
        {
            $rule = [
                'editUser.profil' => [''],
                'editUser.nom' => ['required'],
                'editUser.prenom' => 'required',
                'editUser.sexe' => ['required'],
                'editUser.email' => ['required', 'email', Rule::unique('etudiants', 'email')->ignore($this->editUser['id'])],
                'editUser.telephone1' => ['required'],
                'editUser.telephone2' => [''],
                'editUser.role_id' => ['']
    
            ];
        }

        return $rule;
    }

    public function toogleSectionName($name, $idUser = null)
    {
        if ($name == 'list') 
        {
            // $this->nscList = ["cours" => [], "level" => []];
            $this->editUser = [];
            $this->sectionName = 'list';
        }
        if ($name == 'edit') 
        {
            $this->sectionName = 'edit';
            $this->initDataUser($idUser);
        }
        if ($name == 'new')
        {
            // dd(Session::all());
            // if (Session::all()->toArray() == null)
            // {
            //     $this->dispatch("showModalSimpleMsg", ['message' => "Avant d'inscrire un étudiant, soyer sûr qu'il y a de la session active !", 'type' => 'warning']);
            // }
            // else{ return redirect(route('etudiants-nouveau')); }
            
        }
    }

    public function initDataUser($user)
    {
       $this->editUser = User::find($user)->toArray();
    }

    public function updateUser()
    {
        if ($this->photo != '') {
            $photoName = $this->photo->store('photos', 'public');
            $this->editUser['profil'] = $photoName;
        }

        $validateAtributes = $this->validate();
        // dd($validateAtributes['editUser']);
        User::find($this->editUser['id'])->update($validateAtributes['editUser']);

        $this->dispatch("ShowSuccessMsg", ['message' => 'Utilisateur modifier avec success!', 'type' => 'success']);
        $this->photo = '';

        $this->toogleSectionName('lsit');
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
            "users" => User::where("nom", "LIKE", "%{$this->search}%")
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate(5)
        ];
        return view('livewire.users.index', $data)
                ->extends('layouts.mainLayout')
                ->section('content');
    }
}
