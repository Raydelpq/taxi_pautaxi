
<div class="col-span-full bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Alertas</h2>
    </header>
    <div class="p-3">

        <span class="relative inline-flex mx-1">
            <a type="button" href="{{ route('taxista') }}?filtro=por_aprobar&orderBy=name&orden=ASC" 
                class="inline-flex items-center px-4 py-2 font-semibold leading-6 text-sm shadow rounded-md text-sky-500 bg-white dark:bg-slate-800 transition ease-in-out duration-150 ring-1 ring-slate-900/10 dark:ring-slate-200/20 hover:text-white hover:bg-gradient-to-r hover:from-indigo-500 hover:to-indigo-400">
              Nuevos Taxistas
            </a>
            @if($nuevos)
                <span class="flex absolute h-3 w-3 top-0 right-0 -mt-1 -mr-1">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sky-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-sky-500"></span>
                </span>
            @endif
        </span>

        <span class="relative inline-flex mx-1">
            <a type="button" href="{{ route('taxista') }}?filtro=con_deuda&orderBy=name&orden=ASC" 
        class="inline-flex items-center px-4 py-2 font-semibold leading-6 text-sm shadow rounded-md text-sky-500 bg-white dark:bg-slate-800 transition ease-in-out duration-150 ring-1 ring-slate-900/10 dark:ring-slate-200/20 hover:text-white hover:bg-gradient-to-r hover:from-indigo-500 hover:to-indigo-400">
              Pagos Pendientes
            </a>
            @if($pagos)
                <span class="flex absolute h-3 w-3 top-0 right-0 -mt-1 -mr-1">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sky-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-sky-500"></span>
                </span>
            @endif
        </span>

        <span class="relative inline-flex mx-1">
            <a type="button" href="{{ route('cambios') }}" 
        class="inline-flex items-center px-4 py-2 font-semibold leading-6 text-sm shadow rounded-md text-sky-500 bg-white dark:bg-slate-800 transition ease-in-out duration-150 ring-1 ring-slate-900/10 dark:ring-slate-200/20 hover:text-white hover:bg-gradient-to-r hover:from-indigo-500 hover:to-indigo-400">
              Cambios Pendientes
            </a>
            @if($cambios)
                <span class="flex absolute h-3 w-3 top-0 right-0 -mt-1 -mr-1">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sky-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-sky-500"></span>
                </span>
            @endif
        </span>

    </div>
</div>

