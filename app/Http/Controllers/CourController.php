<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class CourController extends Controller
{
    public function index(){
        return view('pages.cour');
    }

    public function nouveau(){
        return view('livewire.cours.new-cour');
    }
}
