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
    
    <div class="mx-auto" x-data="{opcion : @entangle('type')}">

        <div class="w-[220px] mx-auto my-2">
            <button :class="opcion == 'Comercial' ? 'bg-success-500' : 'bg-indigo-500' " wire:click="changeType('Comercial')" class="btn text-white">Comercial</button>
            <button :class="opcion == 'Administrador' ? 'bg-success-500' : 'bg-indigo-500' " wire:click="changeType('Administrador')" class="btn text-white">Administrador</button>
        </div>

    </div>

    @if($type != null)
    <div class="mt-3" x-data="{type: 'password', check: false,
        change(){
            if(this.check == false)
                this.type = 'text';
            else
                this.type = 'password';
        }
    }">

        <div class="sm:col-span-1 md:col-span-1 mx-auto md:mx-0 w-full md:w-[200px]" 
            x-data="{ isUploading: false, progress: 0 }" 
            x-on:livewire-upload-start="isUploading = true" 
            x-on:livewire-upload-finish="isUploading = false; progress = 0;" 
            x-on:livewire-upload-error="isUploading = false" 
            x-on:livewire-upload-progress="progress = $event.detail.progress"
        >
          
            <div class="flex flex-wrap justify-end  mb-8 sm:mb-0 -space-x-3 -ml-px w-[250px] h-[250px] relative justify-items-end items-end" >
               <img class="rounded w-full h-full" src="@if($avatar) {{ $avatar->temporaryUrl() }} @else {{ $avatarUrl }} @endif" alt="{{ $user->name }}">
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
            @error('avatar')
                    <small class="text-danger-600 italic">{{ $message }}</small>
            @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-3">
            <label for="name">Nombre</label>
            <input type="text" class="form-input" name="name" id="name" wire:model='user.name'>
            @error('user.name')
                    <small class="text-danger-600 italic">{{ $message }}</small>
            @enderror
        </div>
    
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-2">
            <label for="apellidos">Apellidos</label>
            <input type="text" class="form-input" name="apellidos" id="apellidos" wire:model='user.apellidos'>
            @error('user.apellidos')
                    <small class="text-danger-600 italic">{{ $message }}</small>
            @enderror
        </div>
    
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-2">
            <label for="telefono">Teléfono</label>
            <input type="text" class="form-input" name="telefono" id="telefono" wire:model='user.telefono'>
            @error('user.telefono')
                    <small class="text-danger-600 italic">{{ $message }}</small>
            @enderror
        </div>
    
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-2">
            <label for="email">Correo Electrónico</label>
            <input type="text" class="form-input" name="email" id="email" wire:model='user.email'>
            @error('user.email')
                    <small class="text-danger-600 italic">{{ $message }}</small>
            @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-2">
            <label for="salario_fijo">Salario Fijo</label>
            <input type="text" class="form-input" name="salario_fijo" id="salario_fijo" wire:model='comercial.salario_fijo'>
            @error('comercial.salario_fijo')
                    <small class="text-danger-600 italic">{{ $message }}</small>
            @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-2">
            <label for="email">Porciento de Viaje</label>
            <input type="text" class="form-input" name="porciento_viaje" id="porciento_viaje" wire:model='comercial.porciento_viaje'>
            @error('comercial.porciento_viaje')
                    <small class="text-danger-600 italic">{{ $message }}</small>
            @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-2">
            <label for="password" class=" w-full md:w-[170px]">Contraseña</label>
            <input x-bind:type="type" class="form-input" wire:model='password' name="password">
            @error('password')
                <span class=" text-danger-600 italic">{{ $message }}</span>
            @enderror
        </div>
    
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
            <label for="passwpassword_confirmationord" class=" w-full md:w-[170px]">Confirmar Contraseña</label>
            <input x-bind:type="type" class="form-input" wire:model='password_confirmation' name="password_confirmation">
            @error('password_confirmation')
                <span class=" text-danger-600 italic">{{ $message }}</span>
            @enderror
        </div>
    
        <div class="my-2 col-span-full flex items-center">
            <input type="checkbox" id="Type" x-model='check' class="form-checkbox" x-on:click="change"> 
            <label for="Type" class="ml-2" >Mostrar Contraseña</label>
        </div>

        <div class="my-4">
            <span>
                <button class="btn bg-indigo-500 hover:bg-indigo-700 text-white" wire:click='save'>
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" wire:target='save' wire:loading.class.remove="hidden">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Guardar
                </button>
            </span>
        </div>

    </div>
    @endif

</div>
