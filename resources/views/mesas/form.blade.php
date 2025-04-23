<form action="{{ isset($mesa) ? route('mesas.update', $mesa->id) : route('mesas.store') }}" method="POST">
    @csrf
    @if(isset($mesa))
        @method('PUT')
    @endif

    <div class="card-body">
        <div class="form-group">
            <label for="numero">Número da Mesa (Nome)</label>
            <input type="text" class="form-control @error('numero') is-invalid @enderror" 
                   id="numero" name="numero" 
                   value="{{ old('numero', $mesa->numero ?? '') }}"
                   placeholder="Ex: M01, Mesa 1, A12, etc.">
            @error('numero')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                <option value="livre" {{ (old('status', $mesa->status ?? 'livre') == 'livre') ? 'selected' : '' }}>Livre</option>
                <option value="ocupada" {{ (old('status', $mesa->status ?? '') == 'ocupada') ? 'selected' : '' }}>Ocupada</option>
                <option value="reservada" {{ (old('status', $mesa->status ?? '') == 'reservada') ? 'selected' : '' }}>Reservada</option>
                <option value="inativa" {{ (old('status', $mesa->status ?? '') == 'inativa') ? 'selected' : '' }}>Inativa</option>
            </select>
            @error('status')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="card-footer">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> {{ isset($mesa) ? 'Atualizar' : 'Salvar' }}
        </button>
        <a href="{{ route('mesas.index') }}" class="btn btn-default float-right">
            <i class="fas fa-times"></i> Cancelar
        </a>
    </div>
</form>