<div class="mx-2">

    <div class="grid grid-cols-2 mx-auto mt-0  shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">

        <div class="bg-slate-900 dark:bg-slate-700 border-slate-400 col-span-full grid grid-cols-2 rounded-t-sm p-4">
            <!-- md: sm:grid-cols-1 -->
            <div class="px-1 sm:px-3">
                <h3 class="text-slate-300">{{ $viaje->costo }} <span class="text-green-600">{{ $viaje->divisa->sigla }}</span> @if($viaje->taxista_id == null && $viaje->colaborador_id == null)  |  <span class="text-red-500">Pendiente</span> @elseif($viaje->taxista_id == null && $viaje->colaborador_id != null)   |  Colaboracion <span class="text-red-500">[{{ $viaje->colaborador->name }}]</span> @endif</h3>
                <h3 class="text-slate-300">{{ $viaje->pasajeros }} <span class="text-green-600">Pasajeros</span></h3>
            </div>

            <div class="text-end px-1 sm:px-3">
                <h3 class="text-slate-300">Operador:  
                    
                    <a href="{{ route('empleado.show',$viaje->user->id) }}" 
                        class="text-success-500 hover:text-success-700">{{ $viaje->user->name }}
                    </a> 
                </h3> 
                @if($viaje->taxista_id != null)
                <h3 class="pl-2 text-slate-300">Taxista: 
                    <a href="{{ route('taxista.show',$viaje->taxista->id) }}" class="text-success-500 hover:text-success-700">{{ $viaje->taxista->user->name }}</a>
                </h3>
                @endif
            </div>


        </div>

        <div class="grid grid-cols-3 col-span-full bg-slate-300 dark:bg-slate-900 p-3">
        
            <div class="text-end px-1 sm:px-3 float-right col-span-full">
                <small><i class="far fa-clock"></i> {{ $viaje->created_at->format('d-m-Y h:i A') }}</small>
            </div>

            <div class="grid grid-cols-3 col-span-full my-2">

                <div class="mx-4 col-span-3 sm:col-span-1 md:col-span-1">
                    Ida y Vuelta: {!! $viaje->back ? '<span class="text-green-600">Si</span>': '<span class="text-red-500">No</span>' !!}
                </div>

                <div class="mx-4 col-span-3 sm:col-span-1 md:col-span-1">
                    Aire Acondicionado: {!! $viaje->aire ? '<span class="text-green-600">Si</span>': '<span class="text-red-500">No</span>' !!}
                </div>
                <div class="mx-4 col-span-3 sm:col-span-2 sm:mt-2 md:mt-auto md:col-span-1">
                    @if($viaje->fecha)
                    Reservado: {!! $viaje->fecha ?? "<span class'text-green-600'>{$viaje->fecha->format('d/m/Y h:i A')}</span>" !!} 
                    @endif
                </div>
            </div>

            <div class="mx-2 my-2 grid grid-cols-3 col-span-full bshadow-lg p-2 rounded-sm border border-slate-200 dark:border-slate-700">
                <p class="col-span-3 sm:col-span-1"><strong>Origen:</strong> {{ $viaje->origen }}</p>

                @if(count($viaje->paradas))
                    <div class="col-span-3 sm:col-span-1 grid grid-rows-{{ count($viaje->paradas) }}">
                    @foreach ($viaje->paradas as $index => $parada)
                    <p class="row-span-1"><strong>Parada {{ $index+1 }}:</strong> {{ $parada->nombre }}</p>
                    @endforeach
                    </div>
                @endif

                <p class="col-span-3 sm:col-span-1"><strong>Destino:</strong> {{ $viaje->destino }}</p>
            </div>
            
            <div class="col-span-full grid grid-cols-4">
@if($viaje->taxista_id != null)  
        <div class="col-span-4 sm:col-span-2 float-none md:float-left">
            <h3 class="text-center">Datos del Taxista</h3>
            <div class="flex flex-wrap justify-end sm:justify-start items-end">
            <textarea id="forTaxista" readonly rows="7" class="bg-gray-200 border rounded-md shadow-md form-textarea w-11/12 ml-2 text-left sm:text-right">
