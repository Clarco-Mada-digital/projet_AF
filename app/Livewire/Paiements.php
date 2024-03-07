<?php

namespace App\Livewire;

use App\Models\Paiement;
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
    public string $filteredByDatePaiement = '';
    public $showUser ;

    public $orderDirection = 'ASC';
    public $orderField = 'numRecue';


    public function setOrderField(string $name)
    {
        if ($name === $this->orderField) {
            $this->orderDirection = $this->orderDirection === 'ASC' ? 'DESC' : 'ASC';
        } else {
            $this->orderField = $name;
            $this->reset('orderDirection');
        }
    }

    public function intiUserShow(User $idUser){
        $this->showUser = $idUser;
        // dd($this->showUser);
    }

    public function render()
    {
        Carbon::setLocale('fr');
        
        $datas = [
            'paiements' => Paiement::where(function ($query) {
                $query->where("numRecue", "LIKE", "%{$this->search}%")
                ->orWhere("motif", "LIKE", "%{$this->search}%");
                })
                // ->where("created_at", "<", Carbon::today()->subDay("%{$this->filteredByDatePaiement}%"))        
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate(5)
        ];
        return view('livewire.paiements.index', $datas);
    }
}
