<div class="mt-3">
    <div class="col-span-full xl:col-span-8 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
        <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
            <h2 class="font-semibold text-slate-800 dark:text-slate-100">Listado de Cortes</h2>
        </header>
        <div class="p-3">
    
            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="table-auto w-full dark:text-slate-300">
                    <!-- Table header -->
                    <thead class="text-xs uppercase text-slate-400 dark:text-slate-500 bg-slate-50 dark:bg-slate-700 dark:bg-opacity-50 rounded-sm">
                        <tr>
                            <th class="p-2">
                                <div class="font-semibold text-left">Período</div>
                            </th>
                            <th class="p-2">
                                <div class="font-semibold text-center">Ingreso Total</div>
                            </th>
                            <th class="p-2">
                                <div class="font-semibold text-center">Gasto Total</div>
                            </th>
                            <th class="p-2">
                                <div class="font-semibold text-center">Viajes</div>
                            </th>
                            <th class="p-2">
                                <div class="font-semibold text-center">Viajes Eliminados</div>
                            </th>
                        </tr>
                    </thead>
                    <!-- Table body -->
                    <tbody class="text-sm font-medium divide-y divide-slate-100 dark:divide-slate-700">
                        
                        @foreach ($cierres as $key => $cierre)
                            @php
                                if( isset($cierres[$key+1] ))
                                    $next = $cierres->get($key+1);
                                else
                                    $next = null;
                            @endphp

                            <!-- Row -->
                            <tr>
                                <td class="p-2">
                                    <div class="text-slate-800 dark:text-slate-100">
                                        <a class="text-blue-500" href="{{ route('show.cierre', $cierre->id ) }}">{{ $cierre->getPeriodo() }}</a>
                                    </div> 
                                </td>
                                <td class="p-2">
                                    <div class="text-center">
                                        @if($next != null)
                                            @if ($cierre->ingreso_semanal > $next->ingreso_semanal)
                                                <i class="fas fa-arrow-up text-green-700"></i>
                                            @else
                                            <i class="fas fa-arrow-down text-red-700"></i>
                                            @endif
                                        @endif
                                        {{ $cierre->ingreso_semanal }}
                                    </div>
                                </td>
                                <td class="p-2">
                                    <div class="text-center">
                                        @if($next != null)
                                            @if ($cierre->gastosTotales() > $next->gastosTotales())
                                                <i class="fas fa-arrow-up text-green-700"></i>
                                            @else
                                            <i class="fas fa-arrow-down text-red-700"></i>
                                            @endif
                                        @endif
                                        {{ $cierre->gastosTotales() }}
                                    </div>
                                </td>
                                <td class="p-2">
                                    <div class="text-center">
                                        @if($next != null)
                                            @if ($cierre->viajes > $next->viajes)
                                                <i class="fas fa-arrow-up text-green-700"></i>
                                            @else
                                            <i class="fas fa-arrow-down text-red-700"></i>
                                            @endif
                                        @endif
                                        {{ $cierre->viajes }}
                                    </div>
                                </td>
                                <td class="p-2">
                                    <div class="text-center">
                                        @if($next != null)
                                            @if ($cierre->viajes_eliminados > $next->viajes_eliminados)
                                                <i class="fas fa-arrow-up text-red-700"></i>
                                            @else
                                            <i class="fas fa-arrow-down text-green-700"></i>
                                            @endif
                                        @endif
                                        {{ $cierre->viajes_eliminados }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
    
            </div>

            <div class="divide-x"></div>

            <div class="mt-4">
                {{ $cierres->links() }}
            </div>

        </div>
    </div>
</div>