*DATOS DEL VIAJE*
@if ($viaje->fecha != null) 
*{{ $viaje->fecha->format('d/m/Y h:i A') }}*  
@endif
Precio: {{ $viaje->costo }} {{ $viaje->divisa->sigla }}
Cliente: {{ $viaje->cliente->numero }}
Origen: {{ $viaje->origen }}
@if(count($viaje->paradas))
@foreach ($viaje->paradas as $index => $parada)
Parada {{ $index+1 }}: {{ $parada->nombre }}
@endforeach
@endif
Destino: {{ $viaje->destino }} 
Pax: {{ $viaje->pasajeros }}
@if ($viaje->observaciones != '')
*{{ $viaje->observaciones }}*  
@endif
Fondo Actual: {{ $viaje->taxista->fondo }} CUP
{{ asset('') }}
            </textarea>

            <a onclick="copy('forTaxista')" href="https://api.whatsapp.com/send?phone=@if(Str::length($viaje->taxista->user->telefono) == 8)53{{ $viaje->taxista->user->telefono }} @else {{ $viaje->taxista->user->telefono }} @endif" target="__blanck" 
                class="mt-2 mb-2 btn bg-green-600 hover:bg-green-700 text-white mx-4 absolute">
                <i class="fas fa-taxi" style="font-size: 24px"></i>
            </a>
            </div>
        </div>

        <div class="col-span-4 sm:col-span-2 float-none md:float-right">
            <h3 class="text-center">Datos del Cliente</h3>
            <div class="flex flex-wrap justify-end items-end">
            <textarea id="forCliente" readonly rows="7" class="bg-gray-200 border rounded-md shadow-md form-textarea w-11/12 mr-2">
@if ($viaje->fecha != null) 
*Su taxi reservado para: {{ $viaje->fecha->format('d/m/Y h:i A') }}*  
@else
*Taxi En Camino*
Tiempo: 15min. Aprox.
@endif
Precio: {{ $viaje->costo }} {{ $viaje->divisa->sigla }}
Chofer: {{ $viaje->taxista->user->name }}
Auto: {{ $viaje->taxista->marca }}
Color: {{ $viaje->taxista->color }}
⚠️ *IMPORTANTE* ⚠️

•Cada parada extra se recalcula la ruta y modifica el costo.

•Al llegar el taxi a su origen usted tiene 10min de espera como cortesía, pasado este tiempo debe pagar por cada minuto extra.

•Tiempo de espera extra:  25cup x minutos. 

•En caso de cancelar estando el auto en el lugar de recogida, deberá pagar la mitad del costo del servicio
{{ route('taxista.public', $viaje->taxista->id) }}
            </textarea>
            <a onclick="copy('forCliente')" href="https://api.whatsapp.com/send?phone={{ $viaje->cliente->numero }}" target="__blanck" 
                class="mt-2 mb-2 btn bg-green-600 hover:bg-green-700 text-white mx-4 absolute">
                <i class="fas fa-user-tie" style="font-size: 24px"></i>
            </a>
        </div>
    </div>
@endif
    </div>
    <!-- END TextAreas -->

        

    </div>

    </div>

    <div class="col-span-full mt-4 py-2 -mb-0.5 ">
        @if($viaje->taxista_id == null && $viaje->colaborador_id == null)
            <a x-on:click="copyUrl" href="{{ route('viaje.add', ['copy'=> $viaje->id]) }}" 
                class=" text-white bg-green-600 hover:bg-green-900 py-2 px-4 mx-0 ">
                Copiar
            </a>
            
            @if(Auth::user()->hasRole('Administrador') || Auth::user()->id == $viaje->user->id)
            <a href="{{ route('viaje.add', ['edit'=> $viaje->id]) }}" 
                class="text-white bg-indigo-500 hover:bg-indigo-700 py-2 px-4 mx-0">
                Editar
            </a>
            
            <a href="#" 
                class="text-white bg-red-500 hover:bg-red-700 py-2 px-4 mx-0 " onclick="remove()">
                Eliminar
            </a>
            @endif
        @else
            @if(Auth::user()->hasRole('Administrador') || Auth::user()->id == $viaje->user->id)
            <a href="{{ route('viaje.add', ['edit'=> $viaje->id]) }}" 
                class="text-white bg-indigo-500 hover:bg-indigo-700 py-2 px-4 mx-0">
                Editar
            </a>
            <a href="#" 
                class="text-white bg-red-500 hover:bg-red-700 py-2 px-4 mx-0 " onclick="remove()">
                Eliminar
            </a>
        @endif
        @endif
    </div>


</div>


@push('code-js')
    
    <script>
        function copy(element){
            const el = document.getElementById(element);
            el.select();
            document.execCommand("copy");
        }

        function remove(){
            Swal.fire({
            title: '¿Eliminar Viaje?',
            text: "Confirme que desea eliminar este viaje.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, Eliminar!'
            }).then((result) => {
            if (result.isConfirmed) {
                Livewire.emit('delete');
            }
            })
        }

    </script>

@endpush