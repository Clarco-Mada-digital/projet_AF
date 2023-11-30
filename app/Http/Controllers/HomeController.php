<?php

namespace App\Http\Controllers;

use App\Models\Cour;
use App\Models\Etudiant;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {        
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $etudiants = Etudiant::all()->toArray();
        $cours = Cour::all()->toArray();
        $datas = [
            $etudiants,
            $cours
        ];

        return view('pages.home', $datas)->with('message', ['key'=>'success', 'content'=>'Bienvenue '.Auth::user()->prenom." ".Auth::user()->nom]);
    }

}
