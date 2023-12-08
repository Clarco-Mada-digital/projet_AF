<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditProfil extends Component
{
    use WithFileUploads;
    
    public $editProfil;
    public $photo;
    public $editModal = false;

    public function rules()
    {
        $rule = [
            'editProfil.profil' => [''],
            'editProfil.nom' => ['required'],
            'editProfil.prenom' => 'required',
            'editProfil.sexe' => ['required'],
            'editProfil.nationalite' => ['string'],
            'editProfil.email' => ['required', 'email', Rule::unique('etudiants', 'email')->ignore($this->editProfil['id'])],
            'editProfil.telephone1' => ['required'],
            'editProfil.telephone2' => [''],
            'editProfil.adresse' => ['string'],
    
        ];
        return $rule;
    }

    public function mount()
    {
        $this->editProfil = Auth::user()->toArray();
    }

    public function updateProfil()
    {
        $this->validate();
       
        User::find(Auth::user()->id)->update($this->editProfil);

        $this->dispatch("ShowSuccessMsg", ['message' => 'Profil modifier avec success!', 'type' => 'success']);
        // $this->editProfil = [];

        redirect(route('home'));

    }
    
    public function render()
    {
        return view('livewire.profils.edit');
    }
}
