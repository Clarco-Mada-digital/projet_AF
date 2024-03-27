<?php

use App\Http\Controllers\PdfController;
use App\Livewire\Adhesions;
use App\Livewire\ContactMadaDigital;
use App\Livewire\Cours;
use App\Livewire\Etudiants;
use App\Livewire\NewCour;
use App\Livewire\Niveaux;
use App\Livewire\Paiements;
use App\Livewire\ParametreGenerale;
use App\Livewire\Professeur;
use App\Livewire\Sauvegarde;
use App\Livewire\Sessions;
use App\Livewire\Users;
use App\Models\Adhesion;
use App\Models\Cour;
use App\Models\Etudiant;
use App\Models\Level;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::match(['get', 'post'], '/mada-contact', ContactMadaDigital::class)->name('mada-contact');

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// group des route crée par bryan

Route::group([
    'middleware' => ['auth'],
    'prefix' => 'etudiants',
    'as' => 'etudiants-',
    'middleware' => ['role:Manager|Super-Admin|Admin']
], function () {
    Route::match(['get', 'post'], '/list', Etudiants::class)->name('list');
    Route::match(['get', 'post'], '/nouveau', [App\Http\Controllers\EtudiantController::class, 'index'])->name('nouveau')->middleware('permission:étudiants.create');
});

Route::group([
    'middleware' => ['auth'],
    'prefix' => 'adhesions',
    'as' => 'adhesions-',
    'middleware' => ['role:Manager|Super-Admin|Admin']
], function () {
    Route::match(['get', 'post'], '/nouveau', Adhesions::class)->name('nouveau');
});

Route::group([
    'middleware' =>['auth'],
    'prefix' => 'cours',
    'as' => 'cours-',
    'middleware' => ['role:Manager|Super-Admin|Admin']
], function () {
    Route::match(['get', 'post'], '/list', Cours::class)->name('list');
    Route::match(['get', 'post'], '/nouveau', NewCour::class)->name('nouveau')->middleware('permission:cours.create');
});

Route::group([
    'prefix' => 'paiements',
    'as' => 'paiements-',
    'middleware' => ['role:Manager|Admin|Super-Admin']
], function () {
    Route::match(['get', 'post'], '/', Paiements::class)->name('paiement');
});

// Les section pour Administrateur
Route::group([
    'prefix' => 'parametres',
    'as' => 'parametres-',
    'middleware' => ['role:Admin|Super-Admin']
], function () {
    Route::match(['get', 'post'], '/general', ParametreGenerale::class)->name('param-general');
    Route::match(['get', 'post'], '/session', Sessions::class)->name('session');
    Route::match(['get', 'post'], '/professeur', Professeur::class)->name('professeur');
    Route::match(['get', 'post'], '/user', Users::class)->name('user');
    // Route::match(['get', 'post'], '/niveau', Niveaux::class)->name('niveau');
});

Route::group([
    'prefix' => 'save',
    'as' => 'save-',
    'middleware' => ['role:Super-Admin']
    ], function () {
    Route::match(['get', 'post'], '/', Sauvegarde::class)->name('save');
});

// Route::get('/list-etudiant', [App\Http\Controllers\HomeController::class, 'listEtudiant'])->name('list-etudiant');


Route::get('/generate-pdf/{paiement}', [PdfController::class, 'generatePDF']);

// Route test pour les datas

Route::get('/users', function () {
    return User::with(['role', 'etudiants'])->get();
});

Route::get('/roles', function () {
    return Role::with('users')->get();
});

Route::get('/etudiants', function () {
    return Etudiant::with(['user', 'cours', 'level', 'session'])->get();
});

Route::get('/cours', function () {
    return Cour::with(['level', 'etudiants', 'professeur'])->get();
});

Route::get('/niveaux', function () {
    return Level::with(['etudiants'])->get();
});
