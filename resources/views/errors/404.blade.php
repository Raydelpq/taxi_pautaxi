@extends('layouts.error')
<!-- 'errors::minimal' -->
@section('title', __('Recurso No Encontrado'))

@section('code', '404')

@section('message')
<div class="mx-2 md:mx-0">
                       
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
                <h1 class="text-2xl md:text-3xl text-slate-800 dark:text-slate-100 font-bold mb-1">Error @yield('code')</h1> 
            </div>
        
        </div> 

        <div class="grid grid-cols-12 gap-4 items-center">

            <div class="col-span-full sm:col-span-6">
                <i class="fas fa-exclamation-triangle h-full w-full text-warning-600 text-center text-[200px] sm:text-[300px]"></i>
            </div>

            <div class="grid col-span-full sm:col-span-6 justify-center">
                <h3 class="text-warning-600 animate-bounce text-center text-5xl">OopSSSSSS!</h3>
                <h3 class="px-3">El Recurso al que ha intentado acceder no se encuentra o ha sido eliminado de nuestro servidor</h3>

                <h3 class="px-3 mt-3 grid justify-center">
                    <code class="p-3 bg-slate-900 dark:bg-slate-400 text-white w-full">
                        {{ $exception->getMessage() }}
                    </code>
                </h3>

                <div class="flex col-span-full mt-7">
                    <a href="{{ route('dashboard') }}" class="btn bg-indigo-500 hover:bg-indigo-700 text-white flex-none">Ir al Panel</a>
                    <div class="grow"></div>
                    <a href="{{ url()->previous() }}" class="btn bg-indigo-500 hover:bg-indigo-700 text-white flex-none">Regresar</a>
                </div>

            </div>

            

        </div>
    
    </div>
    

</div>
@endsection
