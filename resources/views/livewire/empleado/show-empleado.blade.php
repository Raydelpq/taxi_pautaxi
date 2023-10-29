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
            <h1 class="text-lg md:text-2xl text-center md:text-left text-slate-800 dark:text-slate-100 font-bold mb-1">{{ $empleado->name }} {{ $empleado->apellidos }}</h1>
            
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
               <img class="rounded w-full h-full" src="@if($avatar) {{ $avatar->temporaryUrl() }} @else {{ $avatarUrl }} @endif" alt="{{ $empleado->name }}">
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

        <div class="grid col-span-2 md:col-span-1">
            @php
                $typeUser = $empleado->roles()->first()->name;
            @endphp
            <p><a href="{{ route('viajes.list',['modo' => 'fecha','data' => date('Y-m-d'),'global' => false,'tipo_usuario' => $typeUser, 'user_id' => $comercial_id] ) }}">
                Viajes de Hoy:
                </a> {{ $viajesHoy }}
            </p>
            <!-- data=2023-09-01+a+2023-09-10&global=0&tipo_usuario=Comercial&user_id=3  -->
            <p><a href="{{ route('viajes.list',['modo' => 'rango','global' => false,'tipo_usuario' => $typeUser, 'user_id' => $comercial_id]) }}&data={{ $star }}+a+{{ date('Y-m-d') }}">
                Viajes de Semana:
                </a> {{ $viajesSemana }}
            </p>
            <p>
                <a href="{{ route('viajes.list',['modo' => 'mes','data' => date('Y-m'),'global' => false,'tipo_usuario' => $typeUser, 'user_id' => $comercial_id] ) }}">
                    Viajes del Mes:
                </a> {{ $viajesMes }}
            </p>
            <p>Total de Viajes: {{ $viajesTotal }}</p>
            <button class="btn bg-indigo-600 text-white w-[132px] mt-3"
                onclick="window.livewire.emit('setFilter', false,'{{ $typeUser }}', {{ $empleado->id }},'rango');"
                data-te-toggle="modal"
                data-te-target="#filterViajeModal"
                data-te-ripple-init
                data-te-ripple-color="light"
            >
                <i class="fas fa-filter"></i> &nbsp;
                Filtrar Viajes
            </button>

            @role('Administrador')
            <div class="my-2">
                <input class="mr-2 mt-[0.3rem] h-3.5 w-8 appearance-none rounded-[0.4375rem] bg-neutral-300 before:pointer-events-none before:absolute before:h-3.5 before:w-3.5 before:rounded-full before:bg-transparent before:content-[''] after:absolute after:z-[2] after:-mt-[0.1875rem] after:h-5 after:w-5 after:rounded-full after:border-none after:bg-neutral-100 after:shadow-[0_0px_3px_0_rgb(0_0_0_/_7%),_0_2px_2px_0_rgb(0_0_0_/_4%)] after:transition-[background-color_0.2s,transform_0.2s] after:content-[''] checked:bg-primary checked:after:absolute checked:after:z-[2] checked:after:-mt-[3px] checked:after:ml-[1.0625rem] checked:after:h-5 checked:after:w-5 checked:after:rounded-full checked:after:border-none checked:after:bg-primary checked:after:shadow-[0_3px_1px_-2px_rgba(0,0,0,0.2),_0_2px_2px_0_rgba(0,0,0,0.14),_0_1px_5px_0_rgba(0,0,0,0.12)] checked:after:transition-[background-color_0.2s,transform_0.2s] checked:after:content-[''] hover:cursor-pointer focus:outline-none focus:ring-0 focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[3px_-1px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-5 focus:after:w-5 focus:after:rounded-full focus:after:content-[''] checked:focus:border-primary checked:focus:bg-primary checked:focus:before:ml-[1.0625rem] checked:focus:before:scale-100 checked:focus:before:shadow-[3px_-1px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] dark:bg-neutral-600 dark:after:bg-neutral-400 dark:checked:bg-primary dark:checked:after:bg-primary dark:focus:before:shadow-[3px_-1px_0px_13px_rgba(255,255,255,0.4)] dark:checked:focus:before:shadow-[3px_-1px_0px_13px_#3b71ca]"
                       type="checkbox"
                       role="switch"
                       id="flexSwitchCheckDefault" 
                       wire:model="isEconomico"
                       wire:change="setEconomico({{ $empleado->id }},'{{ $typeUser }}')"/>
                <label class="inline-block pl-[0.15rem] hover:cursor-pointer" for="flexSwitchCheckDefault" >¿Es Económico(a)?</label>

            </div>
            <div>
                @if($empleado->deleted_at == null)
                    <button class="btn w-32 mt-2 bg-danger-600 hover:bg-danger-700 text-white" wire:click="desactivar">
                        Desactivar
                    </button>
                @else
                    <button class="btn w-32 mt-2 bg-success-600 hover:bg-success-700 text-white" wire:click="desactivar">
                        Activar
                    </button>
                @endif
            </div>
            @endrole
        </div>

    </div> 
    <!-- Avatar e Info -->

    <div class="rounded-sm border-slate-900 dark:border-slate-300 " x-data="{tab: @entangle('tab')}">

        <div wire:ignore>
            <button :class=" tab == 1 ? 'bg-slate-300 dark:bg-slate-800' : 'bg-slate-900' " class="text-white px-4 py-2 -mr-1.5 rounded-tl border-t " x-on:click="tab=1;">Informacion</button>
            <button :class=" tab == 2 ? 'bg-slate-300 dark:bg-slate-800' : 'bg-slate-900' " class="text-white px-4 py-2 -mr-1.5 border-l border-white rounded-tr border-t" x-on:click="tab=2;">Contraseña</button>
            <button class="text-white px-4 py-2 -mr-1.5 border-l border-white rounded-tr border-t bg-indigo-700 dark:bg-indigo-500" >Salario: {{ $salario }} CUP</button>
        </div>

        <div wire:ignore.self>
            <div x-show="tab == 1" class="p-4 bg-slate-300 dark:bg-slate-800 rounded-b rounded-tr w-full">
                <livewire:empleado.informacion :user='$empleado'> 
            </div>

            <div x-show="tab == 2" class="p-4 bg-slate-300 dark:bg-slate-800 rounded-b rounded-tr w-full"> 
                <livewire:change-password :user='$empleado'> 
            </div>
        </div>

    </div>

</div>


@push('code-js')
    <script>
        window.onload = function(){
            Livewire.emit('getData');
        }
    </script>
@endpush