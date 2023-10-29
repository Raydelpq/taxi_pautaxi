<div x-data="calcular">
    <button class="btn bg-indigo-500 hover:bg-indigo-700 text-white" x-on:click="open = !open;">Calcular Precio</button>

    <div x-show="open" class="rounded border border-white p-4 my-3">

        <div>

            <div class="sm:w-full grid grid-cols-2 my-1">
                <label class="block text-sm font-medium mb-1" for="km"> 
                    Kilometros
                </label>
                <input x-model="km" x-on:change="changeKM" class="form-input w-full sm:w-24  ml-2" id="km" type="number" name="km" required="required" autofocus="autofocus"  autocomplete="off">
                
            </div>

            <div class="sm:w-full grid grid-cols-2 my-1">
                <label class="block text-sm font-medium mb-1" for="paradas"> 
                    Paradas
                </label>
                <input x-model="paradas" class="form-input w-full sm:w-24  ml-2" id="paradas" type="number" name="paradas" required="required"   autocomplete="off">
                
            </div>

            <div class="sm:w-full grid grid-cols-2 my-1">
                <label class="block text-sm font-medium mb-1" for="espera"> 
                    Tiempo de Espera
                </label>
                <input x-model="espera" class="form-input w-full sm:w-24  ml-2" id="espera" type="number" name="espera" required="required"  autocomplete="off">
                
            </div>

            <div class="sm:w-full grid grid-cols-2 my-1">
                <label class="block text-sm font-medium mb-1" for="equipaje"> 
                    Equipajes
                </label>
                <input x-model="equipaje" class="form-input w-full sm:w-24  ml-2" id="equipaje" type="number" name="equipaje" required="required"  autocomplete="off">
                
            </div>

        </div>

        <div>
            <h3>Horarios</h3>
            @foreach($horarios as $h)
                <button x-on:click="horario = {{ $h->id }}; auto = 0; Livewire.emit('setCosto',0);" 
                    :class="horario == {{ $h->id }} ? 'bg-green-600' : 'bg-indigo-500' " 
                    class="btn hover:bg-indigo-700 text-white mt-1">{{ $h->name }}</button>
            @endforeach
        </div>

        <div>
            <h3>Autos</h3>
            @foreach($autos as $a)
            
                <button x-on:click="selectAuto({{ $a->id }})" 
                    :class="auto == {{ $a->id }} ? 'bg-green-600' : 'bg-indigo-500' " 
                    class="btn hover:bg-indigo-700 text-white mt-1">{{ $a->name }}</button>
            @endforeach
        </div>

    </div>

</div>
@push('code-js')
    <script>
    document.addEventListener('alpine:init', () => { 
            
            Alpine.data('calcular', () => ({
                open: false,
                km: 0,
                paradas: 0,
                espera: 0,
                equipaje: 0,
                horario: @entangle('horario'),
                minimo: @entangle('minimo'),
                precio_parada: @entangle('parada'),
                precio_espera: @entangle('espera'),
                precio_equipaje: @entangle('equipaje'),
                auto: 0,
                costo: 0,
                init() {
                    
                },
                async selectAuto(id){
                    this.auto = id;

                    const val = await this.$wire.getKm(this.auto);
                    console.log(val);
                    let costo = (this.km * val); 

                    this.minimo = await this.$wire.getMinimo(this.auto,this.horario);
                    
                    if(costo < this.minimo)
                        costo = this.minimo;

                    if(this.paradas > 0){
                        costo += (this.paradas * this.precio_parada);
                    }

                    if(this.espera > 0){
                        costo += (this.espera * this.precio_espera);
                    }

                    if(this.equipaje > 0){
                        costo += (this.equipaje * this.precio_equipaje);
                    }
                    costo = Math.trunc(costo);

                    let myFunc = num => Number(num);
                    const arr = Array.from(String(costo), myFunc);

                    let last = arr[arr.length - 1];
                    
                    if(last > 0 && last < 5)
                        arr[arr.length - 1] = 5;
                    else
                        arr[arr.length - 1] = 0;

                    costo = '';
                    for ( const value of arr.values() ) {
                        costo += value;
                    }

                    Livewire.emit('setCosto',costo,this.km);
                },
                changeKM(){
                    Livewire.emit('setKm',this.km);
                }

            }))
            
        })
    </script>

@endpush