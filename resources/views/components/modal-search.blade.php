<!-- Search button -->
<div x-data="{ searchOpen: false }">
    <!-- Button -->
    <button
        class="w-8 h-8 flex items-center justify-center bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600/80 rounded-full"
        :class="{ 'bg-slate-200': searchOpen }"
        @click.prevent="searchOpen = true;"
        aria-controls="search-modal"
    >
        <span class="sr-only">Search</span>
        <svg class="w-4 h-4" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
            <path class="fill-current text-slate-500 dark:text-slate-400" d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
            <path class="fill-current text-slate-400 dark:text-slate-500" d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
        </svg>
    </button>
    <!-- Modal backdrop -->
    <div
        class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity"
        x-show="searchOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-out duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        aria-hidden="true"
        x-cloak
    ></div>
    <!-- Modal dialog -->
    <div
        id="search-modal"
        class="fixed inset-0 z-50 overflow-hidden flex items-start top-20 mb-4 justify-center px-4 sm:px-6"
        role="dialog"
        aria-modal="true"
        x-show="searchOpen"
        x-transition:enter="transition ease-in-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in-out duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4"
        x-cloak
    >
        <div
            class="bg-white dark:bg-slate-800 border border-transparent dark:border-slate-700 overflow-auto max-w-2xl w-full max-h-full rounded shadow-lg"
            @click.outside="searchOpen = false"
            @keydown.escape.window="searchOpen = false"
        >   
            
            <div class="py-4 px-2">
                <!-- Recent searches -->
                <div class="mb-3 last:mb-0">
                    <div class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase px-2 mb-2">Reportes Recientes</div>
                    <ul class="text-sm">
                        @php
                            $reportes = Auth::user()->getMedia('reporte');
                        @endphp
                        @for( $i = count($reportes); $i > 0;  $i--)
                            @php
                                $reporte = $reportes[$i-1];
                            @endphp
                        <li>
                            <a class="flex items-center p-2 text-slate-800 dark:text-slate-100 hover:text-white hover:bg-indigo-500 rounded group" target="__blank" href="{{ $reporte->getFullUrl() }}" @click="searchOpen = false" @focus="searchOpen = true" @focusout="searchOpen = false">
                                @php
                                    $list = explode('.',$reporte->file_name);
                                    $ext = end( $list );
                                @endphp
                                @if($ext == 'pdf') <i class="fas fa-file-pdf flex-none"></i> @else <i class="fas fa-file-excel flex-none"></i> @endif
                                <span class="grow">&nbsp; {{ $reporte->name }}.{{ $ext }} </span> 
                                <span class="flex-none">{{ $reporte->human_readable_size }}</span>
                            </a>
                        </li>
                        @endfor
                    </ul>
                </div>
            </div>
        </div>
    </div>                    
</div>