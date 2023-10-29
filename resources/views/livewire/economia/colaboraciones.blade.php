<div class="overflow-x-auto">
    <table class="table-auto w-full">
        <!-- Table header -->
        <thead class="text-xs font-semibold uppercase text-slate-400 dark:text-slate-500 bg-slate-50 dark:bg-slate-700 dark:bg-opacity-50">
            <tr>
                <th class="p-2 whitespace-nowrap">
                    <div class="font-semibold text-left">Agencia</div>
                </th>

                <th class="p-2 whitespace-nowrap">
                    <div class="font-semibold text-left">Entrada</div>
                </th>
                <th class="p-2 whitespace-nowrap">
                    <div class="font-semibold text-left">Importe Entrada</div>
                </th>
                <th class="p-2 whitespace-nowrap">
                    <div class="font-semibold text-left">Monto Entrada</div>
                </th>

                <th class="p-2 whitespace-nowrap">
                    <div class="font-semibold text-left">Salida</div>
                </th>
                <th class="p-2 whitespace-nowrap">
                    <div class="font-semibold text-left">Importe Salida</div>
                </th>
                <th class="p-2 whitespace-nowrap">
                    <div class="font-semibold text-left">Monto Salida</div>
                </th>
                <th class="p-2 whitespace-nowrap">
                    
                </th>
            </tr>
        </thead>
        <!-- Table body -->
        <tbody class="text-sm divide-y divide-slate-100 dark:divide-slate-700">

            @forelse ($viajes as $key => $viaje) 
                <tr>
                    @php
                        $datos = $this->getViajesColaboracion($viaje->colaborador->id);
                    @endphp
                    <td class="p-2 whitespace-nowrap">
                        <div class="text-left font-medium text-green-500">{{ $viaje->colaborador->name }}</div>
                    </td>

                    <td class="p-2 whitespace-nowrap">
                        <div class="text-lg text-center">{{ $datos['entrada']->Cantidad }}</div>
                    </td>
                    <td class="p-2 whitespace-nowrap">
                        <div class="text-lg text-center">{{ $datos['entrada']->Importe }}</div>
                    </td>
                    <td class="p-2 whitespace-nowrap">
                        <div class="text-lg text-center">{{ $datos['entrada']->Monto/2 }}</div>
                    </td>

                    <td class="p-2 whitespace-nowrap">
                        <div class="text-lg text-center">{{ $datos['salida']->Cantidad }}</div>
                    </td>
                    <td class="p-2 whitespace-nowrap">
                        <div class="text-lg text-center">{{ $datos['salida']->Importe }}</div>
                    </td>
                    <td class="p-2 whitespace-nowrap">
                        <div class="text-lg text-center">{{ $datos['salida']->Monto/2 }}</div>
                    </td>
                    <td class="p-2 whitespace-nowrap">
                        <div class="text-lg text-center">{{ ($datos['salida']->Monto/2) - ($datos['entrada']->Monto/2) }}</div>
                    </td>
                </tr>
            @empty
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <h3 class=" text-center col-span-full mt-4  animate-bounce">No hay Viajes de Colaboradores</h3>
                </div>
            @endforelse
        </tbody>
    </table>

</div>
