<div>
    
     <!-- Header -->
     <div class="relative mt-2 bg-indigo-200 dark:bg-indigo-500 p-4 sm:p-6 rounded-sm overflow-hidden mb-8"> 

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
            <h1 class="text-lg md:text-2xl text-center md:text-left text-slate-800 dark:text-slate-100 font-bold mb-1">{{$titulo }}</h1>
            
        </div>
    
    </div>
    <!-- END Header -->

    <div class="grid gap-4 mb-4">

        <div class="mx-auto h-[250px] w-[250px] sm:h-[400px] sm:w-[400px]">
            <img class="rounded-md shadow-md" src="{{ $taxista->user->getMedia('avatar')->first()->getFullUrl() }}" alt="{{$titulo }}">
        </div>

        <div class="grid gap-4 grid-cols-2 sm:grid-cols-3 p-4">
            <h3 class="col-span-1 sm:col-span-1 text-xl">Marca: {{ $taxista->marca }}</h3> 
            <h3 class="col-span-1 sm:col-span-1 text-center sm:text-right text-xl">Modelo: {{ $taxista->modelo }} </h3>
            <h3 class="col-span-full sm:col-span-1 text-center sm:text-left text-xl">Color: {{ $taxista->color }}</h3> 
        </div>

        <div class="mx-auto h-[250px] w-[250px] sm:h-[400px] sm:w-[400px]">
            <img class="rounded-md shadow-md" src="{{ $taxista->getMedia('taxi')->first()->getFullUrl() }}" alt="{{$titulo }}">
        </div>

    </div>

</div> 
