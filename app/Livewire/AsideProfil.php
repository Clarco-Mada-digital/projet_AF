<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class AsideProfil extends Component
{
    public $formChangePwd = false;
    public $newPwd;
    public $confPwd;
    public $editProfil = false;


    // public function viewProfil()
    // {
    //     dd('voir profil');
    // }

    // public function updateProfil()
    // {
    //     $this->editProfil = Auth::user();
        
    //     dd($this->editProfil);
    // }

    public function showFormPass()
    {
        $this->formChangePwd == true ? $this->formChangePwd = false : $this->formChangePwd = true;
    }

    public function changePass()
    {
        if ($this->newPwd != $this->confPwd)
        {
            $this->dispatch("showModalSimpleMsg", ['message' => 'Votre mot de passe ne correspond pas.', 'type' => 'warning']);
            return null;
        }
        else
        {
            $user = User::find(Auth::user()->id);
            $user->update(['password' => Hash::make($this->newPwd)]);
            $this->dispatch("ShowSuccessMsg", ['message' => 'Mot de passe modifier avec success!', 'type' => 'success']);
    
            $this->newPwd = "";
            $this->showFormPass();
            // dd(Hash::make($this->newPwd));
        }

    }

    public function render()
    {
        return view('livewire.profils.aside-profil');
    }
}
