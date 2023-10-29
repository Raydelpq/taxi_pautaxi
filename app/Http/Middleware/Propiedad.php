<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Models\Viaje;
use App\Models\Taxista;
use App\Models\Comercial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Propiedad
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {   $user = Auth::user();

        // Paso si es Administrador
        if($user->hasRole('Administrador'))
            return $next($request);


       

        if($request->segment(1) == 'viaje'){ 
            
            if($request->segment(2) == 'show'){
                // Se localiza el viaje
                $viaje = Viaje::findOrFail($request->segment(3));
                
                // Procedimiento para Taxistas
                if($user->hasRole('Taxista'))
                    if($user->id == $viaje->taxista->user->id)
                        return $next($request);
                
                // Procedimiento para comerciales
                if($user->hasRole('Comercial'))
                    if($user->id == $viaje->user->id)
                        return $next($request);

            }else
            if($request->segment(2) == 'filter'){
                

                if( $user->hasRole('Comercial') ){
                    //$t = Comercial::findOrFail($request->user_id);
                    
                    $u = User::findOrFail($request->user_id);
                    
                    if($request->tipo_usuario == 'Comercial' && $user->id == $u->id)
                        return $next($request);

                }else
                if($user->hasRole('Taxista') ){
                    //$t = Taxista::findOrFail($request->user_id);
                    $u = User::findOrFail($request->user_id);
                    

                    if( $u->hasRole('Taxista') && $user->id == $u->id)
                    return $next($request);
                }

            }

            return redirect()->back()->with('status','Usted no tiene permisos para acceder a esta sección');
        }
        

        return $next($request);
    }
}
