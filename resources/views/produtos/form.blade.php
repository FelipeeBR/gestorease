@php
    $produto = $produto ?? null;
@endphp
<form 
    action="{{ isset($produto->id) ? route('produtos.update', $produto->id) : route('produtos.store') }}"
    method="POST">

    @csrf
    @if(isset($produto->id))
        @method('PUT')
    @endif

    <div class="card-body">
        <div class="form-group">
            <label for="nome">Nome do Produto</label>
            <input type="text" class="form-control" id="nome" name="nome" 
                value="{{ old('nome', $produto->nome ?? '') }}" required>
        </div>
        
        <div class="form-group">
            <label for="categoria_id">Categoria</label>
            <select class="form-control" id="categoria_id" name="categoria_id" required>
                <option value="">Selecione...</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" 
                        {{ old('categoria_id', $produto->categoria_id ?? '') == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group price-quantity-group" style="{{ isset($produto->categoria_id) && $produto->categoria_id == 3 ? 'display: none;' : '' }}">
            <label for="preco_venda">Preço de Venda</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">R$</span>
                </div>
                <input type="number" class="form-control" id="preco_venda" 
                    name="preco_venda" step="0.01" min="0" 
                    value="{{ old('preco_venda', $produto->preco_venda ?? 0) }}" required>
            </div>
        </div>
        
        <div class="form-group">
            <label for="descricao">Descrição (Ex: Ingredientes)</label>
            <textarea class="form-control" id="descricao" name="descricao" rows="3" placeholder="Opcional">{{ old('descricao', $produto->descricao ?? '') }}</textarea>
        </div>
        
        <div class="form-group" style="{{ isset($produto->categoria_id) && $produto->categoria_id == 3 ? 'display: none;' : '' }}">
            <label for="quantidade_estoque">Quantidade em Estoque</label>
            <input type="number" class="form-control" id="quantidade_estoque" 
                name="quantidade_estoque" min="0" 
                value="{{ old('quantidade_estoque', $produto->quantidade_estoque ?? 0) }}">
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> {{ isset($produto->id) ? 'Atualizar Produto' : 'Adicionar Produto' }}
        </button>
        <a href="{{ route('produtos.index') }}" class="btn btn-secondary ml-2">
            <i class="fas fa-arrow-left"></i> Cancelar
        </a>
    </div>
</form>

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Função para verificar e mostrar/esconder os campos
        function togglePriceQuantityFields() {
            const categoriaId = $('#categoria_id').val();
            if (categoriaId == '3') { // ID da Pizza
                $('.price-quantity-group').hide();
                $('#preco_venda').removeAttr('required');
            } else {
                $('.price-quantity-group').show();
                $('#preco_venda').attr('required', 'required');
            }
        }
        
        // Verificar ao carregar a página
        togglePriceQuantityFields();
        
        // Verificar quando a categoria é alterada
        $('#categoria_id').change(function() {
            togglePriceQuantityFields();
        });
    });
</script>
@endsection