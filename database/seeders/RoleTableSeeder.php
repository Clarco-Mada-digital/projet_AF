<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        
        // Permission
        Permission::create(['name' => 'utilisateurs.*', 'guard_name'=>'web']);
        // Permission::create(['name' => 'créer utilisateurs', 'guard_name'=>'web']);
        // Permission::create(['name' => 'modifier utilisateurs', 'guard_name'=>'web']);
        // Permission::create(['name' => 'supprimer utilisateurs', 'guard_name'=>'web']);

        Permission::create(['name' => 'étudiants.*', 'guard_name'=>'web']);
        // Permission::create(['name' => 'créer étudiant', 'guard_name'=>'web']);
        // Permission::create(['name' => 'modifier étudiant', 'guard_name'=>'web']);
        // Permission::create(['name' => 'supprimer étudiant', 'guard_name'=>'web']);

        Permission::create(['name' => 'cours.*', 'guard_name'=>'web']);
        // Permission::create(['name' => 'créer cours', 'guard_name'=>'web']);
        // Permission::create(['name' => 'modifier cours', 'guard_name'=>'web']);
        // Permission::create(['name' => 'supprimer cours', 'guard_name'=>'web']);

        Permission::create(['name' => 'sessions.*', 'guard_name'=>'web']);
        // Permission::create(['name' => 'créer sessions', 'guard_name'=>'web']);
        // Permission::create(['name' => 'modifier sessions', 'guard_name'=>'web']);
        // Permission::create(['name' => 'supprimer sessions', 'guard_name'=>'web']);

        Permission::create(['name' => 'professeurs.*', 'guard_name'=>'web']);
        // Permission::create(['name' => 'créer professeurs', 'guard_name'=>'web']);
        // Permission::create(['name' => 'modifier professeurs', 'guard_name'=>'web']);
        // Permission::create(['name' => 'supprimer professeurs', 'guard_name'=>'web']);

        Permission::create(['name' => 'rôles.*', 'guard_name'=>'web']);
        // Permission::create(['name' => 'créer rôles', 'guard_name'=>'web']);
        // Permission::create(['name' => 'modifier rôles', 'guard_name'=>'web']);
        // Permission::create(['name' => 'supprimer rôles', 'guard_name'=>'web']);

        Permission::create(['name' => 'tarifs.*', 'guard_name'=>'web']);
        // Permission::create(['name' => 'créer tarifs', 'guard_name'=>'web']);
        // Permission::create(['name' => 'modifier tarifs', 'guard_name'=>'web']);
        // Permission::create(['name' => 'supprimer tarifs', 'guard_name'=>'web']);

        Permission::create(['name' => 'examens.*', 'guard_name'=>'web']);
        // Permission::create(['name' => 'créer examens', 'guard_name'=>'web']);
        // Permission::create(['name' => 'modifier examens', 'guard_name'=>'web']);
        // Permission::create(['name' => 'supprimer examens', 'guard_name'=>'web']);

        Permission::create(['name' => 'niveaux.*', 'guard_name'=>'web']);
        // Permission::create(['name' => 'créer niveaux', 'guard_name'=>'web']);
        // Permission::create(['name' => 'modifier niveaux', 'guard_name'=>'web']);
        // Permission::create(['name' => 'supprimer niveaux', 'guard_name'=>'web']);

        Permission::create(['name' => 'catégories.*', 'guard_name'=>'web']);
        // Permission::create(['name' => 'créer catégories', 'guard_name'=>'web']);
        // Permission::create(['name' => 'modifier catégories', 'guard_name'=>'web']);
        // Permission::create(['name' => 'supprimer catégories', 'guard_name'=>'web']);

        // Role and assign existing permissions
        $accueil = Role::create(['name' => 'Accueil', 'guard_name'=>'web']);
        $accueil->givePermissionTo('étudiants.*');

        $Admin = Role::create(['name' => 'Admin', 'guard_name'=>'web']);
        $Admin->givePermissionTo('utilisateurs.*');

        $Admin = Role::create(['name' => 'Pédagogique', 'guard_name'=>'web']);

        $superAdmin = Role::create(['name' => 'Super-Admin', 'guard_name'=>'web']);


        
    }
}
