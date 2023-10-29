<div>

    <div class="relative bg-indigo-200 dark:bg-indigo-500 p-4 mt-2 sm:p-6 rounded-sm overflow-hidden mb-8">

        <!-- Background illustration -->
        <div class="absolute right-0 top-0 -mt-4 mr-16 pointer-events-none hidden xl:block" aria-hidden="true">
            <svg width="319" height="198" xmlns:xlink="http://www.w3.org/1999/xlink">
                <defs>
                    <path id="welcome-a" d="M64 0l64 128-64-20-64 20z"></path>
                    <path id="welcome-e" d="M40 0l40 80-40-12.5L0 80z"></path>
                    <path id="welcome-g" d="M40 0l40 80-40-12.5L0 80z"></path>
                    <linearGradient x1="50%" y1="0%" x2="50%" y2="100%" id="welcome-b">
                        <stop stop-color="#A5B4FC" offset="0%"></stop>
                        <stop stop-color="#818CF8" offset="100%"></stop>
                    </linearGradient>
                    <linearGradient x1="50%" y1="24.537%" x2="50%" y2="100%" id="welcome-c">
                        <stop stop-color="#4338CA" offset="0%"></stop>
                        <stop stop-color="#6366F1" stop-opacity="0" offset="100%"></stop>
                    </linearGradient>
                </defs>
                <g fill="none" fill-rule="evenodd">
                    <g transform="rotate(64 36.592 105.604)">
                        <mask id="welcome-d" fill="#fff">
                            <use xlink:href="#welcome-a"></use>
                        </mask>
                        <use fill="url(#welcome-b)" xlink:href="#welcome-a"></use>
                        <path fill="url(#welcome-c)" mask="url(#welcome-d)" d="M64-24h80v152H64z"></path>
                    </g>
                    <g transform="rotate(-51 91.324 -105.372)">
                        <mask id="welcome-f" fill="#fff">
                            <use xlink:href="#welcome-e"></use>
                        </mask>
                        <use fill="url(#welcome-b)" xlink:href="#welcome-e"></use>
                        <path fill="url(#welcome-c)" mask="url(#welcome-f)" d="M40.333-15.147h50v95h-50z"></path>
                    </g>
                    <g transform="rotate(44 61.546 392.623)">
                        <mask id="welcome-h" fill="#fff">
                            <use xlink:href="#welcome-g"></use>
                        </mask>
                        <use fill="url(#welcome-b)" xlink:href="#welcome-g"></use>
                        <path fill="url(#welcome-c)" mask="url(#welcome-h)" d="M40.333-15.147h50v95h-50z"></path>
                    </g>
                </g>
            </svg>
        </div>
    
        <!-- Content -->
        <div class="relative">
            <h1 class="text-2xl md:text-3xl text-slate-800 dark:text-slate-100 font-bold mb-1">Bienvenido, {{ Auth::user()->name }} 👋</h1>
        </div>
    
    </div>
    
    <div class="grid grid-cols-12 gap-4 mb-4">
        @role('Administrador')
        <!-- Alertas -->
        <livewire:dashboard.alertas >
        @endrole
        
        <!-- Ultimos 5 viajes -->
        <livewire:dashboard.last-viajes :star="$star" :end="$end">

        @if(Auth::user()->hasRole('Administrador') || Auth::user()->hasRole('Taxista'))
        <!-- Balance de importe -->
        <livewire:dashboard.balance :star="$star" :end="$end">
        @endif

        @role('Administrador')
        <!-- Top 5 en taxistas -->
        <livewire:dashboard.top-taxista :star="$star" :end="$end">
        @endrole

        <!-- Viajes Diarios -->
        <livewire:dashboard.viajes-diarios :star="$star" :end="$end">

    </div>

</div>


@push('code-js')
    
<script>
    
    window.onload=function(){
        
        Livewire.emit('inicio');

        Echo.channel("{{ env('NAME_EVENT') }}.new-viaje")
            .listen('NewViajeEvent', (e) => console.log('Viaje: ' + e.viaje));
    }

</script>

@endpush