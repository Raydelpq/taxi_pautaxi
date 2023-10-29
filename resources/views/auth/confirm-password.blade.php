<x-authentication-layout>
    <h1 class="text-3xl text-slate-800 dark:text-slate-100 font-bold mb-6">{{ __('Confirme su Contraseña') }} ✨</h1>
    <!-- Form -->
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf
        <div>
            <x-jet-label for="password" value="{{ __('Contraseña') }}" />
            <x-jet-input id="password" type="password" name="password" required autocomplete="current-password" autofocus />
        </div>
        <div class="flex justify-end mt-6">
            <x-jet-button>
                {{ __('Confirmar') }}
            </x-jet-button>
        </div>
    </form>
    <x-jet-validation-errors class="mt-4" />
</x-authentication-layout>
