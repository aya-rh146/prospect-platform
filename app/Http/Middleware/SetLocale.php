<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Priorité 1: Paramètre URL ?locale=
        if ($request->has('locale') && in_array($request->get('locale'), ['fr', 'ar'])) {
            $locale = $request->get('locale');
            Session::put('locale', $locale);
        }
        // Priorité 2: Session existante
        elseif (Session::has('locale')) {
            $locale = Session::get('locale');
        }
        // Priorité 3: Langue par défaut du navigateur (avec fallback)
        else {
            $locale = 'fr'; // Langue par défaut
        }

        App::setLocale($locale);
        
        return $next($request);
    }
}
