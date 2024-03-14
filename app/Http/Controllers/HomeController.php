<?php

namespace App\Http\Controllers;

use App\Models\Cour;
use App\Models\Etudiant;
use App\Models\Paiement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public $now;
    public $newCours = [];

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
        Carbon::setLocale('fr');

        // Test pour charte js
        $correspondanceJours = [
            "Sunday" => "Dimanche",
            "Monday" => "Lundi",
            "Tuesday" => "Mardi",
            "Wednesday" => "Mercredi",
            "Thursday" => "Jeudi",
            "Friday" => "Vendredi",
            "Saturday" => "Samedi"
        ];
        $myRecord = [];
        $studentRecord = [];
        $record = Paiement::select(DB::raw("COUNT(*) as count"), DB::raw("DAYNAME(updated_at) as day_name"), DB::raw("DAY(updated_at) as day"))->where('updated_at', '>', Carbon::today()->subDay(6))
            ->groupBy('day_name', 'day')
            ->orderBy('day', 'DESC')
            ->get();
        $etudiants = Etudiant::all();
        $moisActuel = Carbon::now()->month;
        $newStudent = Etudiant::whereMonth('created_at', $moisActuel)->count();
             
        $studentRecord['label'] = ['Anciens', 'Nouveaux'];
        $studentRecord['data'] = [$etudiants->count() - $newStudent, $newStudent];
        foreach ($record as $row) {
            $myRecord['label'][] = $correspondanceJours[$row->day_name];
            $myRecord['data'][] = (int) $row->count;
        }

        
        $cours = Cour::all();

        $datas = ['etudiants' => $etudiants, 'cours' => $cours, 'paiementData' => json_encode($myRecord), 'studentData' => json_encode($studentRecord)];

        $salutationList = ['Bienvenu', 'Salut', 'Bonjour', 'Hola', 'Salama', 'Bolatsara', 'Zdravstvuyte', 'Nǐn hǎo', 'Salve', 'Konnichiwa', 'Guten Tag', 'Olá', 'Anyoung haseyo', 'Asalaam alaikum', 'Goddag', 'Shikamoo', 'Goedendag', 'Yassas', 'Dzień dobry', 'Selamat siang', 'Namaste, Namaskar', 'God dag', 'Merhaba', 'Shalom'];

        $Salutation = array_rand($salutationList);

        $request->session()->flash('message', $salutationList[$Salutation] . ' ' . Auth::user()->prenom . " " . Auth::user()->nom);


        return view('pages.home', $datas);
    }
}
