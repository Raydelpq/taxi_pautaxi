
<div class="col-span-full xl:col-span-6 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Top 5 Taxistas</h2>
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
                            <div class="font-semibold text-center">Viajes</div>
                        </th>
                    </tr>
                </thead> 
                <!-- Table body -->
                <tbody class="text-sm font-medium divide-y divide-slate-100 dark:divide-slate-700">
                    <!-- Row -->
                    
                    @foreach ($taxistas as $taxista)
                    @php
                        $user = $this->getuser($taxista->id);
                    @endphp
                        <tr>
                            <td class="p-2">
                                <div class="flex items-start">
                                    <img src="{{ $user->getMedia('avatar')->first() != null ? $user->getMedia('avatar')->first()->getFullUrl() : asset('img/no-avatar.png') }}" class="shrink-0 mr-2 sm:mr-3 rounded h-8 border border-slate-900 dark:border-slate-300" width="36" height="36" >
                                    <div class="text-slate-800 dark:text-slate-100"><a href="{{ route('taxista.show', $user->taxista->id) }}">{{ $user->name }}</a></div>
                                </div>
                            </td>
                            <td class="p-2">
                                <div class="text-center text-emerald-500">{{ $taxista->total }}</div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>