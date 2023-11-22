<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

define("LISTPAGE", 'list');
define("VIEWPAGE", 'view');
define("EDITPAGE", 'edit');

function userFullName(){
   $fullname = Auth::user()->prenom." ".Auth::user()->nom;
   return $fullname;
}

function contains($container, $contenu){
   return Str::contains($container, $contenu);
}

function setMenuClass($route, $class){
   $ourRoute = request()->route()->getName();
   if(contains($ourRoute, $route)){
      return $class;
   }
   return '';
}

function setActiveClass($route){
   $ourRoute = request()->route()->getName();
   if($ourRoute === $route){
      return 'active';
   }
   return '';
}