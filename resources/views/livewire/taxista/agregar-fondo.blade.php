<div>
    
    <div class="grid col-span-2 gap-4">
        <label class="col-span-1" for="metodo">Método</label>
        <select  id="metodo" class="form-select col-span-1" wire:model='fondo.type'> 
            <option value="">Escoja Método</option>
            <option value="Efectivo">Efectivo</option>
            <option value="Transferencia">Transferencia</option>
            <option value="Retiro">Retiro</option>
        </select>
        @error('fondo.type')<span class="col-span-1 text-danger-600">{{ $message }}</span>@enderror 
    </div>

    <div class="grid col-span-2 gap-4 mt-2">
        <label class="col-span-1" for="cantidad">Cantidad</label>
        <input type="text" class="form-input col-span-1" wire:model='fondo.saldo' id="cantidad">
        @error('fondo.saldo')<span class="col-span-1 text-danger-600">{{ $message }}</span>@enderror
    </div>

    <div class="w-full mt-2">
        <button class="btn bg-indigo-500 hover:bg-indigo-700 text-white" wire:click='procesar'>
            <svg class="animate-spin h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" wire:loading.class.remove="hidden" wire:target='procesar'>
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Procesar
        </button>
    </div>

</div>
