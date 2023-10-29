<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <style>
        .page-break {
            page-break-after: always;
        }
        
        .text-center{
            text-align: center !important;
        }
    </style>
</head>
<body> 
    
    <div>
        <h3 class="text-center" style="color: rgba(166, 186, 25, 0.65)">{{ env('APP_NAME','Taxis') }}</h3>
    </div>

    <div>
        <h3 class="text-center">{{ $title }}</h3>
        
        <p style="width: 100%">Viajes: {{ count($viajes) }}  |  Importe: {{ $importe }} CUP  |  Monto: {{ $monto }} CUP  |  Ganancia: {!! $importe-$monto !!} CUP</p>
    </div>

    <div>
        @php
            $iterator = 0;
        @endphp
        @foreach ($viajes as $viaje)
        <div style="border: solid 1px gray; border-radius: 5px;margin: 4px 0px; padding: 3px;">
            
            <div style="width: 100%;">
                <p style="text-align: right;">{{ $viaje->created_at->format('d m Y h:i A') }}</p>

                <div style="width: 100%;">
                    @if($viaje->taxista_id != null)
                        @php
                            $taxista = App\Models\Taxista::withTrashed()->find($viaje->taxista_id);
                            $user = $taxista->user;
                        @endphp
                        <div style="width: 50%; float: left;">Taxista: {{ $user->name }} {{ $user->apellidos }}</div> 
                    @else
                        <div style="width: 50%; float: left;">Colaboración <span class="text-red-500">[{{ $viaje->colaborador->name }}]</div> 
                    @endif
                    <div style="width: 50%; float: right;">Comercial: {{ $viaje->user->name }} {{ $viaje->user->apellidos }}</div>
                </div>

                <p style="width: 100%">
                    {{ $viaje->costo }} {{ $viaje->divisa->sigla }} | {{ $viaje->pasajeros }} Pax
                </p>
            </div>

           

            <div style="width: 100%; margin-top: 2px;">
               
                <div style="width: 33.3%;float: left;">Ida y Vuelta: [{!! $viaje->back ? 'SI' : 'NO' !!}]</div>
               
                <div style="width: 33.3%;float: left;">Aire: [{!! $viaje->aire ? 'SI' : 'NO' !!}]</div>
                
                <div style="width: 33.3%;float: left;">Reservado: {!! $viaje->fecha != null ?? $viaje->fecha->format('d-m-Y h:i A') !!}</div>
                
            </div>

            <div style="width: 100%; margin-top: 2px">
                <p><span>{{ $viaje->origen }} -> </span>
                    @foreach($viaje->paradas as $parada)
                        <span>{{ $parada->nombre }} -> </span>
                    @endforeach
                    <span>{{ $viaje->destino }}</span>
                </p>
            </div>

        </div>   
        @php
            $iterator++;
        @endphp 

        @if(isset($viajes[$iterator]))
            @if($iterator == 4)
                @php
                    $iterator = 0;
                @endphp
                <div class="page-break"></div>
            @endif
        @endif
        @endforeach
    </div>

</body>
</html>