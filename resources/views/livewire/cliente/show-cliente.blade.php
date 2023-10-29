<div>
    <!-- Header -->
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
    <!-- END Header -->

    @if($viajes->lastPage() > 1)
        <div class="bg-slate-800 dark:bg-slate-600 p-4 m-2 md:mx-0 rounded-t text-slate-300"> 
            {{ $viajes->links() }}
        </div>
    @endif

    <div>
        @foreach ($viajes as $key => $viaje)
        <div class="mt-2 flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
            <div class="px-5 pt-5">
                <header class="flex justify-between items-start mb-2">
                   
                    <p class="mx-1 w-full">{{ $viaje->costo }} CUP 
                        @if($viaje->taxista_id)
                        | Servicio asignado a 
                        <a href="{{ route('taxista.show', $viaje->taxista->id) }}" class="text-blue-900 dark:text-white hover:text-blue-400 dark:hover:text-slate-900">
                            <strong>{{ $viaje->taxista->user->name }}</strong>
                        </a> por el Comercial 
                        @else
                        |<strong class="text-danger-700"> Por Aprobar</strong> del comercial 
                        @endif
                        
                         <a href="{{ route('empleado.show', $viaje->user->id) }}" class="text-blue-900 dark:text-white hover:text-blue-400 dark:hover:text-slate-900">
                            <strong>{{ $viaje->user->name }}</strong>
                        </a>
                    </p>
                    
                    <!-- Menu button -->
                    <div class="relative inline-flex" x-data="{ open: false }">
                        <button class="rounded-full text-slate-400 hover:text-slate-500 dark:text-slate-500 dark:hover:text-slate-400" :class="open ? 'bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400': 'text-slate-400 hover:text-slate-500 dark:text-slate-500 dark:hover:text-slate-400'" aria-haspopup="true" @click.prevent="open = !open" :aria-expanded="open" aria-expanded="false">
                            <span class="sr-only">Menu</span>
                            <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                <circle cx="16" cy="16" r="2"></circle>
                                <circle cx="10" cy="16" r="2"></circle>
                                <circle cx="22" cy="16" r="2"></circle>
                            </svg>
                        </button>
                        <div class="origin-top-right z-10 absolute top-full right-0 min-w-36 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 py-1.5 rounded shadow-lg overflow-hidden mt-1" @click.outside="open = false" @keydown.escape.window="open = false" x-show="open" x-transition:enter="transition ease-out duration-200 transform" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-out duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;">
                            <ul>
                                <li>
                                    <a class="font-medium text-sm text-slate-600 dark:text-slate-300 hover:text-blslateue-800 dark:hover:text-slate-200 flex py-1 px-3" href="{{ route('viaje.add', ['copy'=> $viaje->id]) }}" @click="open = false" @focus="open = true" @focusout="open = false"><i class="mt-1.5 mr-2 fas fa-copy"></i> Copiar</a>
                                </li>
                                <li>
                                    <a class="font-medium text-sm text-blue-600 dark:text-blue-300 hover:text-blue-800 dark:hover:text-blue-200 flex py-1 px-3" href="{{ route('viajes.show',$viaje->id) }}" @click="open = false" @focus="open = true" @focusout="open = false"><i class="mt-1.5 mr-2 fas fa-eye"></i> Ver</a>
                                </li>
                                <li>
                                    <a class="font-medium text-sm text-success-600 dark:text-success-300 hover:text-success-800 dark:hover:text-success-200 flex py-1 px-3" href="{{ route('viaje.add', ['edit'=> $viaje->id]) }}" @click="open = false" @focus="open = true" @focusout="open = false"><i class="mt-1.5 mr-2 fas fa-edit"></i> Editar</a>
                                </li>
                                <li>
                                    <a class="font-medium text-sm text-rose-500 hover:text-rose-600 flex py-1 px-3" href="#0" @click="open = false" @focus="open = true" @focusout="open = false"><i class="mt-1.5 mr-2 fas fa-trash-alt"></i> Eliminar</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </header>
        
                <div class="flex justify-end">
                    <small class="float-right text-xs text-right font-semibold text-slate-800 dark:text-slate-100 mb-2"><i class="far fa-clock"></i> {{ $viaje->created_at->format('d m Y h:i A') }}</small>
                </div>
        
                <div class="w-full mb-3 bg-slate-300 dark:bg-slate-900 p-4 rounded">
                    <p> <span class="text-slate-950 dark:text-slate-300">Desde: </span> {{ $viaje->origen }}  
        
                        @foreach ($viaje->paradas as $parada)
                            <i class="fas fa-long-arrow-alt-right"></i>
                            {{ $parada->nombre }}
                        @endforeach
            
                        <i class="fas fa-long-arrow-alt-right"></i>
                        {{ $viaje->destino }}
                    </p>
                </div>
            </div>
        
        </div>
        
        @endforeach
    </div>

    @if($viajes->lastPage() > 1)
        <div class="bg-slate-800 dark:bg-slate-600 p-4 m-2 md:mx-0 rounded-b text-slate-300">
            {{ $viajes->links() }}
        </div>
    @endif

</div> 
 