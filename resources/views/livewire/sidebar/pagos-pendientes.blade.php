<li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 @if( in_array(Request::segment(1), ['taxista']) && request()->filtro == 'con_deuda' ){{ 'bg-slate-900' }}@endif">
    <a class="block text-slate-200 hover:text-white truncate transition duration-150 " 
        href="{{ route('taxista',['filtro' => 'con_deuda']) }}"
    >
        <div class="flex items-center relative">
            <i class="nav-icon fas fa-angle-double-right text-slate-400 hover:text-indigo-500"></i>
            <span class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Pagos Pendientes
                @if($pendiente > 0)
                
                    <span class=" ml-3 absolute inline-flex h-full w-8 rounded-full bg-red-700 opacity-75">
                        <span class="mx-auto">{{ $pendiente }}</span>
                    </span>
                @endif
            </span>
        </div>
    </a>
</li>