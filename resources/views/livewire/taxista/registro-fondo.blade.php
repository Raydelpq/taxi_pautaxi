<div>
    <div class="overflow-x-auto">
        <table class="table-auto w-full dark:text-slate-300">
            <!-- Table header -->
            <thead class="text-xs uppercase text-slate-400 dark:text-slate-500 bg-slate-50 dark:bg-slate-700 dark:bg-opacity-50 rounded-sm">
                <tr>
                    <th class="p-2">
                        <div class="font-semibold text-left">Comercial</div>
                    </th>
                    <th class="p-2">
                        <div class="font-semibold text-left">Método</div>
                    </th>
                    <th class="p-2">
                        <div class="font-semibold text-center">Saldo</div>
                    </th>
                    <th class="p-2">
                        <div class="font-semibold text-center">Fondo</div>
                    </th>
                    <th class="p-2">
                        <div class="font-semibold text-center">Activo</div>
                    </th>
                    <th class="p-2">
                        <div class="font-semibold text-center">fecha</div> 
                    </th>
                </tr>
            </thead>
            <!-- Table body -->
            <tbody class="text-sm font-medium divide-y divide-slate-100 dark:divide-slate-700"> 
                <!-- Row -->
                @foreach ($fondos as $fondo)
                <tr>
                    <td class="p-2">
                        <div class="text-left">{{ $fondo->comercial->name }}</div>
                    </td>
                    <td class="p-2">
                        <div class="text-center @if($fondo->type == "Retiro") text-danger-500  @else text-emerald-500 @endif">{{ $fondo->type }}</div>
                    </td>
                    <td class="p-2">
                        <div class="text-center">{{ $fondo->saldo }}</div>
                    </td>
                    <td class="p-2">
                        <div class="text-center">{{ $fondo->fondo }}</div>
                    </td>
                    <td class="p-2">
                        <div class="text-center ">{{ $fondo->activo }}</div>
                    </td>
                    <td class="p-2">
                        <div class="text-right">{{ $fondo->created_at->format('d-m-Y h:i A') }}</div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $fondos->links() }}
        </div>

    </div>
</div>
