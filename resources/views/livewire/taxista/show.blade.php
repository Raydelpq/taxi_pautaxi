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
            <h1 class="text-lg md:text-2xl text-center md:text-left text-slate-800 dark:text-slate-100 font-bold mb-1">{{ $taxista->user->name }} {{ $taxista->user->apellidos }}</h1>
            
        </div>
    
    </div>
    <!-- END Header -->


    <!-- Avatar e Info -->
    <div class="sm:flex md:grid md:grid-cols-2 sm:items-start mb-2"> 

        <div class="sm:col-span-1 md:col-span-1 mx-auto md:mx-0 w-full md:w-[200px]" 
            x-data="{ isUploading: false, progress: 0 }" 
            x-on:livewire-upload-start="isUploading = true" 
            x-on:livewire-upload-finish="isUploading = false; progress = 0; $wire.saveAvatar();" 
            x-on:livewire-upload-error="isUploading = false" 
            x-on:livewire-upload-progress="progress = $event.detail.progress"
        >
          
            <div class="flex flex-wrap justify-end  mb-8 sm:mb-0 -space-x-3 -ml-px w-[250px] h-[250px] relative justify-items-end items-end" >
               <img class="rounded w-full h-full" src="{{ $avatarUrl }}" alt="{{ $taxista->user->name }}">
                <div class="w-full" style="position: absolute;">
                    <button x-show="!isUploading" class="btn bg-indigo-500 hover:bg-indigo-600 text-white py-1 px-2" style="border-radius: 0px 4px 0px 4px" onclick="document.getElementById('avatar').click();">
                        <i class="fas fa-camera"></i>
                    </button>
                    <div class="w-full" x-show="isUploading" style="display: none;"> 
                        <progress class="w-full h-1.5" max="100" x-bind:value="progress"></progress> 
                    </div>
                </div>
            </div>
            <input type="file" id="avatar" wire:model="avatar" class="hidden">
        </div>

        <div class="grid col-span-2 md:col-span-1" x-data="{fondo : {{ $taxista->fondo }} }">
            <p class="">Fondo: <span :class="fondo >= 100 ? 'text-success-600' : fondo < 100 && fondo >= 40 ? 'text-warning-600' : 'text-danger-600' " x-text="fondo"></span> CUP</p> 
            <p><a href="{{ route('viajes.list',['modo' => 'fecha','data' => date('Y-m-d'),'global' => false,'tipo_usuario' => $taxista->user->roles()->first()->name, 'user_id' => $taxista->user->id] ) }}">
                Viajes de Hoy:
                </a> {{ $viajesHoy }}
            </p>
            <p><a href="{{ route('viajes.list',['modo' => 'mes','data' => date('Y-m'),'global' => false,'tipo_usuario' => $taxista->user->roles()->first()->name, 'user_id' => $taxista->user->id] ) }}">
                Viajes del Mes:</a>
                 {{ $viajesMes }}
            </p>
            <p>Total de Viajes: {{ $viajesTotal }}</p>
            <button class="btn bg-indigo-600 text-white w-32 mt-3"
                onclick="window.livewire.emit('setFilter', false,'{{ $taxista->user->roles()->first()->name }}', {{ $taxista->id }},'rango');"
                data-te-toggle="modal"
                data-te-target="#filterViajeModal"
                data-te-ripple-init
                data-te-ripple-color="light"
            >
                <i class="fas fa-filter"></i>
                Filtrar Viajes
            </button>
            @if(!Auth::user()->hasRole('Taxista'))
            <a href="https://api.whatsapp.com/send?phone={{ $taxista->user->telefono }}" target="_blank" class="mt-2 btn w-32 bg-success-600 hover:bg-success-700 text-white">
                <i class="fab fa-whatsapp"></i> whatsapp
            </a>
            @endif
            
            @role('Administrador')
            <div>
                @if(!$taxista->aprobado)
                    <button class="btn w-32 mt-2 bg-success-600 hover:bg-success-700 text-white" onclick="aprobarTaxista({{ $taxista->user->id }},'{{ $taxista->user->name }}');">
                        <svg id="aprobar" class="animate-spin h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                            wire:loading.class.remove="hidden" wire:target='aprobar'>
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Aprobar
                    </button>
                @endif
            </div>
            <div>
                @if($taxista->user->deleted_at == null)
                    <button class="btn w-32 mt-2 bg-danger-600 hover:bg-danger-700 text-white" wire:click="desactivar">
                        <svg id="desactivar" class="animate-spin h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                            wire:loading.class.remove="hidden" wire:target='desactivar'>
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Eliminar
                    </button>
                @else
                    <button class="btn w-32 mt-2 bg-success-600 hover:bg-success-700 text-white" wire:click="desactivar">
                        <svg id="desactivar" class="animate-spin h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                            wire:loading.class.remove="hidden" wire:target='desactivar'>
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Activar
                    </button>
                @endif
            </div>
            @endrole
        </div>

    </div> 
    <!-- Avatar e Info -->

    <div class="rounded-sm border-slate-900 dark:border-slate-300 " x-data="{tab: @entangle('tab')}"> 

        <div>
            <button :class=" tab == 1 ? 'bg-slate-300 dark:bg-slate-800' : 'bg-slate-900' " class="text-white px-4 py-2 -mr-1.5 rounded-tl border-t " x-on:click="tab=1;">Informacion</button>
            <button :class=" tab == 2 ? 'bg-slate-300 dark:bg-slate-800' : 'bg-slate-900' " class="text-white px-4 py-2 -mr-1.5 border-l border-slate-900 dark:border-white border-t " x-on:click="tab=2;">Auto</button>
            <button :class=" tab == 3 ? 'bg-slate-300 dark:bg-slate-800' : 'bg-slate-900' " class="text-white px-4 py-2 -mr-1.5 border-l border-slate-900 dark:border-white rounded-tr border-t" x-on:click="tab=3;">Contraseña</button>
            @if( Auth::user()->hasRole('Administrador') || Auth::user()->hasRole('Taxista') )
            <button :class=" tab == 4 ? 'bg-slate-300 dark:bg-slate-800' : 'bg-slate-900' " class="text-white px-4 py-2 -mr-1.5 border-l border-slate-900 dark:border-white rounded-tr border-t" x-on:click="tab=4;">Fondo ({{ $taxista->fondo }} CUP)</button>
            @endrole
        </div>

        <div wire:ignore.self>
            <div x-show="tab == 1" class="p-4 bg-slate-300 dark:bg-slate-800 rounded-b rounded-tr w-full">
                <livewire:taxista.informacion :taxista='$taxista' :user='$taxista->user' />
            </div>

            <div x-show="tab == 2" class="p-4 bg-slate-300 dark:bg-slate-800 rounded-b rounded-tr w-full">
                <livewire:taxista.auto :taxista='$taxista'/>
            </div>

            <div x-show="tab == 3" class="p-4 bg-slate-300 dark:bg-slate-800 rounded-b rounded-tr w-full">
                <livewire:change-password :user='$taxista->user'>
            </div>
            @if( Auth::user()->hasRole('Administrador') || Auth::user()->hasRole('Taxista') )
            <div x-show="tab == 4" class="p-4 bg-slate-300 dark:bg-slate-800 rounded-b rounded-tr w-full">
                <livewire:taxista.fondo :taxista='$taxista'>
            </div>
            @endif
        </div>

    </div>

