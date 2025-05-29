<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BackupAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier si l'utilisateur a les permissions pour gérer les sauvegardes
        if (!auth()->check() || !auth()->user()->can('manage-backups')) {
            abort(403, 'Accès non autorisé');
        }
        
        return $next($request);
    }
}
