<div x-data="{add:false,
    init(){
        Livewire.on('edit', () => {
            this.add = true;
        });

        Livewire.on('closeAdd', () => {
            this.add = false;
        });
    }
}"> 
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
            <h1 class="text-2xl md:text-3xl text-slate-800 dark:text-slate-100 font-bold mb-1">Colaboraciones</h1>
        </div>
    
    </div>

    <div class="my-2">
        <button class="btn bg-indigo-500 hover:bg-indigo-700 text-white" x-on:click="add = true" >
            <i class="fas fa-plus"></i>  &nbsp;
            Colaborador
        </button>
    </div>

    <div class="my-3 border shadow rounded-md p-4" x-show="add" x-transition>

        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 my-2">
            <label for="name" class=" col-span-1">Nombre de la Agencia</label>
            <input type="text" class="form-input col-span-1 sm:col-span-2" wire:model="colaborador.name" id="name">
            @error('colaborador.name')
                <span class="text-danger-600 italic col-span-full">{{ $message }}</span>
            @enderror
        </div>

        @error('colaborador.tag')
                <span class="text-danger-600 italic col-span-full">{{ $message }}</span>
            @enderror

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

    @if($colaboradores->lastPage() > 1) 
        <div class="bg-slate-800 dark:bg-slate-600 p-4 m-2 md:mx-0 rounded-t text-slate-300"> 
            {{ $colaboradores->links() }}
        </div>
    @endif

    <table class="table-auto w-full">
        <!-- Table header -->
        <thead class="text-xs font-semibold uppercase text-slate-400 dark:text-slate-500 bg-slate-50 dark:bg-slate-700 dark:bg-opacity-50">
            <tr>
                <th class="p-2 whitespace-nowrap">
                    <div class="font-semibold text-left">Agencia</div>
                </th>
                <th class="p-2 whitespace-nowrap">
                    <div class="font-semibold text-left">Tag</div>
                </th>
                <th class="p-2 whitespace-nowrap">
                    
                </th>
            </tr>
        </thead>
        <!-- Table body -->
        <tbody class="text-sm divide-y divide-slate-100 dark:divide-slate-700">
            @foreach ($colaboradores as $colaborador)
                <tr>
                    <td class="p-2 whitespace-nowrap">
                        <div class="text-left">{{ $colaborador->name }}</div>
                    </td>
                    <td class="p-2 whitespace-nowrap">
                        <div class="text-left font-medium text-green-500">{{ $colaborador->tag }}</div>
                    </td>
                    <td class="p-2 whitespace-nowrap flex flex">
                        <button class="bg-success-500 hover:bg-success-700 text-white mr-1 px-2 py-1 rounded-md" wire:click="edit({{ $colaborador->id }})">
                            <i class="fas fa-edit" wire:loading.remove wire:target='edit({{ $colaborador->id }})'></i>

                            <svg class="animate-spin h-5 w-6 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" wire:target="edit({{ $colaborador->id }})" wire:loading.class.remove="hidden">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                        <button class="bg-red-500 hover:bg-red-700 text-white px-2 py-1 rounded-md" wire:click="delete({{ $colaborador->id }})">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
            @endforeach                                                                                
        </tbody>
    </table>

    @if($colaboradores->lastPage() > 1)
        <div class="bg-slate-800 dark:bg-slate-600 p-4 m-2 md:mx-0 rounded-b text-slate-300">
            {{ $colaboradores->links() }}
        </div>
    @endif

</div>
