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
        $record = Paiement::where('updated_at', '>', Carbon::today()->subDay(6))
            ->get()
            ->map(function($item) {
                // Préparer les données directement
                $date = Carbon::parse($item->updated_at);
                return [
                    'date' => $date->format('Y-m-d'),
                    'day' => $date->day,
                    'day_name' => $date->format('l'),
                    'item' => $item
                ];
            })
            ->groupBy('date') // Grouper par date
            ->map(function($group) {
                $first = $group->first();
                return [
                    'count' => $group->count(),
                    'day_name' => $first['day_name'],
                    'day' => $first['day'],
                    'date' => $first['date']
                ];
            })
            ->sortByDesc('day')
            ->values();

        $etudiants = Etudiant::all();
        $moisActuel = Carbon::now()->month;
        $newStudent = Etudiant::whereMonth('created_at', $moisActuel)->count();
                
        $studentRecord['label'] = ['Anciens', 'Nouveaux'];
        $studentRecord['data'] = [$etudiants->count() - $newStudent, $newStudent];

        foreach ($record as $row) {
            $myRecord['label'][] = $correspondanceJours[$row['day_name']];
            $myRecord['data'][] = (int) $row['count'];
        }

        
        $cours = Cour::all();

        $datas = ['etudiants' => $etudiants, 'cours' => $cours, 'paiementData' => json_encode($myRecord), 'studentData' => json_encode($studentRecord)];

        $salutationList = ['Bienvenu', 'Salut', 'Bonjour', 'Hola', 'Salama', 'Bolatsara', 'Zdravstvuyte', 'Nǐn hǎo', 'Salve', 'Konnichiwa', 'Guten Tag', 'Olá', 'Anyoung haseyo', 'Asalaam alaikum', 'Goddag', 'Shikamoo', 'Goedendag', 'Yassas', 'Dzień dobry', 'Selamat siang', 'Namaste, Namaskar', 'God dag', 'Merhaba', 'Shalom'];

        $Salutation = array_rand($salutationList);

        $request->session()->flash('message', $salutationList[$Salutation] . ' ' . Auth::user()->prenom . " " . Auth::user()->nom);


        return view('pages.home', $datas);
    }
}
