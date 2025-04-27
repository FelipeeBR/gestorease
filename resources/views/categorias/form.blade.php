@php
    $categoria = $categoria ?? null;
@endphp
<form action="{{ isset($categoria->id) ? route('categorias.update', $categoria->id) : route('categorias.store') }}" method="POST">
    @csrf
    @if(isset($categoria->id))
        @method('PUT')
    @endif
    <div class="card-body">
        <div class="form-group">
            <label for="nome">Nome da Categoria</label>
            <input type="text" class="form-control" id="nome" name="nome" 
                value="{{ old('nome', $categoria->nome ?? '') }}" required>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> {{ isset($categoria->id) ? 'Atualizar Categoria' : 'Salvar' }}
        </button>
        <a href="{{ route('categorias.index') }}" class="btn btn-default float-right">
            <i class="fas fa-times"></i> Cancelar
        </a>
    </div>
</form>