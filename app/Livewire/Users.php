<?php

namespace App\Livewire;

use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
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
    public $rolePermissionList = ['roles' => [], 'permissions' => []];
    public $permission = false;
    public $allSelectePermissions = false;
    public $photo;

    public $userDelete;

    public $listeners = ['deleteConfirmedUser' => 'deleteUser'];

    protected $queryString = [
        'search',
    ];

    // 
    // Function pour la verification des formulaire.
    // 
    public function rules()
    {
        if ($this->sectionName == 'edit') {
            $rule = [
                'photo' => ['image', 'max:1024'],
                'editUser.nom' => ['required'],
                'editUser.prenom' => 'required',
                'editUser.sexe' => ['required'],
                'editUser.email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->editUser['id'])],
                'editUser.telephone1' => ['min:10', 'max:10', 'required'],
                'editUser.telephone2' => ['min:10', 'max:10', 'nullable'],
                'editUser.adresse' => ['required', 'string'],
            ];
        }
        if ($this->sectionName == 'new') {
            $rule = [
                'photo' => ['image', 'max:1024'],
                'newUser.nom' => ['required'],
                'newUser.prenom' => 'required',
                'newUser.sexe' => ['required'],
                'newUser.email' => ['required', 'email', Rule::unique('users', 'email')],
                'newUser.telephone1' => ['min:10', 'max:10', 'required'],
                'newUser.telephone2' => ['min:10', 'max:10', 'nullable'],
                'newUser.adresse' => ['required','string'],
            ];
        }
        return $rule;
    }

    public function toogleSectionName($name, $idUser = null)
    {
        $this->rolePermissionList = ['roles'=> [], 'permissions' => []];
        $this->newUser = [];

        if ($name == 'list') {
            // $this->nscList = ["cours" => [], "level" => []];
            $this->editUser = [];
            $this->photo = "";
            $this->rolePermissionList = ['roles' => [], 'permissions' => []];
            $this->sectionName = 'list';
        }
        if ($name == 'edit') {
            $user = User::find($idUser);
            $userInfo = $user->roles->toArray();
            $userRole = Auth()->user()->roles->toArray();
            // dd($userRole);
            $userRoleList = [];
            $authRoleList = [];
            foreach ($userInfo as $value) {
                array_push($userRoleList, $value['name']);
            }
            foreach ($userRole as $value) {
                array_push($authRoleList, $value['name']);
            }

            if (in_array("Super-Admin", $userRoleList) && !in_array("Super-Admin", $authRoleList))
            {
                $this->dispatch("showModalSimpleMsg", ['message' => "Vous ne pouvez pas éditer cette utilisateur !", 'type' => 'error']);
                return null;
            }
            if (Auth()->user()->can('utilisateurs.create'))
            {
                $this->rolePermissionList['permissions'] = [];
                $this->photo = "";
                $this->sectionName = 'edit';
                $this->initDataUser($idUser);
            }else{
                $this->dispatch("showModalSimpleMsg", ['message' => "Vous ne disposez pas des autorisations nécessaires pour effectuer cette action. Si c'est un problème, veuillez en informer l'administrateur !", 'type' => 'warning']);
            }   
        }
        if ($name == 'new') {
            if (Auth()->user()->can('utilisateurs.create'))
            {
                foreach (Permission::all() as $permission) {
                    array_push($this->rolePermissionList['permissions'], ['id' => $permission->id, 'nom' => $permission->name, 'active' => false]);
                    }
                $this->photo = "";
                $this->sectionName = 'new';
                $this->roles = Role::all();
            }else{
                $this->dispatch("showModalSimpleMsg", ['message' => "Vous ne disposez pas des autorisations nécessaires pour effectuer cette action. Si c'est un problème, veuillez en informer l'administrateur !", 'type' => 'warning']);
            }
            
        }
    }

    public function selectAllPermission()
    {
        // foreach($this->rolePermissionList['permissions'] as $permission)
        // {
        //     $this->allSelectePermissions ? $permission['active'] = true : $permission['active'] = false;
        // }
        for ($i=0; $i < count($this->rolePermissionList['permissions']); $i++) { 
            $this->allSelectePermissions ? $this->rolePermissionList['permissions'][$i]['active'] = true : $this->rolePermissionList['permissions'][$i]['active'] = false;
        }
    }

    public function initDataUser($user)
    {
        $this->rolePermissionList = ['roles' => [], 'permissions' => []];
        $this->editUser = User::find($user)->toArray();
        $userRoleId = User::find($user)->roles;
        $userPermissionId = User::find($user)->permissions->toArray();
        $arrayUserPermId = [];
        foreach ($userPermissionId as $permissionId) {
            array_push($arrayUserPermId, $permissionId['id']);
        }

        //  Pour les Roles
        foreach (Role::all() as $role) {
            foreach ($userRoleId as $roleId) {
                if ($role->id == $roleId->id) {
                    array_push($this->rolePermissionList['roles'], ['id' => $role->id, 'nom' => $role->name, 'active' => true]);
                } else {
                    array_push($this->rolePermissionList['roles'], ['id' => $role->id, 'nom' => $role->name, 'active' => false]);
                }
            }
        }
        
        foreach (Permission::all() as $permission) {
            if (in_array($permission->id, $arrayUserPermId)) {
                array_push($this->rolePermissionList['permissions'], ['id' => $permission->id, 'nom' => $permission->name, 'active' => true]);
            } else {
                array_push($this->rolePermissionList['permissions'], ['id' => $permission->id, 'nom' => $permission->name, 'active' => false]);
            }
        }
    }

    public function addNewUser()
    {
        $roleGivePermission = 
        [
            "Accueil" => ["utilisateurs.*", "étudiants.*", "sessions.*"], 
            "Pédagogique" => ["cours.*", "niveaux.*", "sessions.*", "professeurs.*", "examens.*", "catégories.*"], 
            "Admin" => ["cours.*", "niveaux.*", "sessions.*", "utilisateurs.*", "étudiants.*", "professeurs.*", "rôles.*", "tarifs.*", "examens.*", "catégories.*"]
        ];        

        if ($this->photo != '') {
            $photoName = $this->photo->store('profil', 'public');
            $this->newUser['profil'] = $photoName;
        }
        $validateAtributes = $this->validate();

        // 
        // Empêcher l'enregistrement d'utilisateur si aucun rôle ne lui soit attribué.
        // 
        if($this->newUser['role_id'] == null)
        {
            $this->dispatch("showModalSimpleMsg", ['message' => "Veuillez sélectionner un role pour l'utilisateur!", 'type' => 'error']);
            return;
        }

        // 
        // Empêcher les autres utilisateurs crée un utilisateur avec rôle admin
        // 
        if($this->newUser['role_id'] == "Super-Admin" && !in_array("Super-Admin", Auth::user()->roles->toArray()))
        {
            $this->dispatch("showModalSimpleMsg", ['message' => "Désolé, seuls les Super Admins peuvent ajouter un autre Super Admin.", 'type' => 'error']);
            return;
        }

        $user = User::create($validateAtributes['newUser']);

        // 
        // Ajout le Role selection pour l'utilisateur crée.
        // 
        $user->assignRole($this->newUser['role_id']);
        $rolePermission = True;

        // 
        // Ajout de permission au utilisateur crée.
        // 
        if (count($this->rolePermissionList['permissions']) > 0) {
            foreach ($this->rolePermissionList['permissions'] as $permission) {
                if ($permission['active']) {
                    $user->givePermissionTo($permission['nom']);
                    $rolePermission = False;
                }
            }
        }
        if ($rolePermission)
        {
            foreach ($roleGivePermission[$this->newUser['role_id']] as $perm) {
                $user->givePermissionTo($perm);
            }
        }

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
        foreach ($this->rolePermissionList['roles'] as $role) {
            if ($role['active']) {
                array_push($newRoleUserId, $role['id']);
            }
        }
        $newPermissionUserId = [];
        foreach ($this->rolePermissionList['permissions'] as $permission) {
            if ($permission['active']) {
                array_push($newPermissionUserId, $permission['id']);
            }
        }

        $this->validate();

        if (count($newRoleUserId) > 1) {
            $this->dispatch("showModalSimpleMsg", ['message' => "Un utilisateur doit avoir qu'une seul rôle", 'type' => 'warning']);
            return null;
        } else {
            // suppression de role et permission de l'utilisateur
            $user = User::find($this->editUser['id']);
            $user->syncRoles($newRoleUserId);
            $user->syncPermissions($newPermissionUserId);
        }

        User::find($this->editUser['id'])->update($this->editUser);

        $this->dispatch("ShowSuccessMsg", ['message' => 'Utilisateur modifier avec success!', 'type' => 'success']);
        $this->photo = '';

        $this->toogleSectionName('list');
    }

    public function deleteConfirmation(User $user)
    {
        $userInfo = $user->roles->toArray();
        $userRoleList = [];
        foreach ($userInfo as $value) {
            array_push($userRoleList, $value['name']);
        }

        if (in_array("Super-Admin", $userRoleList) && !in_array("Super-Admin", Auth()->user()->roles->toArray())) 
        {
            $this->dispatch("showModalSimpleMsg", ['message' => "Vous ne pouvez pas supprimer cette utilisateur !", 'type' => 'error']);
        }
        else
        {
            $this->userDelete = $user->id;
            $this->dispatch("AlertDeleteConfirmModal", ['message' => "êtes-vous sur de suprimer $user->nom $user->prenom ! dans la liste des utilisateurs ?", 'type' => 'warning', 'thinkDelete' => 'User']);
        }

    }
    public function deleteUser()
    {
        $user = User::where('id', $this->userDelete)->first();
        $user->delete();
        $this->dispatch("ShowSuccessMsg", ['message' => "L'utilisateur a été supprimé avec succès !", 'type' => 'success']);
    }

    // 
    // function pour le trie du tableau d'affichage.
    // 
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
