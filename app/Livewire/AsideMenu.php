<?php

namespace App\Livewire;

use App\Models\Cour;
use Livewire\Component;

class AsideMenu extends Component
{
    public $cours;

    public function mount()
    {
        $this->cours = Cour::all();
    }

    public function render()
    {
        $data = [
            'cours' => $this->cours
        ];
        return view('livewire.components.aside-menu', $data);
    }
}
