<?php

namespace App\Livewire;

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;


#[Layout('layouts.mainLayout')]
class Users extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = "bootstrap";
    
    public $search;
    public $orderField = 'nom';
    public $orderDirection = 'ASC';
    public $sectionName = 'list';
    public $editUser = [];
    public $newUser = [];
    public $roles = [];
    public $rolePermissionList = ['roles'=> []];
    public $permission=false;
    public $photo;

    public $userDelete;

    public $listeners = ['deleteConfirmed' => 'deleteUser'];

    protected $queryString = [
        'search' ,
    ];

    public function rules()
    {
        if ($this->sectionName == 'edit')
        {
            $rule = [
                'photo' => ['image', 'max:1024'],
                'editUser.nom' => ['required'],
                'editUser.prenom' => 'required',
                'editUser.sexe' => ['required'],
                'editUser.nationalite' => ['string'],
                'editUser.email' => ['required', 'email', Rule::unique('etudiants', 'email')->ignore($this->editUser['id'])],
                'editUser.telephone1' => ['required'],
                'editUser.telephone2' => [''],
                'editUser.adresse' => ['string'],
                'editUser.role_id' => ['']
    
            ];           
        }
        if ($this->sectionName == 'new')
        {
            $rule = [
                'photo' => ['image', 'max:1024'],
                'newUser.nom' => ['required'],
                'newUser.prenom' => 'required',
                'newUser.sexe' => ['required'],
                'newUser.nationalite' => ['string'],
                'newUser.email' => ['required', 'email', Rule::unique('etudiants', 'email')],
                'newUser.telephone1' => ['required'],
                'newUser.telephone2' => [''],
                'newUser.adresse' => ['string'],
                'newUser.role_id' => ['']
    
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
            $this->photo = "";
            $this->rolePermissionList = ['roles'=> []];
            $this->sectionName = 'list';
        }
        if ($name == 'edit') 
        {
            $this->photo = "";
            $this->sectionName = 'edit';
            $this->initDataUser($idUser);
        }
        if ($name == 'new')
        {
            $this->photo = "";
            $this->sectionName = 'new';
            $this->roles = Role::all();
            
        }
    }

    public function initDataUser($user)
    {
       $this->editUser = User::find($user)->toArray();
       $userRoleId = $this->editUser['role_id'];
       foreach(Role::all() as $role)
       {
            if ($role->id == $userRoleId)
            {
                array_push($this->rolePermissionList['roles'], ['id'=>$role->id, 'nom'=>$role->nom, 'active'=>true]);
            }
            else
            {
                array_push($this->rolePermissionList['roles'], ['id'=>$role->id, 'nom'=>$role->nom, 'active'=>false]);
            }
       }
    }

    public function addNewUser()
    {
        if ($this->photo != '') {
            $photoName = $this->photo->store('profil', 'public');
            $this->newUser['profil'] = $photoName;
        }
        $validateAtributes = $this->validate();
        
        User::create($validateAtributes['newUser']);

        $this->dispatch("ShowSuccessMsg", ['message' => 'Utilisateur enregistrer avec success!', 'type' => 'success']);
        $this->photo = '';

        $this->toogleSectionName('list');
    }

    public function updateUser()
    {
        if ($this->photo != '') {
            $photoName = $this->photo->store('profil', 'public');
            $this->editUser['profil'] = $photoName;
        }
        
        $newRoleUserId = [];
        foreach ($this->rolePermissionList['roles'] as $role)
        {
            if ($role['active'])
            {
                array_push($newRoleUserId, $role['id']);
            }
        }

        if (count($newRoleUserId) > 1)
        {
            $this->dispatch("showModalSimpleMsg", ['message' => "Un utilisateur doit avoir qu'une seul rôle", 'type' => 'warning']);
            return null;
        }else{ $this->editUser['role_id'] = $newRoleUserId[0]; } 

        $this->validate();
        // dd($this->editUser);
        User::find($this->editUser['id'])->update($this->editUser);

        $this->dispatch("ShowSuccessMsg", ['message' => 'Utilisateur modifier avec success!', 'type' => 'success']);
        $this->photo = '';

        $this->toogleSectionName('list');
    }

    public function deleteConfirmation(User $user)
    {
        $this->userDelete = $user->id;
        $this->dispatch("AlerDeletetConfirmModal", ['message' => "êtes-vous sur de suprimer $user->nom $user->prenom ! dans la liste des utilisateurs ?", 'type' => 'warning']);
        // $user->delete();
        // dd($user);
        // $this->dispatch("ShowSuccessMsg", ['message' => "L'utilisateur a été supprimé avec succès !", 'type' => 'success']);

    }
    public function deleteUser()
    {
        // dd($this->userDelete);
        $user = User::where('id', $this->userDelete)->first();
        $user->delete();
        $this->dispatch("ShowSuccessMsg", ['message' => "L'utilisateur a été supprimé avec succès !", 'type' => 'success']);
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
                ->orWhere("prenom", "LIKE", "%{$this->search}%")
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate(5)
        ];
        return view('livewire.users.index', $data);
    }
}
