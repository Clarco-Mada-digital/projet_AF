<?php

namespace App\Http\Controllers;

use App\Models\Cour;
use App\Models\Etudiant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public $now;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {        
        $this->now = Carbon::now();
        $this->middleware('auth');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $etudiants = Etudiant::all();
        $cours = Cour::all();
        $datas =['etudiants'=>$etudiants, 'cours'=>$cours];

        $salutationList = ['Bienvenu', 'Salut', 'Bonjour', 'Hola', 'Salama', 'Bolatsara'];

        $Salutation = array_rand($salutationList);

        $request->session()->flash('message', $salutationList[$Salutation].' '.Auth::user()->prenom." ".Auth::user()->nom);
        

        return view('pages.home', $datas);
    }

}
