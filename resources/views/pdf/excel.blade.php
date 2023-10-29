<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $titulo }}</title>
</head>
<body>
    <table>
        <thead>
        <tr>
            <th>Costo</th>
            <th>Pax</th>
            <th>Origen</th>
            <th>Destino</th>
            <th>Reservado</th>
            <th>Taxista/ Colaboracion(Salida)</th>
            <th>comercial/ Colaboracion(Entrada)</th>
            <th>Fecha</th>
        </tr>
        </thead>
        <tbody>
        @foreach($viajes as $viaje)
            @if($viaje->colaborador_id != null)
                <tr>
                    <td><b>{{ $viaje->costo }} {{ $viaje->divisa->sigla }}</b></td>
                    <td><b>{{ $viaje->pasajeros }}</b></td>
                    <td><b>{{ $viaje->origen }}</b></td>
                    <td>
                        <b>
                        @foreach($viaje->paradas as $parada)
                            <span>{{ $parada->nombre }} -> </span>
                        @endforeach
                        {{ $viaje->destino }}
                        </b>
                    </td>
                    <td><b>{!! $viaje->fecha != null ?? $viaje->fecha->format('d-m-Y h:i A') !!}</b></td>
                    <td>
                        <b>
                            @if($viaje->type_colaboracion == 'salida') 
                                {{ $viaje->colaborador->name }} 
                            @elseif ($viaje->taxista) 
                                {{ $viaje->taxista->user->name }} 
                            @else 
                                Pendiente 
                            @endif
                            </b>
                    </td> 
                    <td>
                        <b>{!! $viaje->type_colaboracion == 'entrada' ? $viaje->colaborador->name :  $viaje->user->name !!}</b>
                    </td>
                    <td><b>{{ $viaje->created_at->format('d-m-Y') }}</b></td>
                </tr>
            @else
                <tr>
                    <td>{{ $viaje->costo }} {{ $viaje->divisa->sigla }}</td>
                    <td>{{ $viaje->pasajeros }}</td>
                    <td>{{ $viaje->origen }}</td>
                    <td>
                        @foreach($viaje->paradas as $parada)
                            <span>{{ $parada->nombre }} -> </span>
                        @endforeach
                        {{ $viaje->destino }}
                    </td>
                    <td>{!! $viaje->fecha != null ?? $viaje->fecha->format('d-m-Y h:i A') !!}</td>
                    <td>
                        {{ $viaje->taxista ? $viaje->taxista->user->name : 'Pendiente'}}
                    </td> 
                    <td>
                        {{  $viaje->user->name }}
                    </td>
                    <td>{{ $viaje->created_at->format('d-m-Y') }}</td>
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>
    
</body>
</html>