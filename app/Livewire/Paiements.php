<?php

namespace App\Livewire;

use App\Models\Paiement;
use Livewire\Component;
use Livewire\WithPagination;

class Paiements extends Component
{
    use WithPagination;

    protected $paginationTheme = "bootstrap"; 

    public string $search = "";

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

    public function render()
    {
        $datas = [
            'paiements' => Paiement::where("numRecue", "LIKE", "%{$this->search}%")
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate(5)
        ];
        return view('livewire.paiements.index', $datas)
            ->extends('layouts.mainLayout')
            ->section('content');
    }
}
