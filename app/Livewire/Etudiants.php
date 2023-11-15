<?php

namespace App\Livewire;

use App\Models\Etudiant;
use Livewire\Component;
use Livewire\WithPagination;

class Etudiants extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public function render()
    {
        return view('livewire.etudiants',[
            'etudiants' => Etudiant::paginate(5)
        ])->extends('layouts.mainLayout')
          ->section('content');
    }
}
