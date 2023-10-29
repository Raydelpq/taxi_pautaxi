<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerfilEmpleado
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

        if($user->hasRole('Administrador'))
            return $next($request);

        if($user->hasRole('Comercial') && $request->segment(3) == $user->id){
            return $next($request);
        }else
            return redirect()->back()->with('status','Usted no tiene permisos para acceder a esta sección');

        //return $next($request); 
    }
}
