@if ($errors->any())
    <div {{ $attributes }}>
        <div class="px-4 py-2 rounded-sm text-sm bg-rose-100 border border-rose-200 text-rose-600">
            <div class="font-medium">{{ __('¡Vaya!  Algo salió mal.') }}</div>
            <ul class="mt-1 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
                <li>Puede que se Cuenta no esté Activada</li>
            </ul>
        </div>         
    </div>
@endif
