<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="" style="color-scheme: light;">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Taxi') }} @isset($titulo)| {{ $titulo }} @endisset</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="shortcut icon" href="{{ asset('img/icon.png') }}" type="image/x-icon">

        <!-- Styles -->
        @livewireStyles

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css"> 
        <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert2.min.css') }}">
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
        @stack('code-css')          
    </head>
    <body
        class="font-inter antialiased bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400"
        :class="{ 'sidebar-expanded': sidebarExpanded }"
        x-data="{ sidebarOpen: false, sidebarExpanded: localStorage.getItem('sidebar-expanded') == 'true' }"
        x-init="$watch('sidebarExpanded', value => localStorage.setItem('sidebar-expanded', value))"    
    >
        
        <livewire:models.filter.viajes />

        <script>
            if (localStorage.getItem('sidebar-expanded') == 'true') {
                document.querySelector('body').classList.add('sidebar-expanded');
            } else {
                document.querySelector('body').classList.remove('sidebar-expanded');
            }
        </script>

        <!-- Page wrapper -->
        <div class="flex h-screen overflow-hidden">

            <x-app.sidebar />

            <!-- Content area -->
            <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden @if($attributes['background']){{ $attributes['background'] }}@endif" x-ref="contentarea">

                <x-app.header />

                @if (session('status'))
                    <div class="w-full md:w-4/5 mx-auto mb-4 rounded-sm mt-3 bg-danger-100 px-6 py-5 text-base text-danger-700" role="alert">
                        {!! session('status') !!}
                    </div>
                @endif

                <main class="w-full md:w-4/5 mx-auto"> 
                    <div class="mx-2 md:mx-0">
                        {{ $slot }}
                    </div>
                </main>

            </div>

        </div>

        @livewireScripts
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9" charset="UTF-8"></script>
        <script src="{{ asset('js') }}/flatpickr.js"></script>
        <script src="{{ asset('js') }}/flatpickr.es.js"></script>
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000
            });

            Livewire.on('message', (message, icon, timer = 2000)=> {  
                Toast.fire({
                    icon: icon,
                    title: message,
                    timer: timer
                });
            })

        </script>
        @stack('code-js')
    </body>
</html>
