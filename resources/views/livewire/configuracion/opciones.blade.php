<div> 
    
    <div class="relative bg-indigo-200 dark:bg-indigo-500 p-4 mt-2 sm:p-6 rounded-sm overflow-hidden mb-8">

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
            <h1 class="text-2xl md:text-3xl text-slate-800 dark:text-slate-100 font-bold mb-1">Configuraciones</h1> 
        </div>
    
    </div>
    @if ($verify)
    <div>

        <div class="flex flex-wrap justify-end items-center mb-8 sm:mb-0 -space-x-3 -ml-px w-full sm:w-1/2">

            <input type="text" class="form-input w-full rounded relative" placeholder="Buscar..." wire:model="search">

            <svg class="animate-spin h-5 w-6 text-white absolute mr-1 grid hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" wire:loading.class.remove="hidden" wire:target='search' >
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>

        </div>

        <div class="mt-4">

            @foreach ($opciones as $opcion)
                <div class="my-2 grid grid-cols-1 sm:grid-cols-2 gap-4 items-end" 
                    x-data="{load: false, inicio: '{{ $opcion->valor }}',valor: '{{ $opcion->valor }}', optionId : '{{ $opcion->id }}', 
                        init(){ 
                            Livewire.on('endSave{{ $opcion->id }}', (e) => {
                                this.load = false;
                            }); 
                        } 
                    }" 
                    :key="{{ $opcion->id }}"
                >
                    <label for="{{ $opcion->clave }}">{{ $opcion->label }}</label>
                    <div>
                        <input type="text" name="{{ $opcion->clave }}" id="{{ $opcion->clave }}" x-model="valor" class="form-input w-4/5">
                        <button class="btn bg-success-500 hover:bg-success-700 hover:bg-slate-500 text-white flex-none ml-2" x-on:click="load = true; $wire.save(optionId,valor);">
                            <i class="fas fa-save" x-show="!load"></i>
                            <svg x-show="load" class="animate-spin h-5 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" >
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <hr>
            @endforeach

        </div>
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 ">
        <label for="password">Por favor ingrese su contraseña</label>
        <input type="password" class="form-input" wire:model='password'>
        @error('password')
            <span class="col-span-full text-danger-600 italic">{{ $message }}</span>
        @enderror
        <button class="btn bg-indigo-500 bg-indigo-700 text-white col-span-full mx-auto mt-2" wire:click='verificar'>
            <svg class="animate-spin h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" wire:target='verificar' wire:loading.class.remove="hidden">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Acceder
        </button>
    </div>
    @endif


</div>
