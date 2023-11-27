<?php

namespace App\Livewire;

use App\Models\Cour;
use Livewire\Component;

class Cours extends Component
{

    public $cours;

    public function __construct()
    {
        $this->cours = Cour::all();
    }
    public function render()
    {
        return view('livewire.cours.index');
    }
}
