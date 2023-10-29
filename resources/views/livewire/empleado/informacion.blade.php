<div>
    
    <div class="grid grid-cols-2 gap-4 mt-2">
        <label for="name">Nombre</label>
        <input type="text" class="form-input" name="name" id="name" wire:model='user.name'>
        @error('user.name')
                <small class="text-danger-600">{{ $message }}</small>
        @enderror
    </div>

    <div class="grid grid-cols-2 gap-4 mt-2">
        <label for="apellidos">Apellidos</label>
        <input type="text" class="form-input" name="apellidos" id="apellidos" wire:model='user.apellidos'>
        @error('user.apellidos')
                <small class="text-danger-600">{{ $message }}</small>
        @enderror
    </div>

    <div class="grid grid-cols-2 gap-4 mt-2">
        <label for="telefono">Teléfono</label>
        <input type="text" class="form-input" name="telefono" id="telefono" wire:model='user.telefono'>
        @error('user.telefono')
                <small class="text-danger-600">{{ $message }}</small>
        @enderror
    </div>

    <div class="grid grid-cols-2 gap-4 mt-2">
        <label for="email">Correo Electrónico</label>
        <input type="text" class="form-input" name="email" id="email" wire:model='user.email'> 
        @error('user.email')
                <small class="text-danger-600">{{ $message }}</small>
        @enderror
    </div>

    @role('Administrador')
    <div class="grid grid-cols-2 gap-4 mt-2">
        <label for="rol">Rol</label>
        <select name="rol" id="rol" class="form-select" wire:model="rol">
            <option value="">....</option>
            @foreach ($roles as $key => $rol)
                <option value="{{ $rol->name }}">{{ $rol->name }}</option>
            @endforeach
        </select>
        @error('rol')
                <small class="text-danger-600">{{ $message }}</small>
        @enderror
    </div>

    <div class="grid grid-cols-2 gap-4 mt-2">
        <label for="salario_fijo">Salario Fijo</label>
        <input type="text" class="form-input" name="salario_fijo" id="salario_fijo" wire:model='comercial.salario_fijo'>
        @error('comercial.salario_fijo')
                <small class="text-danger-600">{{ $message }}</small>
        @enderror
    </div>

    <div class="grid grid-cols-2 gap-4 mt-2">
        <label for="porciento_viaje">Porciento de Cada Viaje</label>
        <input type="text" class="form-input" name="porciento_viaje" id="porciento_viaje" wire:model='comercial.porciento_viaje'>
        @error('comercial.porciento_viaje')
                <small class="text-danger-600">{{ $message }}</small>
        @enderror
    </div>

    @endrole

    <div class="mt-3 md:mt-auto">
        <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white" wire:click="change">
            <span wire:loading.class.remove="hidden" wire:target='change' class="w-full grid justify-center hidden">
                <svg class="animate-spin h-5 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" >
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </span>
            Guardar
        </button>
    </div>

</div>
