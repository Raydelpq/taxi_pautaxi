<div>
    <div class="grid grid-cols-2 gap-4"> 

        <div class="col-span-2 md:col-span-1 mt-4 w-full md:w-[200px]" 
            x-data="{ isUploading: false, progress: 0 }" 
            x-on:livewire-upload-start="isUploading = true" 
            x-on:livewire-upload-finish="isUploading = false; progress = 0; $wire.saveAuto();" 
            x-on:livewire-upload-error="isUploading = false" 
            x-on:livewire-upload-progress="progress = $event.detail.progress"
        >
            <div class="flex flex-wrap justify-end  mb-8 sm:mb-0 -space-x-3 -ml-px w-[250px] h-[250px] relative justify-items-end items-end">
                <img class="w-full h-full rounded" src="{{ $autoUrl }}" alt="Auto">
                <div class="w-full" style="position: absolute;">
                    <button x-show="!isUploading" class="btn bg-indigo-500 hover:bg-indigo-600 text-white py-1 px-2" style="border-radius: 0px 4px 0px 4px" onclick="document.getElementById('auto').click();">
                        <i class="fas fa-camera"></i>
                    </button>
                    <div class="w-full" x-show="isUploading" style="display: none;"> 
                        <progress class="w-full h-1.5" max="100" x-bind:value="progress"></progress>
                    </div>
                </div>
            </div>
            <input type="file" id="auto" wire:model="auto" class="hidden">
        </div>

        <div class="col-span-2 md:col-span-1 mt-4">
            <div class="grid grid-cols-2 gap-4 mt-2">
                <label for="marca">Marca:</label>
                <input type="text" class="form-input" name="marca" id="marca" wire:model="taxista.marca">
                @error('taxista.marca')
                    <small class="text-danger-600">{{ $message }}</small>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mt-2">
                <label for="modelo">Modelo:</label>
                <input type="text" class="form-input" name="modelo" id="modelo" wire:model="taxista.modelo">
                @error('taxista.modelo')
                    <small class="text-danger-600">{{ $message }}</small>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mt-2">
                <label for="marca">Color:</label>
                <input type="text" class="form-input" name="marca" id="marca" wire:model="taxista.color">
                @error('taxista.color')
                    <small class="text-danger-600">{{ $message }}</small>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mt-2">
                <label for="aire">Aire Acondicionado:</label>
                <input type="checkbox" class="form-checkbox" name="aire" id="aire" wire:model="taxista.aire">
            </div>

            <div class="grid grid-cols-2 gap-4 mt-2">
                <label for="operativa">Licencia Operativa:</label>
                <input type="checkbox" class="form-checkbox" name="operativa" id="operativa" wire:model="taxista.lic_operativa">
            </div>

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

    </div>
</div>