</div>


@push('code-js')
    <script>
        window.onload = function(){
            Livewire.emit('getData');
        }

        Livewire.on('aprobado', telefono => {

            setTimeout( function(){
                window.location.href = "https://api.whatsapp.com/send?phone=+53"+telefono+"&text=Usted ha sido Registrado Correctamente en {{ config('app.name', 'ServiWeb') }} 👍"},
                1500
            );

        });

        Livewire.hook('message.sent', (message,component) => {
            if (message.updateQueue[0].payload.event === 'aprobar') {
                const el = document.getElementById('aprobar');
                el.classList.remove('hidden');
            }

            if (message.updateQueue[0].payload.event === 'desactivar') {
                const el = document.getElementById('desactivar');
                el.classList.remove('hidden');
            }
        });

        Livewire.hook('message.processed', (message,component) => {
            if (message.updateQueue[0].payload.event === 'aprobar') {
                const el = document.getElementById('aprobar');
                el.classList.add('hidden');
            }

            if (message.updateQueue[0].payload.event === 'desactivar') {
                const el = document.getElementById('desactivar');
                el.classList.add('hidden');
            }
        });

        function aprobarTaxista(user_id, name){ 
            
            Swal.fire({
                title: `Confirme que desea Aprobar a ${name}`,
                text: "¿Está seguro de aprobar al Taxista?",
                type: 'warning',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Aprobar!'
            }).then((result) => {

                if (result.isConfirmed) {
                    Livewire.emit('aprobar',user_id); 
                }
            })
        }
    </script>
@endpush