<?php

use App\Livewire\Etudiants;
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

Route::get('/mada-contact', function () {
    return view('pages.mada-contact');
})->name('mada-contact');

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// group des route crée par bryan
Route::group([
    'prefix' => 'etudiants',
    'as' => 'etudiants-'
], function(){
    Route::get('/list', Etudiants::class)->name('list');
    Route::get('/nouveau', [App\Http\Controllers\HomeController::class, 'nouveauEtudiant'])->name('nouveau');
});

// Route::get('/list-etudiant', [App\Http\Controllers\HomeController::class, 'listEtudiant'])->name('list-etudiant');


// Route test pour les datas
Route::get('/users', function(){
    return User::with(['role', 'etudiants'])->get();
} );

Route::get('/roles', function(){
    return Role::with('users')->get();
} );

Route::get('/etudiants', function(){
    return Etudiant::with(['user', 'cours', 'level'])->get();
} );

Route::get('/cours', function(){
    return Cour::with(['level', 'etudiants', 'professeur'])->get();
} );

Route::get('/niveaux', function(){
    return Level::with(['etudiants'])->get();
} );

