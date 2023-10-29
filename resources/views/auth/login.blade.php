<x-authentication-layout>
    <h1 class="text-3xl text-slate-800 dark:text-slate-100 font-bold mb-6">{{ __('Bienvenido!') }} ✨</h1>
    @if (session('status'))
        <div class="mb-4 font-medium text-center text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif   
    <!-- Form -->
    <form method="POST" action="{{ route('login') }}"> 
        @csrf
        <div class="space-y-4">
            <div>
                <x-jet-label for="email" value="{{ __('Correo Electrónico o Teléfono') }}" />
                <x-jet-input id="email" type="text" name="identity" :value="old('identity')" required autofocus />                
            </div>
            <div>
                <x-jet-label for="password" value="{{ __('Contraseña') }}" />
                <x-jet-input id="password" type="password" name="password" required autocomplete="current-password" />                
            </div>
        </div>
        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <div class="mr-1">
                    <a class="text-sm underline hover:no-underline" href="{{ route('password.request') }}">
                        {{ __('¿Ha Olvidado su Contraseña?') }}
                    </a>
                </div>
            @endif
                          
            <x-jet-button class="ml-3">
                {{ __('Acceder') }}
            </x-jet-button>            
        </div>
    </form>
    <x-jet-validation-errors class="mt-4" />   
    <!-- Footer -->
    <div class="pt-5 mt-6 border-t border-slate-200">
        <div class="text-sm">
            {{ __('¿Aún no tiene una cuenta?') }} <a class="font-medium text-indigo-500 hover:text-indigo-600" href="{{ route('register') }}">{{ __('Pinche Aquí') }}</a>
        </div>
        <!-- Warning -->
        <!-- <div class="mt-5">
            <div class="bg-amber-100 text-amber-600 px-3 py-2 rounded">
                <svg class="inline w-3 h-3 shrink-0 fill-current" viewBox="0 0 12 12">
                    <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                </svg>
                <span class="text-sm">
                    To support you during the pandemic super pro features are free until March 31st.
                </span>
            </div>
        </div> -->
    </div>
</x-authentication-layout>
