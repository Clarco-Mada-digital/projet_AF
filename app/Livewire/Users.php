<?php

namespace App\Livewire;

use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class Users extends Component
{
    public $search;
    public $orderField = 'nom';
    public $orderDirection = 'ASC';
    public $sectionName = 'list';

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
        Carbon::setLocale('fr');

        $data = [
            "users" => User::where("nom", "LIKE", "%{$this->search}%")
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate(5)
        ];
        return view('livewire.users.index', $data)
                ->extends('layouts.mainLayout')
                ->section('content');
    }
}
