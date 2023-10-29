<div>
    
    <div class="relative mt-2 bg-indigo-200 dark:bg-indigo-500 p-4 sm:p-6 rounded-sm overflow-hidden mb-8"> 

        <!-- Background illustration -->
        <div class="absolute right-0 top-0 -mt-4 mr-16 pointer-events-none hidden xl:block" aria-hidden="true">
            <svg width="319" height="198" xmlns:xlink="http://www.w3.org/1999/xlink">
                <defs>
                    <path id="welcome-a" d="M64 0l64 128-64-20-64 20z"></path>
                    <path id="welcome-e" d="M40 0l40 80-40-12.5L0 80z"></path>
                    <path id="welcome-g" d="M40 0l40 80-40-12.5L0 80z"></path>
                    <linearGradient x1="50%" y1="0%" x2="50%" y2="100%" id="welcome-b">
                        <stop stop-color="#A5B4FC" offset="0%"></stop>
                        <stop stop-color="#818CF8" offset="100%"></stop>
                    </linearGradient>
                    <linearGradient x1="50%" y1="24.537%" x2="50%" y2="100%" id="welcome-c">
                        <stop stop-color="#4338CA" offset="0%"></stop>
                        <stop stop-color="#6366F1" stop-opacity="0" offset="100%"></stop>
                    </linearGradient>
                </defs>
                <g fill="none" fill-rule="evenodd">
                    <g transform="rotate(64 36.592 105.604)">
                        <mask id="welcome-d" fill="#fff">
                            <use xlink:href="#welcome-a"></use>
                        </mask>
                        <use fill="url(#welcome-b)" xlink:href="#welcome-a"></use>
                        <path fill="url(#welcome-c)" mask="url(#welcome-d)" d="M64-24h80v152H64z"></path>
                    </g>
                    <g transform="rotate(-51 91.324 -105.372)">
                        <mask id="welcome-f" fill="#fff">
                            <use xlink:href="#welcome-e"></use>
                        </mask>
                        <use fill="url(#welcome-b)" xlink:href="#welcome-e"></use>
                        <path fill="url(#welcome-c)" mask="url(#welcome-f)" d="M40.333-15.147h50v95h-50z"></path>
                    </g>
                    <g transform="rotate(44 61.546 392.623)">
                        <mask id="welcome-h" fill="#fff">
                            <use xlink:href="#welcome-g"></use>
                        </mask>
                        <use fill="url(#welcome-b)" xlink:href="#welcome-g"></use>
                        <path fill="url(#welcome-c)" mask="url(#welcome-h)" d="M40.333-15.147h50v95h-50z"></path>
                    </g>
                </g>
            </svg>
        </div>
    
        <!-- Content -->
        <div class="relative">
            <h1 class="text-lg md:text-2xl text-center md:text-left text-slate-800 dark:text-slate-100 font-bold mb-1">{{ $title }}</h1>
            
        </div>
    
    </div>

    <div class="sm:flex sm:justify-between sm:items-center mb-2">

        <div class="flex flex-wrap justify-end items-center mb-8 sm:mb-0 -space-x-3 -ml-px w-full sm:w-1/2">

           <input type="text" class="form-input w-full rounded relative" placeholder="Buscar..." wire:model="search">

           <svg class="animate-spin h-5 w-6 text-white absolute mr-1 grid hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" wire:loading.class.remove="hidden" wire:target='search' >
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>

        </div>

        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

            <!-- Boton de Filtrar -->
            <div class="relative inline-flex items-end" x-data="{ open: false }">
                <button class="btn bg-white dark:bg-slate-800 border-slate-200 hover:border-slate-300 dark:border-slate-700 dark:hover:border-slate-600 text-slate-500 hover:text-slate-600 dark:text-slate-400 dark:hover:text-slate-300" aria-haspopup="true" @click.prevent="open = !open" :aria-expanded="open" aria-expanded="true">
                    <span class="sr-only">Filter</span><wbr>
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 16 16">
                        <path d="M9 15H7a1 1 0 010-2h2a1 1 0 010 2zM11 11H5a1 1 0 010-2h6a1 1 0 010 2zM13 7H3a1 1 0 010-2h10a1 1 0 010 2zM15 3H1a1 1 0 010-2h14a1 1 0 010 2z"></path>
                    </svg>
                </button>
                <div class="origin-top-right z-10 absolute top-full left-0 right-auto min-w-56 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 pt-1.5 rounded shadow-lg overflow-hidden mt-1 md:left-auto md:right-0" @click.outside="open = false" @keydown.escape.window="open = false" x-show="open" x-transition:enter="transition ease-out duration-200 transform" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-out duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                    <div class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase pt-1.5 pb-2 px-3">Filtros</div>
                    <ul class="mb-4">
                       
                        <span wire:loading.remove wire:target='filtro'>
                            <span class="2xl:block">Ordenar Por:</span>
                            <li class="py-1 px-3">
                                <label class="flex items-center">
                                    <input type="radio" name="filtro" class="form-radio" wire:model="filtro" value="numero-Asc">
                                    <span class="text-sm font-medium ml-2">Teléfono Ascendente</span>
                                </label>
                            </li>
                            <li class="py-1 px-3">
                                <label class="flex items-center">
                                    <input type="radio" name="filtro" class="form-radio" wire:model="filtro" value="numero-Desc">
                                    <span class="text-sm font-medium ml-2">Teléfono Descendente</span>
                                </label>
                            </li>

                            <li class="py-1 px-3">
                                <label class="flex items-center">
                                    <input type="radio" name="filtro" class="form-radio" wire:model="filtro" value="viajes-Asc">
                                    <span class="text-sm font-medium ml-2">Viajes Ascendente</span>
                                </label>
                            </li>
                            <li class="py-1 px-3">
                                <label class="flex items-center">
                                    <input type="radio" name="filtro" class="form-radio" wire:model="filtro" value="viajes-Desc">
                                    <span class="text-sm font-medium ml-2">Viajes Descendente</span>
                                </label>
                            </li>
                        </span>

                        <span wire:loading.class.remove="hidden" wire:target='filtro' class="w-full grid justify-center hidden"> 
                            <svg class="animate-spin h-5 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" >
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                        
                    </ul>
                    <div class="py-2 px-3 border-t border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-700/20">
                        <ul class="flex items-center justify-between">
                            <li>
                                
                            </li>
                            <li>
                                <button class="btn-xs bg-indigo-500 hover:bg-indigo-600 text-white" @click="open = false" @focusout="open = false">Cerrar</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div id="resultado" class="" >
        
        @if($clientes->lastPage() > 1)
            <div class="bg-slate-800 dark:bg-slate-600 p-4 m-2 md:mx-0 rounded-t text-slate-300">
                {{ $clientes->links() }}
            </div>
        @endif

        

        <div class="p-3">
    
            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="table-auto w-full">
                    <!-- Table header -->
                    <thead class="text-xs font-semibold uppercase text-slate-400 dark:text-slate-500 bg-slate-50 dark:bg-slate-700 dark:bg-opacity-50">
                        <tr>
                            <th class="p-2 whitespace-nowrap">
                                <div class="font-semibold text-left">Teléfono</div>
                            </th>
                            <th class="p-2 whitespace-nowrap">
                                <div class="font-semibold text-left">Viajes</div>
                            </th>
                        </tr>
                    </thead>
                    <!-- Table body -->
                    <tbody class="text-sm divide-y divide-slate-100 dark:divide-slate-700">

                        @forelse ($clientes as $key => $cliente) 
                            <tr>
                                
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-left font-medium text-green-500"><a href="{{ route('cliente.show', $cliente->id) }}">{{ $cliente->numero }}</a></div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-lg text-center">{{ count($cliente->viajes) }}</div>
                                </td>
                            </tr>
                        @empty
                            <div class="grid grid-cols-1 md:grid-cols-2">
                                <h3 class="text-7xl text-center col-span-full mt-4  animate-bounce">😔</h3>
                                <p class="mt-4 text-xl md:text-5xl col-span-full underline decoration-red-700">Lo sentimos, no se han encontrado Taxistas.</p>
                            </div>
                        @endforelse
                    </tbody>
                </table>
            
            </div>
        
        </div>

        
        

        @if($clientes->lastPage() > 1)
            <div class="bg-slate-800 dark:bg-slate-600 p-4 m-2 md:mx-0 rounded-b text-slate-300">
                {{ $clientes->links() }}
            </div>
        @endif
    </div>

</div>
