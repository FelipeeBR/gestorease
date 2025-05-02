@php
    $borda= $borda ?? null;
@endphp
<form action="{{ isset($borda->id) ? route('bordas-pizza.update', $borda->id) : route('bordas-pizza.store') }}" method="POST">
    @csrf
    @if(isset($borda->id))
        @method('PUT')
    @endif

    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nome">Nome da Borda</label>
                    <input type="text" class="form-control" id="nome" name="nome" 
                        value="{{ old('nome', $borda->nome ?? '') }}" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="preco">Preço Adicional R$</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">R$</span>
                        </div>
                        <input type="number" class="form-control" id="preco_adicional" name="preco_adicional" 
                            value="{{ old('preco_adicional', $borda->preco_adicional ?? '') }}" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="status">Status</label>
                    <x-adminlte-input-switch 
                        name="ativo"
                        id="status"
                        data-on-text="ATIVO"
                        data-off-text="INATIVO"
                        data-on-color="success"
                        data-off-color="danger"
                        checked="{{ old('ativo', $borda->ativo ?? 0) ? 1 : 0 }}"
                    />
                </div>
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

    </script>
@stop