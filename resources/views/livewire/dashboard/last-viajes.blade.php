<div class="col-span-full xl:col-span-6 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Viajes Recientes</h2>
    </header>
    <div class="p-3">

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="table-auto w-full dark:text-slate-300">
                <!-- Table header -->
                <thead class="text-xs uppercase text-slate-400 dark:text-slate-500 bg-slate-50 dark:bg-slate-700 dark:bg-opacity-50 rounded-sm">
                    <tr>
                        <th class="p-2">
                            <div class="font-semibold text-left">Taxista</div>
                        </th>
                        <th class="p-2">
                            <div class="font-semibold text-center">Costo</div>
                        </th>
                        <th class="p-2">
                            <div class="font-semibold text-center">Origen</div>
                        </th>
                        </th>
                    </tr>
                </thead>
                <!-- Table body -->
                <tbody class="text-sm font-medium divide-y divide-slate-100 dark:divide-slate-700">
                    <!-- Row -->
                    
                    @foreach ($viajes as $viaje)
                        <tr>
                            <td class="p-2">
                                <div class="flex items-start">
                                    @if($viaje->taxista_id)
                                        <img src="{{ $viaje->taxista->user->getMedia('avatar')->first() != null ? $viaje->taxista->user->getMedia('avatar')->first()->getFullUrl() : asset('img/no-avatar.png') }}" class="shrink-0 mr-2 sm:mr-3 rounded h-8 border border-slate-900 dark:border-slate-300" width="36" height="36" >
                                        <div class="text-slate-800 dark:text-slate-100"><a href="{{ route('taxista.show', $viaje->taxista->id) }}">{{ $viaje->taxista->user->name }}</a> @if($viaje->colaborador_id) <strong class="text-red-500">[{{ $viaje->colaborador->name }}]</strong> @endif</div>
                                    @else
                                        @if($viaje->colaborador_id)
                                            <div class="text-red-800 dark:text-slate-100">[{{ $viaje->colaborador->name }}]</div> 
                                        @else
                                            <div class="text-red-800 dark:text-slate-100">Pendiente</div>
                                        @endif
                                    @endif
                                </div>
                            </td>
                            <td class="p-2">
                                <div class="text-center text-emerald-500">{{ $viaje->costo }} {{ $viaje->divisa->sigla }}</div>
                            </td>
                            <td class="p-2">
                                <div class="text-right">
                                    <a href="{{ route('viajes.show', $viaje->id) }}">{{ $viaje->origen }}</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
