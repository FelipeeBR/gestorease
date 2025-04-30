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
        <div>
            <label for="preco">Preço Adicional</label>
            <input type="number" class="form-control" id="preco_adicional" name="preco_adicional" 
                value="{{ old('preco_adicional', $borda->preco_adicional ?? '') }}" required>
        </div>
        
        <div class="form-group">
            <div class="custom-control custom-switch">
                <input type="checkbox" 
                       class="custom-control-input" 
                       id="statusSwitch" 
                       name="status"
                       {{ isset($borda) && $borda->status ? 'checked' : '' }}>
                <label class="custom-control-label" for="statusSwitch">
                    {{ isset($borda) && $borda->status ? 'Ativo' : 'Inativo' }}
                </label>
            </div>
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
        $(function() {
            $('[data-toggle="toggle"]').bootstrapToggle();
        });
    </script>
@stop