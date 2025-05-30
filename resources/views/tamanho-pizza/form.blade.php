@php
    $tamanho = $tamanho ?? null;
@endphp
<form action="{{ isset($tamanho->id) ? route('tamanho-pizza.update', $tamanho->id) : route('tamanho-pizza.store') }}"  method="POST">
    @csrf
    @if(isset($tamanho->id))
        @method('PUT')
    @endif
    <div class="card-body">
        <div class="form-group">
            <label for="nome">Nome do Tamanho</label>
            <input type="text" class="form-control" id="nome" name="nome" 
                value="{{ old('nome', $tamanho->nome ?? '') }}" required>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> {{ isset($tamanho->id) ? 'Atualizar Tamanho' : 'Salvar' }}
        </button>
        <a href="{{ route('tamanho-pizza.index') }}" class="btn btn-secondary ml-2">
            <i class="fas fa-arrow-left"></i> Cancelar
        </a>
    </div>
</form>