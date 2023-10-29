<div> 

    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if( in_array(Request::segment(1), ['viaje']) && in_array(Request::segment(2), ['filter']) && request()->global == 0 ){{ 'bg-slate-900' }} @endif" x-data="{ open: {{ (in_array(Request::segment(1), ['viaje']) && in_array(Request::segment(2), ['filter']) && request()->global == 0) ? 1 : 0 }} }">
        <a class="block text-slate-200 hover:text-white truncate transition duration-150 @if(in_array(Request::segment(1), ['dashboard'])){{ 'hover:text-slate-200' }}@endif" href="#0" @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
            <div class="flex items-center justify-between ">
                <div class="flex items-center relative">
                    <i class="nav-icon fas fa-car-side text-slate-400 hover:text-indigo-500"></i>
                    <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200 ">Mis Viajes</span>
                </div>
                <!-- Icon -->
                <div class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if(in_array(Request::segment(1), ['dashboard'])){{ 'rotate-180' }}@endif" :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                    </svg>
                </div>
            </div>
        </a> 
        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
            <ul class="pl-9 mt-1 @if(!in_array(Request::segment(1), ['dashboard'])){{ 'hidden' }}@endif" :class="open ? '!block' : 'hidden'">
                <li class="mb-1 last:mb-0">
                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('dashboard')){{ '!text-indigo-500' }}@endif" 
                        href="{{ route('viajes.list',['modo' => 'fecha','data' => date('Y-m-d'),'global' => false,'tipo_usuario' => Auth::user()->roles()->first()->name] ) }}&user_id={{ Auth::user()->taxista ? Auth::user()->id : Auth::user()->id }}"> 
                        <i class="nav-icon fas fa-angle-double-right"></i>
                        <span class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Hoy</span>
                    </a>
                </li>
                <li class="mb-1 last:mb-0">
                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('analytics')){{ '!text-indigo-500' }}@endif" 
                        href="{{ route('viajes.list',['modo' => 'mes','data' => date('Y-m'),'global' => false,'tipo_usuario' => Auth::user()->roles()->first()->name] ) }}&user_id={{ Auth::user()->taxista ? Auth::user()->id : Auth::user()->id }}">
                        <i class="nav-icon fas fa-angle-double-right"></i>
                        <span class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Mes</span>
                    </a>
                </li>
                <li class="mb-1 last:mb-0">
                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate @if(Route::is('fintech')){{ '!text-indigo-500' }}@endif" href="#0"
                    onclick="window.livewire.emit('setFilter', false,'{{ Auth::user()->roles()->first()->name }}', {{ Auth::user()->id }},'rango');" 
                    data-te-toggle="modal"
                    data-te-target="#filterViajeModal"
                    data-te-ripple-init
                    data-te-ripple-color="light"
                    >
                        <i class="nav-icon fas fa-angle-double-right"></i>
                        <span class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Período</span>
                    </a>
                </li>
                @if( Auth::user()->hasRole('Administrador') || Auth::user()->hasRole('Comercial') )
                <!--<li class="mb-1 last:mb-0">
                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate relative @if(Route::is('analytics')){{ '!text-indigo-500' }}@endif" href="{{ route('viajes.list',['modo' => 'pendiente','global' => false,'tipo_usuario' => Auth::user()->roles()->first()->name]) }}&user_id={{ Auth::user()->taxista ? Auth::user()->taxista->id : Auth::user()->comercial->id }}">
                        <i class="nav-icon fas fa-angle-double-right"></i> Pendientes
                    </a>
                </li>-->
                @endif
            </ul>
        </div>
    </li>

    
</div>

