<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier si l'utilisateur est authentifié et s'il a le rôle super-admin
        if (!Auth::check() || Auth::user()->role !== 'super-admin') {
            // Retourner à la requête précédente de façon dynamique
            // return redirect()->back()->with('error', 'Vous n\'avez pas les droits nécessaires pour accéder à cette resource.');
            return redirect()->back()->with('error', 'Vous n\'avez pas les droits nécessaires pour accéder à cette resource.')->with('toast', true);

        }
        return $next($request);
    }
}
