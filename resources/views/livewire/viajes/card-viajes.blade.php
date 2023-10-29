<div class="mt-2 flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
    <div class="px-5 pt-5">
        <header class="flex justify-between items-start mb-2">
           
            <p class="mx-1 w-full">{{ $viaje->costo }} CUP | Servicio asignado a 
                <a href="{{ route('taxista.show', $viaje->taxista->id) }}" class="text-blue-900 dark:text-white hover:text-blue-400 dark:hover:text-slate-900"><strong>{{ $viaje->taxista->user->name }}</strong></a>
                 por el Comercial 
                 <a href="{{ route('empleado.show', $viaje->user->comercial->id) }}" class="text-blue-900 dark:text-white hover:text-blue-400 dark:hover:text-slate-900"><strong>{{ $viaje->comercial->user->name }}</strong></a>
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
