<div class="mt-10 mb-10">
    <h1 class="text-3xl text-slate-800 dark:text-slate-100 font-bold mb-6 mx-auto">Registro de Taxistas ✨</h1>

    <div class="grid md:grid-cols-2 sm:grid-cols-1 gap-4 mx-auto sm:w-full md:w-4/5">

        <div class="sm:col-span-1 md:col-span-2" style="height: 200px; width: 200px"
            x-data="{ isUploading: false, progress: 0 }"
            x-on:livewire-upload-start="isUploading = true"
            x-on:livewire-upload-finish="isUploading = false; progress = 0"
            x-on:livewire-upload-error="isUploading = false"
            x-on:livewire-upload-progress="progress = $event.detail.progress"
        >
            <div class="border p-0 w-full h-full shadow-lg rounded grid" style="justify-items: end; align-items: end; position: relative;">
                <img class="w-full h-full rounded absolute " src="@if($avatar) {{ $avatar->temporaryUrl() }} @else {{ asset('img') }}/no-avatar.jpg @endif" alt="Avatar">
                <div class="w-full" style="position: absolute;">
                    <button x-show="!isUploading" class="btn bg-indigo-500 hover:bg-indigo-600 text-white py-1 px-2" style="border-radius: 0px 4px 0px 4px" onclick="document.getElementById('avatar').click();">
                        <i class="fas fa-camera"></i>
                    </button>
                    <div class="w-full" x-show="isUploading"> 
                        <progress class="w-full h-1.5" max="100" x-bind:value="progress"></progress>
                    </div>
                </div>
            </div>
            @error('avatar') <small class="text-red-500">{{ $message }}</small> @enderror
            <input type="file" id="avatar" wire:model='avatar' class="hidden">
        </div>

        <div class="sm:w-full">
            <label class="block text-sm font-medium mb-1" for="name"> 
                Nombre
            </label>
            <input class="form-input w-full" id="name" type="text" name="name" required="required" autofocus="autofocus" wire:model='user.name' autocomplete="off">
            @error('user.name')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="sm:w-full">
            <label class="block text-sm font-medium mb-1" for="apellidos">
                Apellidos
            </label>
            <input class="form-input w-full" id="apellidos" type="text" name="apellidos" required="required" wire:model='user.apellidos' autocomplete="off">
            @error('user.apellidos')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="sm:w-full">
            <label class="block text-sm font-medium mb-1" for="telefono"> 
                Teléfono
            </label>
            <input class="form-input w-full" id="telefono" type="text" name="telefono" required="required" placeholder="5xxxxxxx" wire:model='user.telefono' autocomplete="off">
            @error('user.telefono')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="sm:w-full">
            <label class="block text-sm font-medium mb-1" for="email">
                Correo Electrónico
            </label>
            <input class="form-input w-full" id="email" type="text" name="email" required="required" placeholder="taxista@example.com" wire:model='user.email' autocomplete="off">
            @error('user.email')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="sm:w-full">
            <label class="block text-sm font-medium mb-1 mt-4" for="operativa"> 
                <input class="form-checkbox" id="operativa" type="checkbox" name="operativa" required="required" wire:model="taxista.lic_operativa">
                ¿Tiene Lic. Operativa?
            </label>
        </div>

        <div class="sm:col-span-1 md:col-span-2">
            <h3  class="text-3xl text-slate-800 dark:text-slate-100 font-bold mx-auto">Datos del Auto</h3> 

            <div class="bg-white shadow-2xl rounded-md p-2 grid md:grid-cols-2 sm:grid-cols-1 gap-2">

                <div class="sm:w-full">
                    <label class="block text-sm font-medium mb-1" for="marca"> 
                        Marca
                    </label>
                    <input class="form-input w-full" id="marca" type="text" name="marca" required="required" wire:model="taxista.marca" autocomplete="off">
                    @error('taxista.marca')
                        <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:w-full">
                    <label class="block text-sm font-medium mb-1" for="modelo"> 
                        Modelo
                    </label>
                    <input class="form-input w-full" id="modelo" type="text" name="modelo" required="required" wire:model="taxista.modelo" autocomplete="off">
                    @error('taxista.modelo')
                        <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:w-full">
                    <label class="block text-sm font-medium mb-1" for="color"> 
                        Color
                    </label>
                    <input class="form-input w-full" id="color" type="text" name="color" required="required" wire:model="taxista.color" autocomplete="off">
                    @error('taxista.color')
                        <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:w-full">
                    <label class="block text-sm font-medium mb-1 mt-8" for="aire"> 
                        <input class="form-checkbox" id="aire" type="checkbox" name="aire" required="required" wire:model="taxista.aire">
                        ¿Tiene Aire Acondicionado?
                    </label>
                </div>

            </div>

            <div class="sm:col-span-1 md:col-span-2 mt-4" style="height: 200px; width: 200px"
                x-data="{ isUploading: false, progress: 0 }"
                x-on:livewire-upload-start="isUploading = true"
                x-on:livewire-upload-finish="isUploading = false; progress = 0"
                x-on:livewire-upload-error="isUploading = false"
                x-on:livewire-upload-progress="progress = $event.detail.progress"
            >
                <div class="border p-0 w-full h-full shadow-lg rounded grid" style="justify-items: end; align-items: end; position: relative;">
                    <img class="w-full h-full rounded" src="@if($auto) {{ $auto->temporaryUrl() }} @else {{ asset('img') }}/taxi.png @endif" alt="Auto">
                    <div class="w-full" style="position: absolute;">
                        <button x-show="!isUploading" class="btn bg-indigo-500 hover:bg-indigo-600 text-white py-1 px-2" style="border-radius: 0px 4px 0px 4px" onclick="document.getElementById('auto').click();">
                            <i class="fas fa-camera"></i>
                        </button>
                        <div class="w-full" x-show="isUploading"> 
                            <progress class="w-full h-1.5" max="100" x-bind:value="progress"></progress>
                        </div>
                    </div>
                </div>
                @error('auto') <small class="text-red-500">{{ $message }}</small> @enderror
                <input type="file" id="auto" wire:model='auto' class="hidden">
            </div>

        </div>

        <div class="sm:w-full">
            <label class="block text-sm font-medium mb-1" for="password">
                Contraseña
            </label>
            <input class="form-input w-full" id="password" type="password" name="password" required="required"
                wire:model="password">
                @error('password')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
        </div>

        <div class="sm:w-full">
            <label class="block text-sm font-medium mb-1" for="password_confirmation">
                Confirmar Contraseña
            </label>
            <input class="form-input w-full" id="password_confirmation" type="password" name="password_confirmation" required="required"
                wire:model="password_confirmation">
                @error('password_confirmation')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
        </div>

        <div class="sm:col-span-1 md:col-span-2">
            <label class="block text-sm font-medium mb-1 mt-8" for="condiciones"> 
                <input class="form-checkbox" id="condiciones" type="checkbox" name="condiciones" required="required" wire:model="condiciones">
                Click aqui para Aceptar los <a href="{{ route('terminos') }}" target="__blank" class="text-indigo-500 hover:text-indigo-600">Términos y Condiciones</a>
            </label>
        </div>

        <div class="sm:col-span-1 md:col-span-2">
            <a href="{{ route('home') }}" class="btn bg-red-500 hover:bg-red-600 text-white">Cancelar</a>
            
            <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white float-right disabled:bg-gray-500" wire:click='store' @if(!$condiciones) disabled="disabled" @endif>
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" wire:target='store' wire:loading.class.remove="hidden">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Registrar
            </button>
        </div>

    </div>

</div>