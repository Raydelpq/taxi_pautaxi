<div class="mt-2 mb-10" x-data="addViaje">
    
    <div class="relative bg-indigo-200 dark:bg-indigo-500 p-4 sm:p-6 rounded-sm overflow-hidden mb-8">

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
            <h1 class="text-2xl md:text-3xl text-slate-800 dark:text-slate-100 font-bold mb-1">
                Datos del Viaje
                <span class="ml-4"><i class="fas fa-route text-yellow-500"></i></span>
            </h1>
        </div>
    
    </div>

    <div class="grid md:grid-cols-2 sm:grid-cols-1 gap-4 mx-auto ">

        <div class="sm:col-span-1 md:col-span-2" >
            @foreach ($divisas as $divisa)
            <Button title="Valor {{ $divisa->valor }}" x-on:click=" moneda = {{ $divisa->id }}; moneda_valor = {{ $divisa->valor }}; moneda_name = '{{ $divisa->sigla }}'; " :class="moneda == {{ $divisa->id }} ? 'bg-green-600' : 'bg-indigo-500' " class="btn text-white hover:bg-indigo-600">{{ $divisa->sigla }}</Button>
            @endforeach
        </div>

        <div class="sm:col-span-1 md:col-span-2" >
            <livewire:viajes.calcular />
        </div>

        <div class="sm:col-span-1 md:col-span-2">
            <label for="colaborador">¿Colaboracion?</label>
            <select class="form-select" id="colaborador" x-model="colaborador" x-on:change="changeColaborador()">
                <option value="">...</option>
                @foreach ($colaboradores as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
            </select>

            <div class="mt-3" x-show="colaborador != '' "> 
                <label for="typeColaboracion">Tipo de Colaboracion</label>
                <select class="form-select" id="typeColaboracion" x-model="typeColaboracion" > 
                    <option value="">...</option>
                    <option value="entrada">Entrada</option>
                    <option value="salida">Salida</option>
                </select>
                @error('typeColaboracion')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <div class="sm:col-span-1 md:col-span-2">
            <label class="block text-sm font-medium mb-1 mt-4" for="transferencia"> 
                <input x-model="transferencia" class="form-checkbox" id="transferencia" type="checkbox" name="transferencia" required="required">
               Pago por Transferencia
            </label>
        </div>

       
        <div class="sm:w-full" x-show="typeColaboracion != 'salida' ">
            <label class="block text-sm font-medium mb-1" for="taxista"> 
                Taxista
            </label>
            <div class="flex">
                <input x-model="taxista" wire:keydown.enter='checkTaxista' class="form-input w-full" id="taxista" type="text" name="taxista" required="required" autofocus="autofocus" wire:model='taxista' autocomplete="off">
                <button class="btn bg-green-600 hover:bg-green-700 text-white ml-3" wire:click="checkTaxista">
                    <i wire:target='checkTaxista' wire:loading.remove class="fas fa-check"></i>
                    <svg class="animate-spin h-5 w-6 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" wire:target='checkTaxista' wire:loading.class.remove="hidden">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </div>
            <div class="flex" x-show="checkTaxista">
                <p class="text-green-700" x-text='infoTaxista'></p>
                <p>&nbsp; Fondo: <span :class=" fondo >= 300 ? 'text-green-600' : (fondo < 300 && fondo > 150) ? 'text-yellow-600' : 'text-red-600' " x-text='fondo'></span> CUP</p>
            </div>
            @error('taxista')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="sm:w-full" x-show="colaborador == '' ">
            <label class="block text-sm font-medium mb-1" for="cliente"> 
                Cliente
            </label>
            <input x-model="cliente" class="form-input w-full" id="cliente" type="text" name="cliente" required="required" autofocus="autofocus" wire:model='cliente' wire:change='trimCliente' autocomplete="off">
            @error('cliente')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>
        

        <div>
            <div class="sm:w-full md:w-24">
                <label class="block text-sm font-medium mb-1" for="costo"> 
                    Costo
                </label>
                <input x-model="costo" class="form-input w-full" id="costo" type="text" name="costo" required="required" autofocus="autofocus" wire:model='viaje.costo' autocomplete="off">
                
            </div>
            @error('viaje.costo')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <div class="sm:w-full md:w-24">
                <label class="block text-sm font-medium mb-1" for="pasajeros"> 
                    Pasajeros
                </label>
                <input x-model="pasajeros" class="form-input w-full" id="pasajeros" type="text" name="pasajeros" required="required" autofocus="autofocus" wire:model='viaje.pasajeros' >
            </div>
            @error('viaje.pasajeros')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="sm:col-span-1 md:col-span-2">
            <label class="block text-sm font-medium mb-1" for="origen">
                Origen
            </label>
            <input x-model="origen" class="form-input w-full" id="origen" type="text" name="origen" required="required" wire:model='viaje.origen' autocomplete="off">
            @error('viaje.origen')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="sm:col-span-1 md:col-span-2">
            <label class="block text-sm font-medium mb-1" for="origen">
                <button class="btn bg-indigo-500 hover:bg-indigoo-600 text-white" wire:click='addParada'>
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" wire:target='addParada' wire:loading.class.remove="hidden">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Punto Intermedio
                </button>
            </label>

            @foreach ($paradas as $index => $item)
                <div class="flex my-1" wire:key="parada-{{ $index }}">
                    <input class="form-input w-4/5"  type="text" required="required" wire:model="paradas.{{ $index }}.nombre" autocomplete="off">
                    <button class="btn bg-red-500 hover:bg-red-600 text-white ml-3" wire:click="delParada({{ $index }})">
                        <i wire:target='delParada({{ $index }})' wire:loading.remove class="fas fa-trash-alt"></i>
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" wire:target='delParada({{ $index }})' wire:loading.class.remove="hidden">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                    
                    @error('paradas.{{ $index }}.nombre')
                        <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            @endforeach
        </div>

        <div class="sm:col-span-1 md:col-span-2">
            <label class="block text-sm font-medium mb-1" for="destino">
                Destino
            </label>
            <input x-model="destino" class="form-input w-full" id="destino" type="text" name="destino" required="required" wire:model='viaje.destino' autocomplete="off">
            @error('viaje.destino')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="">
            <label class="block text-sm font-medium mb-1 mt-4" for="precioCliente"> 
                <input x-model="precioCliente" class="form-checkbox" id="precioCliente" type="checkbox" name="precioCliente" required="required">
               Precio Cliente
            </label>
        </div>

        <div class="">
            <label class="block text-sm font-medium mb-1 mt-4" for="back"> 
                <input x-model="back" x-on:change="changeBack" class="form-checkbox" id="back" type="checkbox" name="back" required="required" wire:model="viaje.back">
               ¿Ida y Vuelta?
            </label>
        </div>

        <div class="relative mb-3 mt-1 col-span-full" x-show="back" wire:ignore>
            <!--<input
                type="text"
                id="fechaIda"
                class="form-input w-full my-1"
                placeholder="Seleccionar Fecha de Ida"
                x-on:click="addClass"
                x-model='fecha_ida'
            />-->

            <input
                type="text"
                id="fechaVuelta"
                class="form-input w-full my-1"
                placeholder="Seleccionar Fecha de Vuelta"
                x-on:click="addClass"
                x-model='fecha_vuelta'
            />
            
        </div>

        <div class="">
            <label class="block text-sm font-medium mb-1 mt-4" for="aire"> 
                <input x-model="aire" class="form-checkbox" id="aire" type="checkbox" name="aire" required="required" wire:model="viaje.aire">
               ¿Aire Acondicionado?
            </label>
        </div>
        
        <div class="sm:col-span-1 md:col-span-2">
            <div class="">
                <label class="block text-sm font-medium mb-1 mt-4" for="otraFecha"> 
                    <input class="form-checkbox" id="otraFecha" type="checkbox" name="otraFecha" required="required" x-model="otraFecha">
                    Viaje Reservado
                </label>
            </div>
            
        </div>

        <div class="relative mb-3 mt-1" x-show="otraFecha" wire:ignore>
            <input
                type="text"
                id="fecha"
                class="form-input w-full"
                placeholder="Seleccionar Fecha"
                x-on:click="addClass"
                x-model='fecha'
            />
            @error('fecha')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="sm:col-span-1 md:col-span-2">
            <label class="block text-sm font-medium mb-1" for="observaciones">
                Observaciones
            </label>
            <textarea x-model="observaciones" class="form-input w-full" id="observaciones" type="text" name="observaciones"  wire:model='viaje.observaciones' autocomplete="off" rows="4"></textarea>
            @error('viaje.observaciones')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>

       
        <div class="sm:col-span-1 md:col-span-2">
            <div class="">
                <label class="block text-sm font-medium mb-1 mt-4" for="otra_fecha"> 
                    <input class="form-checkbox" id="otra_fecha" type="checkbox" name="otra_fecha" required="required" x-model="otra_fecha">
                    Otra Fecha
                </label>
            </div>
            
        </div>

        <div class="relative mb-3 mt-1" x-show="otra_fecha" wire:ignore>
            <input
                type="text"
                id="otra_fechaValor"
                class="form-input w-full"
                placeholder="Seleccionar Fecha"
                x-on:click="addClass"
                x-model='otra_fechaValor'
            />
            @error('otra_fechaValor')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>
        

        <div class="sm:col-span-1 md:col-span-2">
            <label class="block text-sm font-medium mb-1" for="datos">
                Datos del Viaje
            </label>
            <textarea x-model="datos" class="form-input w-full border shadow-md" id="datos" type="text" name="datos"  autocomplete="off" rows="4" readonly></textarea>
        </div>

        <div class="sm:col-span-1 md:col-span-2">
            <button class="btn bg-green-600 hover:bg-green-700 disabled:bg-slate-400 text-white" x-on:click.prevent='generar' wire:loading.attr="disabled">Generar</button>
           
            @if($edit)
            <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white float-right @if($modelTaxista?->id == null) @endif" wire:click.prevent='edit' wire:loading.attr="disabled">
                <svg class="animate-spin h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" wire:loading.class.remove="hidden">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span wire:loading.class="hidden">Editar</span>
            </button>
            @else
            <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white float-right" wire:click.prevent='store' wire:loading.attr="disabled">
                <svg class="animate-spin h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" wire:loading.class.remove="hidden">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span wire:loading.class="hidden">Crear</span>
            </button>
            @endif
        </div>


    </div>

    @push('code-css') 
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    @endpush
    
    @props(['options' => "{enableTime: true, dateFormat:'Y-m-d H:i', altFormat:'F j, Y', altInput:true, static: true }"])

    @push('code-js')
        <script src="{{ asset('js') }}/jquery-3.5.1.js"></script>
        <script src="{{ asset('js') }}/moment.min.js"></script>
        <script>

        /*
         focus: recive el foco
         blur: pierde el foco
        window.addEventListener("blur", () => {
            document.title = "Breakup";
        });*/
            
            @if($edit)
            window.onload = function(){
                window.livewire.emit('checkTaxista');
            }
            @endif

            flatpickr('#fecha', {
                @if($copy || $edit)
                defaultDate: '{{ $fecha }}',
                @endif
                enableTime: true,
                time_24hr: false,
                dateFormat:'Y-m-d H:i:00', 
                altFormat:'F, j Y H:i K', 
                altInput:true, 
                static: true,
                locale: "es"
            });

            flatpickr('#fechaIda', {
                defaultDate: '',
                enableTime: true,
                time_24hr: false,
                dateFormat:'Y-m-d H:i:00', 
                altFormat:'F, j Y H:i K', 
                altInput:true, 
                static: true,
                locale: "es"
            });

            flatpickr('#fechaVuelta', {
                defaultDate: '',
                enableTime: true,
                time_24hr: false,
                dateFormat:'Y-m-d H:i:00', 
                altFormat:'F, j Y H:i K', 
                altInput:true, 
                static: true,
                locale: "es"
            });

            flatpickr('#otra_fechaValor', {
                enableTime: true,
                time_24hr: false,
                dateFormat:'Y-m-d H:i:00', 
                altFormat:'F, j Y H:i K', 
                altInput:true, 
                static: true,
                locale: "es"
            });

            document.addEventListener('alpine:init', () => { 
                
                Alpine.data('addViaje', () => ({
                    checkTaxista: false,
                    moneda_name: @entangle('moneda_name'),
                    moneda: @entangle('moneda'),
                    moneda_valor: @entangle('moneda_valor'),
                    back: @entangle("viaje.back"),
                    fecha_ida: '',
                    fecha_vuelta: '',
                    aire: @entangle('viaje.aire'),
                    fecha: @entangle('fecha'),
                    paradas: @entangle('paradas'),
                    otraFecha: @entangle('otraFecha'),
                    datos: '',
                    infoTaxista: '',
                    fondo: '',
                    colaborador: @entangle('colaborador'),
                    nameColaborador: @entangle('nameColaborador'),
                    typeColaboracion: @entangle('typeColaboracion'),
                    otra_fecha: @entangle('otra_fecha').defer,
                    otra_fechaValor: @entangle('otra_fechaValor'),
                    precioCliente: false,
                    transferencia: false,
                    km: 0,

                    @if(!$copy && !$edit)
                    taxista: '',
                    cliente: '',
                    costo: '',
                    pasajeros: '',
                    origen: '',
                    destino: '',
                    observaciones: '',
                    
                    @else
                    taxista: @entangle("taxista"),
                    cliente: @entangle("cliente"),
                    costo: @entangle("viaje.costo"),
                    pasajeros: @entangle("viaje.pasajeros"),
                    origen: @entangle("viaje.origen"),
                    destino: @entangle("viaje.destino"),
                    observaciones: @entangle("viaje.observaciones"),

                    @endif
                    init() {

                        window.livewire.on('checkTaxistaOK', (taxista) => {
                            this.infoTaxista = `${taxista.name} ${taxista.marca} ${taxista.modelo} ${taxista.color}`;
                            this.fondo = taxista.fondo;
                            this.checkTaxista = true; 
                        });

                        window.livewire.on('notTaxista', () => {
                            this.infoTaxista = '';
                            this.fondo = '';
                            this.checkTaxista = false; 
                        });
                        
                        window.livewire.on('setCosto', (valor,km) => {
                            this.costo = valor;
                            Livewire.emit('setViajeCosto',this.costo);
                            this.km = km;
                        });

                        window.livewire.on('setKm', (km) => {
                            this.km = km;
                        });
                    },
                    changeBack(){
                        if(this.back)
                            this.costo *= 2;
                        else 
                            this.costo /= 2; 

                        this.$wire.setViajeCosto(this.costo);
                    },
                    changeColaborador(){
                        Livewire.emit('getColaborador',this.colaborador);
                    },
                    async generar(){

                        this.datos = '';

                        if(this.pasajeros != '')
                            this.datos += `\n👨‍👩‍👧‍👦 Cant Pax: ${this.pasajeros}`;
                        
                        if(this.transferencia)
                            this.datos += `\n*Pago por Transferencia*\n`;

                        this.datos += `*💰 costo :* ${this.costo} ${this.moneda_name}`;

                        /*if(this.km != 0)
                            this.datos += ` (${this.km} km)`;*/

                        //this.datos += `*`;

                        if(this.back){
                            //const dateIda = new Date(this.fecha_ida)
                            const dateVuelta = new Date(this.fecha_vuelta);
                            //let ida =  moment(dateIda).format("YYYY-MM-DD hh:mm A");
                            let vuelta =  moment(dateVuelta).format("YYYY-MM-DD hh:mm A");
                           
                            this.datos += `\n*Ida y Vuelta*`;
                            //this.datos += `\n*Ida: ${ida} | Vuelta: ${vuelta}*`;
                            if(this.fecha_vuelta != '')
                            this.datos += `\n*Vuelta: ${vuelta}*`;
                        }

                        if(this.precioCliente)
                            this.datos += `\n*Precio Cliente*`;
                        

                        if(this.aire)
                            this.datos += `\n*❄️Taxi con Aire Acondicionado❄️*`;

                        if(this.observaciones != '' && this.observaciones != null)
                            this.datos += `\n\n*✳️${this.espacios( this.observaciones)}✳️*`;

                        

                        

                        

                        if(this.otraFecha){ 
                            
                            const date = new Date(this.fecha)
                            let d =  moment(date).format("YYYY-MM-DD hh:mm A");
                            this.datos += `\n\n*🕐 Horario:* ${d}`;
                        }else{
                            this.datos += `\n\n*🕐 Horario:* Ahora`;
                        }

                        // Agregar Origen
                        this.datos += `\n\n*ORIGEN:* ${this.origen}`;

                        let index = 1; 
                        for (let i = 0; i < this.paradas.length; i++) {
                            if(this.paradas[i].nombre != '')
                            this.datos += `\n\n*Parada ${index}:* (${this.paradas[i].nombre})`;    
                            index++;
                        }
                        this.datos += `\n\n*DESTINO :* ${this.destino}`;

                        if(this.colaborador != '' && this.colaborador != null)
                            this.datos += `\n\n#PauTaxi  #${this.nameColaborador}`;
                        else
                            this.datos += `\n\n#PauTaxi`;

                        const area = document.getElementById('datos'); 
                        area.value = this.datos;
                        area.select();
                        document.execCommand("copy");
                    },
                    sleep(ms) {
                        return new Promise(resolve => setTimeout(resolve, ms));
                    },
                    // Quitar espacio en blanco inicio  y fin
                    espacios(text){
                        text = text.trimStart();
                        text = text.trimEnd();
                        return text;
                    },
                    addClass(){
                        $('.flatpickr-calendar').addClass('mx-auto');
                        console.log("Add Class");
                    }

                }))
                
            })
        </script>

    @endpush

</div>
