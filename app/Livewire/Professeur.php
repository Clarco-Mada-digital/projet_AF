<?php

namespace App\Livewire;

use App\Models\Professeur as ModelsProfesseur;
use Livewire\Component;


class Professeur extends Component
{
    public $search;
    public $orderDirection = 'ASC';
    public $orderField = 'nom';

    protected $queryString = [
        'search' => ['except' => '']
    ];
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
        $data = [
            "professeurs" => ModelsProfesseur::where("nom", "LIKE", "%{$this->search}%")
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate(5)
        ];


        return view('livewire.professeur', $data)
            ->extends('layouts.mainLayout')
            ->section('content');
    }
}
