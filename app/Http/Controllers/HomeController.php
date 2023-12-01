<?php

namespace App\Http\Controllers;

use App\Models\Cour;
use App\Models\Etudiant;
use Carbon\Carbon;

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
    public function index()
    {
        $etudiants = Etudiant::all();
        $cours = Cour::all();
        $datas =['etudiants'=>$etudiants, 'cours'=>$cours];
        

        return view('pages.home', $datas);
    }

}
