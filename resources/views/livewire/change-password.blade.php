<div x-data="{type: 'password', check: false,
    change(){
        if(this.check == false)
            this.type = 'text';
        else
            this.type = 'password';
    }
}">
    <div class="grid grid-cols-2 gap-4">
        <label for="password" class=" w-full md:w-[170px]">Contraseña</label>
        <input x-bind:type="type" class="form-input col-span-full md:col-span-1" wire:model='password' name="password">
        @error('password')
            <span class="col-span-full text-right text-danger-600 italic">{{ $message }}</span>
        @enderror
    </div>

    <div class="grid grid-cols-2 gap-4 mt-4">
        <label for="passwpassword_confirmationord" class=" w-full md:w-[170px]">Confirmar Contraseña</label>
        <input x-bind:type="type" class="form-input col-span-full md:col-span-1" wire:model='password_confirmation' name="password_confirmation">
        @error('password_confirmation')
            <span class="col-span-full text-right text-danger-600 italic">{{ $message }}</span>
        @enderror
    </div>

    <div class="my-2 col-span-full flex items-center">
        <input type="checkbox" id="Type" x-model='check' class="form-checkbox" x-on:click="change"> 
        <label for="Type" class="ml-2" >Mostrar Contraseña</label>
    </div>

    <div class="mt-3 md:mt-auto">
        <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white" wire:click="change">
            <span wire:loading.class.remove="hidden" wire:target='change' class="w-full grid justify-center hidden">
                <svg class="animate-spin h-5 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" >
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </span>
            Cambiar
        </button>
    </div>
</div>
