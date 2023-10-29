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

            <div>
                <input type="checkbox" class="form-checkbox" wire:model="eliminados" id="eliminados">
                <label for="eliminados">Solo Mostrar Eliminados</label> 
            </div>

            <a href="{{ route('empleado.add') }}" class="btn bg-indigo-500 hover:bg-indigo-700 text-white">
                <i class="fas fa-user-plus"></i> &nbsp;
                Agregar
            </a>
        </div>

    </div>


    <div id="resultado" class="" >
        
        @if($empleados->lastPage() > 1)
            <div class="bg-slate-800 dark:bg-slate-600 p-4 m-2 md:mx-0 rounded-t text-slate-300">
                {{ $empleados->links() }}
            </div>
        @endif

        <div>
        @forelse ($empleados as $key => $empleado) 
        <div  class="mt-2 flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
            <div class="px-5 pt-5">
                <header class="flex justify-between items-start mb-2">
                   
                    <div>
                        <img class="w-8 h-8 rounded-full border" src="{{ $empleado->getMedia('avatar')->first() ? $empleado->getMedia('avatar')->first()->getFullUrl() : asset('img/no-avatar.png') }}" alt="{{ $empleado->name }}">
                    </div>
                    
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
                                    <a class="font-medium text-sm text-blue-600 dark:text-blue-300 hover:text-blue-800 dark:hover:text-blue-200 flex py-1 px-3" href="{{ route('empleado.show',$empleado->id) }}" @click="open = false" @focus="open = true" @focusout="open = false"><i class="mt-1.5 mr-2 fas fa-eye"></i> Ver</a>
                                </li>
                                @if($empleado->deleted_at)
                                <li>
                                    <a class="font-medium text-sm text-success-500 hover:text-success-600 flex py-1 px-3" href="#0" onclick="restarEmpleado({{ $empleado->id }},'{{ $empleado->name }}');" @click="open = false" @focus="open = true" @focusout="open = false"><i class="mt-1.5 mr-2 fas fa-undo"></i> Restaurar</a>
                                </li>
                                @else
                                <li>
                                    <a class="font-medium text-sm text-rose-500 hover:text-rose-600 flex py-1 px-3" href="#0" onclick="deleteEmpleado({{ $empleado->id }},'{{ $empleado->name }}');" @click="open = false" @focus="open = true" @focusout="open = false"><i class="mt-1.5 mr-2 fas fa-trash-alt"></i> Eliminar</a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </header>
        
                <div class="flex justify-end">
                    <small class="float-right text-xs text-right font-semibold text-slate-800 dark:text-slate-100 mb-2 italic">
                        {{ $empleado->roles()->first()->name }}
                    </small>
                </div>
        
                <div class="w-full mb-3 bg-slate-300 dark:bg-slate-900 p-4 rounded">
                    <p class="mx-1 w-full">{{ $empleado->name }} {{ $empleado->apellidos }}</p>
                    <p>
                        Telefono: <a class="text-slate-900 dark:text-slate-300" href="tel:{{ $empleado->telefono }}"><strong>{{ $empleado->telefono }}</strong></a>
                    </p>
                </div>
            </div>
        
        </div>
        
        @empty
            <div class="grid grid-cols-1 md:grid-cols-2">
                <h3 class="text-7xl text-center col-span-full mt-4  animate-bounce">😔</h3>
                <p class="mt-4 text-xl md:text-5xl col-span-full underline decoration-red-700">Lo sentimos, no se han encontrado Empleados.</p>
        </div>
        @endforelse
        </div>

        @if($empleados->lastPage() > 1)
            <div class="bg-slate-800 dark:bg-slate-600 p-4 m-2 md:mx-0 rounded-b text-slate-300">
                {{ $empleados->links() }}
            </div>
        @endif
    </div>

</div>

@push('code-js')
    <script>
        function deleteEmpleado(user_id, name){
            
            Swal.fire({
                title: `Confirme que desea Eliminar ${name}`,
                text: "¿Está seguro de eliminar al Empleado?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar!'
            }).then((result) => {

                if (result.isConfirmed) {
                    Livewire.emit('delete',user_id); 
                }
            })
        }

        function restarEmpleado(user_id, name){
            
            Swal.fire({
                title: `Confirme que desea Restablecer a ${name}`,
                text: "¿Está seguro de restablecer al Empleado?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Restablecer!'
            }).then((result) => {

                if (result.isConfirmed) {
                    Livewire.emit('restar',user_id); 
                }
            })
        }

    </script>
@endpush
