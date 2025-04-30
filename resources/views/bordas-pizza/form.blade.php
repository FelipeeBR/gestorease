@php
    $borda= $borda ?? null;
@endphp
<form action="{{ isset($borda->id) ? route('bordas-pizza.update', $borda->id) : route('bordas-pizza.store') }}" method="POST">
    @csrf
    @if(isset($borda->id))
        @method('PUT')
    @endif

    <div class="card-body">
        <div class="form-group">
            <label for="nome">Nome da Borda</label>
            <input type="text" class="form-control" id="nome" name="nome" 
                value="{{ old('nome', $borda->nome ?? '') }}" required>
        </div>
        <div class="form-group">
            <label for="preco">Preço Adicional</label>
            <input type="number" class="form-control" id="preco_adicional" name="preco_adicional" 
                value="{{ old('preco_adicional', $borda->preco_adicional ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="preco">Status</label>
            <x-adminlte-input-switch 
                name="sw2" 
                data-on-text="ATIVO"
                data-off-text="INATIVO"
                data-on-color="success"
                data-off-color="danger"
                checked="{{ old('status', $borda->status ?? false) ? true : false }}"
            />
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> {{ isset($borda->id) ? 'Atualizar Borda' : 'Salvar' }}
        </button>
        <a href="{{ route('bordas-pizza.index') }}" class="btn btn-secondary ml-2">
            <i class="fas fa-arrow-left"></i> Cancelar
        </a>
    </div>
</form>

@section('js')
    <script> 
        
    </script>
@stop