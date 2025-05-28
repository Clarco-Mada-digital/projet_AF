<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EtudiantController extends Controller
{
    #login_required()
    public function index()
    {
        $name = Auth::user()->nom;
        return view('pages.new-etudiant');
    }
}
