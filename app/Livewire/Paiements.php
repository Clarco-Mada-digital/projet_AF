<?php

namespace App\Livewire;

use App\Models\Paiement;
use App\Models\Session;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;


#[Layout('layouts.mainLayout')]
class Paiements extends Component
{
    use WithPagination;

    protected $paginationTheme = "bootstrap"; 

    public string $search = "";
    public $filteredByDatePaiement = '';
    public $filteredBySessions = '';
    public $sessions = ""; 
    public $showUser ;

    public $orderDirection = 'DESC';
    public $orderField = 'created_at';

    public function __construct() {
        $this->sessions = Session::all();
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

    public function intiUserShow(User $idUser)
    {
        $this->showUser = $idUser;
        // dd($this->showUser);
    }

    public function render()
    {
        Carbon::setLocale('fr');
        if ($this->filteredBySessions != '')
        {
            $paiements = Paiement::with("inscription")                        
                ->where(function ($query) {
                    $query->where("numRecue", "LIKE", "%{$this->search}%")
                    ->orWhere("motif", "LIKE", "%{$this->search}%");
                })
                ->WhereHas("inscription", function($qr){
                    $qr->with('session')->WhereHas("session", function($q){
                        $q->where("id", "LIKE", "%{$this->filteredBySessions}%");
                    });
                })                 
                ->where(function($qr) {
                    if($this->filteredByDatePaiement == "toDay"){
                        $qr->whereDate('created_at', Carbon::today());
                    }
                    if($this->filteredByDatePaiement == "thisWeek"){
                        $qr->whereBetween("created_at", [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    }
                    if($this->filteredByDatePaiement == "thisMonth"){
                        $qr->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
                    }
                    else{
                        return $qr;
                    }
                })        
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate(5);
        }
        else
        {
            $paiements = Paiement::with("inscription")                        
                ->where(function ($query) {
                    $query->where("numRecue", "LIKE", "%{$this->search}%")
                    ->orWhere("motif", "LIKE", "%{$this->search}%");
                })                
                ->where(function($qr) {
                    if($this->filteredByDatePaiement == "toDay"){
                        $qr->whereDate('created_at', Carbon::today());
                    }
                    if($this->filteredByDatePaiement == "thisWeek"){
                        $qr->whereBetween("created_at", [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    }
                    if($this->filteredByDatePaiement == "thisMonth"){
                        $qr->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
                    }
                    else{
                        return $qr;
                    }
                })        
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate(5);
        }
        
        // $paiements = Paiement::paginate(5);

        $totauxPaiement = 0;
        foreach($paiements as $paiement)
        {
            $totauxPaiement += $paiement->montant;
        }
        
        $datas = [
            "paiements" => $paiements,
            "paiementTotal" => $totauxPaiement
        ];
        return view('livewire.paiements.index', $datas);
    }
}
