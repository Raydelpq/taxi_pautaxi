<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerfilTaxista
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
        $user = Auth::user();

        if($user->hasRole('Comercial'))
            return redirect()->back()->with('status','Usted no tiene permisos para acceder a esta sección');

        if($user->hasRole('Administrador'))
            return $next($request);

        
        if($user->hasRole('Taxista') && $request->segment(3) != $user->taxista->id)
            return redirect()->back()->with('status','Usted no tiene permisos para acceder a esta sección');

        return $next($request);
    }
}
