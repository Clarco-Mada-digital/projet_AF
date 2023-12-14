<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class EditProfil extends Component
{
    use WithFileUploads;
    use WithPagination;
    
    protected $paginationTheme = "bootstrap";
    
    public $editProfil = [];
    public $photo;
    public $newPwd;
    public $confPwd;
    public $editModal = false;

    public function rules()
    {
        $rule = [
            'photo' => ['image', 'max:1024'],
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
        $this->initDataProfil();
    }

    public function initDataProfil()
    {
        $this->editProfil = User::find(Auth::user()->id)->toArray();
    }

    public function updateProfil()
    {
        $this->validate();
        
        if ($this->photo != '') {
            $photoName = $this->photo->store('profil', 'public');
            $this->editProfil['profil'] = $photoName;
        }

       
        if ($this->newPwd != null)
        {
            if ($this->newPwd == $this->confPwd)
            {
                $this->editProfil['password'] = Hash::make($this->newPwd);
            }
            else
            {
                $this->dispatch("showModalSimpleMsg", ['message' => 'Votre mot de passe ne correspond pas.', 'type' => 'warning']);
                return null;
            }
        }
        // dd($this->editProfil);
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
