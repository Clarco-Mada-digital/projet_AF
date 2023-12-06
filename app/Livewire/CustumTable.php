<?php

namespace App\Livewire;

use Livewire\Component;

class CustumTable extends Component
{
    public $headerList;
    public $datas;
    public $dataItems;
    public $profilDataTabs;



    public function render()
    {
        return view('livewire.components.custum-table');
    }
}
