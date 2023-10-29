<div class="mt-4" x-data="{add:false,
        init(){
            Livewire.on('edit', () => {
                this.add = true;
            });

            Livewire.on('closeAdd', () => {
                this.add = false;
            });
        }
    }"
>

    <div class="my-2">
        <button class="btn bg-indigo-500 hover:bg-indigo-700 text-white" x-on:click="add = true" >
            <i class="fas fa-plus"></i>  &nbsp;
            Ingreso
        </button>
    </div>

    <div class="my-3 border shadow rounded-md p-4" x-show="add" x-transition>

        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 my-2">
            <label for="name" class=" col-span-1">Nombre del Ingreso</label>
            <input type="text" class="form-input col-span-1 sm:col-span-2" wire:model="ingreso.name" id="name">
            @error('ingreso.name')
                <span class="text-danger-600 italic col-span-full">{{ $message }}</span>
            @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 my-2">
            <label for="valor" class=" col-span-1">Valor del Ingreso</label>
            <input type="text" class="form-input col-span-1 sm:col-span-2" wire:model="ingreso.valor" id="valor">
            @error('ingreso.valor')
                <span class="text-danger-600 italic col-span-full">{{ $message }}</span>
            @enderror
        </div>


        <div class="grid grid-cols-2 gap-4">
            <button class="btn bg-indigo-500 hover:bg-indigo-700 disabled:bg-slate-500 text-white grid-cols-1 w-32" wire:click="save" wire:loading.attr="disabled" wire:target='save'>
                <i class="fas fa-save" wire:loading.remove wire:target='save'></i>  &nbsp;
                <svg class="animate-spin h-5 w-6 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" wire:target="save" wire:loading.class.remove="hidden">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Guardar
            </button>
            <span class="grid justify-end">
                <button class="btn bg-red-500 hover:bg-danger-700 text-white grid-cols-1 w-32 items-end" x-on:click="add = false; $wire.resetInput();" >
                    <i class="fas fa-window-close"></i>  &nbsp;
                    Cancelar
                </button>
            </span>
        </div>

    </div>

    <div>
        <header class="text-xs uppercase text-slate-400 dark:text-slate-500 bg-slate-50 dark:bg-slate-700 dark:bg-opacity-50 rounded-sm font-semibold p-2">Ingresos</header>
        <ul class="my-1">
            @forelse ($ingresos as $ingreso)
                <li class="flex px-2">
                    <div class="grow flex items-center border-b border-slate-100 dark:border-slate-700 text-sm py-2">
                        <div class="grow grid grid-cols-3 justify-between">
                            <div class="self-center col-span-1">{{ $ingreso->name }}</div>
                            <div class="self-center col-span-1"></div>
                            <div class="shrink-0 self-start ml-2 col-span-1">
                                <span class="font-medium text-slate-800 dark:text-slate-100 mr-4">{{ $ingreso->valor }} CUP</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <button class="bg-success-500 hover:bg-success-700 text-white px-2 py-1 rounded-md" wire:click="edit({{ $ingreso->id }})">
                            <i class="fas fa-edit" wire:loading.remove wire:target='edit({{ $ingreso->id }})'></i>

                            <svg class="animate-spin h-5 w-6 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" wire:target="edit({{ $ingreso->id }})" wire:loading.class.remove="hidden">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                        <button class="bg-red-500 hover:bg-red-700 text-white px-2 py-1 rounded-md" onclick="deleteIngreso({{ $ingreso->id }})">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </li>
            @empty
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <h3 class="text-7xl text-center col-span-full mt-4  animate-bounce">😔</h3>
                    <p class="mt-4 text-xl md:text-5xl col-span-full underline decoration-red-700">Lo sentimos, no se han encontrado Ingresos.</p>
                </div>
            @endforelse
        </ul>
    </div>
</div>

@push('code-js')
<script>
    
    function deleteIngreso(id){
         
        Swal.fire({
            title: 'Confirme que desea Eliminar este Ingreso',
            text: "¿Está seguro de eliminar el Ingreso?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar!'
        }).then((result) => {
            
            if (result.isConfirmed) {
                Livewire.emit('delete',id); 
            }
        });
    }

</script>    
@endpush