<?php

namespace App\Livewire;

use App\Models\Cour;
use Carbon\Carbon;
use Livewire\Component;

class AsideMenu extends Component
{
    public $cours;
    public bool $tagNew = false;
    public $now;

    public function mount()
    {
        $this->now = Carbon::today();
        $this->cours = Cour::all();
        foreach($this->cours as $cour)
        {
            if ($cour->created_at->addDays(30) > $this->now)
            {
                $this->tagNew = true;
            }
        }
    }

    public function render()
    {
        $data = [
            'cours' => $this->cours
        ];
        
        return view('livewire.components.aside-menu', $data);
    }
}
