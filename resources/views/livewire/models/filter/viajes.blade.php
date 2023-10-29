<div data-te-modal-init
    wire:ignore
    class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
    id="filterViajeModal" tabindex="-1" aria-labelledby="filterViajeModalLabel" aria-hidden="true">
    <div data-te-modal-dialog-ref
        class="pointer-events-none relative w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[500px] min-[992px]:max-w-[800px] min-[1200px]:max-w-[1140px]">
        <div x-data="filtrar"
            class="min-[576px]:shadow-[0_0.5rem_1rem_rgba(#000, 0.15)] pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
            <div
                class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                <!--Modal title-->
                <h5 class="text-xl font-medium leading-normal text-neutral-800 dark:text-neutral-200"
                    id="filterViajeModalLabel">
                    Filtrar Viajes
                </h5>
                <!--Close button-->
                <button type="button"
                    class="box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none"
                    data-te-modal-dismiss aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!--Modal body-->
            <div class="relative flex-auto p-4" data-te-modal-body-ref > 

                <div>
                    <h3>Filtrar Por:</h3>
                    <select data-te-select-init x-model='modo' x-on:change=" data= '' ">
                        <option value="">...</option>
                        <option value="fecha">Fecha</option>
                        <option value="rango" @if ($selected) selected @endif>Rango de Fecha</option>
                        <option value="mes">Mes</option>
                    </select>
                </div>

                <hr class="w-full">

                <!-- Fecha -->
                <div class="relative mb-3 mt-3" x-show="modo == 'fecha'" 
                    x-transition.duration.500ms
                >
                    <label for="filterDate">Seleccione la Fecha</label>
                    <br/>
                    <input
                        type="text"
                        x-model='data'
                        id="filterDate"
                        class="form-input w-full"
                        placeholder="Seleccione"
                        x-on:click="addClass"
                    />
                </div>

                <!-- Rango de Fecha -->
                <div class="relative mb-3 mt-3" x-show="modo == 'rango'" 
                    x-transition.duration.500ms
                >
                <label for="filterRange">Seleccione el Rango de Fechas</label>
                <br/>
                    <input
                        type="text"
                        x-model='data'
                        id="filterRange"
                        class="form-input w-full"
                        placeholder="Seleccione"
                        x-on:click="addClass"
                    />
                </div>

                <!-- Mes -->
                <div class="relative mb-3 mt-3" x-show="modo == 'mes'" 
                    x-transition.duration.500ms
                >
                <label for="filterMes">Seleccione el Mes</label>
                <br/>
                    <input
                        type="text"
                        x-model='data'
                        id="filterMes"
                        class="form-input w-full"
                        placeholder="Seleccione"
                        x-on:click="addClass"
                    />
                </div>
                
            </div>

            <!--Modal footer-->
            <div
                class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                <button type="button"
                    class="inline-block rounded bg-primary-100 px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-primary-700 transition duration-150 ease-in-out hover:bg-primary-accent-100 focus:bg-primary-accent-100 focus:outline-none focus:ring-0 active:bg-primary-accent-200"
                    data-te-modal-dismiss data-te-ripple-init data-te-ripple-color="light">
                    Cancelar
                </button>
                <button type="button"
                    class="ml-1 inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] disabled:bg-gray-400"
                    data-te-ripple-init data-te-ripple-color="light"
                    wire:loading.attr="disabled"
                    x-on:click="validar"
                    >
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" wire:loading wire:loading.class.remove="hidden">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Filtrar
                </button>
            </div>

        </div>
    </div>
</div>

@push('code-js')
    <script src="https://unpkg.com/flatpickr@4.6.9/dist/plugins/monthSelect/index.js"></script>
    <script>

        flatpickr('#filterDate', {
            defaultDate: "",
            dateFormat:'Y-m-d', 
            altFormat:'j F Y', 
            altInput:true, 
            static: true,
            locale: "es"
        });

        flatpickr('#filterRange', {
            dateFormat:'Y-m-d', 
            altFormat:'j F Y', 
            altInput:true, 
            static: true,
            locale: "es",
            mode: "range"
        });

        flatpickr('#filterMes', {
            defaultDate: "",
            dateFormat:'Y-m', 
            altFormat:'F Y', 
            altInput:true, 
            static: true,
            locale: "es",
            plugins: [
                new monthSelectPlugin({
                shorthand: true, //defaults to false
                dateFormat: "Y-m", //defaults to "F Y"
                altFormat: "F Y", //defaults to "F Y"
                theme: "light" // defaults to "light" , "datk"
                })
            ]
        });

        document.addEventListener('alpine:init', () => {
                
            Alpine.data('filtrar', () => ({
                modo : @entangle('modo') ,
                data: @entangle('data') ,
                init() {

                    window.livewire.on('event', () => {
                        
                    });

                },
                validar() {
                    if(this.modo == ''){
                        Toast.fire({
                            icon: 'warning',
                            title: 'Seleccione un Modo',
                            timer: 3500
                        });
                        return ;
                    }

                    if(this.data == ''){
                        Toast.fire({
                            icon: 'warning',
                            title: 'Seleccione la fecha',
                            timer: 3500
                        });
                        return ;
                    }
                    
                    this.$wire.filtrar();
                },
                addClass(){
                    $('.flatpickr-calendar').addClass('mx-auto');
                }

            }))
            
        })
    </script>
@endpush