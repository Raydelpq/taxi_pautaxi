<div class="form-group">
    <label for="colaborador">Colaborador</label>
    <select name="colaborador" id="colaborador" wire:model='colaborador_id' wire:change="change" class="form-select">
        <option value=""></option>
        @foreach ($colaboradores as $colaborador)
            <option value="{{ $colaborador->id }}">{{ $colaborador->name }}</option>
        @endforeach
    </select>
</div>
