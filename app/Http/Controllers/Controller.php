<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function contains($container, $contenu)
    {
        return Str::contains($container, $contenu);
    }

    public function userFullName()
    {
        $fullname = Auth::user()->prenom . " " . Auth::user()->nom;
        return $fullname;
    }
}
