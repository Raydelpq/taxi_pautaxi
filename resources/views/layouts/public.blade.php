<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="" style="color-scheme: light;">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta name="description" content="El Taxista {{ $taxista->user->name }} conduce un auto {{ $taxista->marca }} {{ $taxista->modelo }} {{ $taxista->color }}" />
        <meta property="og:type" content="website" />
        <meta property="og:site_name" content="{{ env('APP_NAME') }}" />
        <meta property="og:title" content="Taxista {{ $taxista->user->name }}" />
        <meta property="og:url" content="{{ config('app.url') }}/taxista/public/{{ $taxista->user->id }}" />
        <meta property="og:description" content="Conduce un auto {{ $taxista->marca }} {{ $taxista->modelo }} {{ $taxista->color }}" />
        <meta property="og:image" content="{{ $taxista->getMedia('taxi')->first()->getFullUrl() }}" />
        <meta property="og:image:width" content="400" />
        <meta property="og:image:height" content="600" />

        <title>{{ config('app.name', 'Taxi') }} | {{ $title }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="shortcut icon" href="{{ asset('img/icon.png') }}" type="image/x-icon">
        <!-- Styles -->
        @livewireStyles

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script>
            if (localStorage.getItem('dark-mode') === 'false' || !('dark-mode' in localStorage)) {
                document.querySelector('html').classList.remove('dark');
                document.querySelector('html').style.colorScheme = 'light';
            } else {
                document.querySelector('html').classList.add('dark');
                document.querySelector('html').style.colorScheme = 'dark';
            }
        </script>
        <link rel="stylesheet" href="{{ asset('css') }}/style.css">
        <link rel="stylesheet" href="{{ asset('fontawesome-free/css/all.min.css') }}">       
    </head>
    <body
        class="font-inter antialiased bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400"
        :class="{ 'sidebar-expanded': sidebarExpanded }"
        x-data="{ sidebarOpen: false, sidebarExpanded: localStorage.getItem('sidebar-expanded') == 'true' }"
        x-init="$watch('sidebarExpanded', value => localStorage.setItem('sidebar-expanded', value))"    
    >
    

        <script>
            if (localStorage.getItem('sidebar-expanded') == 'true') {
                document.querySelector('body').classList.add('sidebar-expanded');
            } else {
                document.querySelector('body').classList.remove('sidebar-expanded');
            }
        </script>

        <!-- Page wrapper -->
        <div class="flex h-screen overflow-hidden">

           

            <!-- Content area -->
            <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden" x-ref="contentarea">

                

                @if (session('status'))
                    <div class="w-full md:w-4/5 mx-auto mb-4 rounded-sm mt-3 bg-danger-100 px-6 py-5 text-base text-danger-700" role="alert">
                        {!! session('status') !!}
                    </div>
                @endif

                <main class="w-full md:w-4/5 mx-auto"> 
                    {{ $slot }}
                </main>

            </div>

        </div>

        @livewireScripts
    </body>
</html>
