<div class="mt-3 mx-px ">
   
    <div class="flex flex-row-reverse space-x-4 space-x-reverse" x-data="{horario: @entangle('horario')}">
        @foreach ($horarios as $h)
        <div class="w-auto mx-1">    
            <button wire:click.prevent="setHorario({{ $h->id }})"
                :class=" horario.id == '{{ $h->id }}' ? 'bg-indigo-600' : 'bg-indigo-500' "
                class="rounded-md btn  hover:bg-indigo-600 text-white">{{ $h->name }}</button>
        </div>
        @endforeach
    </div>

    <div class="mt-2 p-2 bg-white shadow-lg rounded-lg">
        
        <div class="flex flex-auto" x-data="{auto: @entangle('auto')}">
           
            @foreach ($autos as $key => $a)
                <div class="mx-1" :key="{{ $key }}">
                    <button  x-on:click="auto = '{{ $a }}'" wire:click="getHorario('{{ $a }}')" :class=" auto == '{{ $a }}' ? 'bg-indigo-600' : 'bg-indigo-500' " class="btn rounded-md hover:bg-indigo-600 text-white">{{ $a }}</button>
                </div>
            @endforeach
            


        </div>
        <hr class="my-2">
        <div class="w-full mt-3">
            <h3>Tabla de Kilometraje</h3>
            <table class="w-full table-auto border-collapse border border-slate-500">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="border border-slate-600">Desde</th>
                        <th class="border border-slate-600">Hasta</th>
                        <th class="border border-slate-600">Opcion</th>
                        <th class="border border-slate-600">Valor</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($rows[$auto])
                    @foreach ($rows[$auto] as $item)
                    
                    <tr>
                        <td class="border border-slate-700 text-right">
                            <input type="text" class=" rounded-sm border border-gray-600 w-full" wire:model="rows.{{ $auto }}.desde">
                        </td>
                        <td class="border border-slate-700 text-right">
                            <input type="text" class=" rounded-sm border border-gray-600 w-full" wire:model="rows.{{ $auto }}.hasta">
                        </td>
                        <td class="border border-slate-700 text-right">

                        </td>
                        <td class="border border-slate-700 text-right">
                            <input type="text" class=" rounded-sm border border-gray-600 w-full">
                        </td>
                    </tr>
                    @endforeach
                    @endisset
                </tbody>
            </table>
        </div>

    </div>

</div> 
 