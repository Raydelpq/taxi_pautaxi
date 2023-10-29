<div class="w-full">
    
    <div class="mx-auto" x-data="{opcion : 1}">
        <div class="w-auto mx-auto my-2">
            @role('Administrador')
            <button :class="opcion == 1 ? 'bg-success-500' : 'bg-indigo-500' " x-on:click="opcion = 1" class="btn text-white">Registro</button>
            <button :class="opcion == 2 ? 'bg-success-500' : 'bg-indigo-500' " x-on:click="opcion = 2" class="btn text-white">Agregar / Retirar</button>
            @endrole
        </div>

        <!-- Registro -->
        <div x-show="opcion==1" class="w-full">
            <livewire:taxista.registro-fondo :taxista="$taxista">
        </div>

        @role('Administrador')
        <!-- Agregar -->
        <div x-show="opcion==2" class="w-full">
            <livewire:taxista.agregar-fondo :taxista="$taxista">
        </div>
        @endrole

    </div>

</div>
