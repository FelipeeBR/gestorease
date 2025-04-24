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
            <label for="preco_venda">Preço de Venda</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">R$</span>
                </div>
                <input type="number" class="form-control" id="preco_venda" 
                    name="preco_venda" step="0.01" min="0" 
                    value="{{ old('preco_venda', $produto->preco_venda ?? '') }}" required>
            </div>
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
        
        <div class="form-group">
            <label for="descricao">Descrição (Ingredientes)</label>
            <textarea class="form-control" id="descricao" name="descricao" rows="3">{{ old('descricao', $produto->descricao ?? '') }}</textarea>
        </div>
        
        <div class="form-group">
            <label for="quantidade_estoque">Quantidade em Estoque</label>
            <input type="number" class="form-control" id="quantidade_estoque" 
                name="quantidade_estoque" min="0" 
                value="{{ old('quantidade_estoque', $produto->quantidade_estoque ?? 0) }}">
        </div>

        <div class="form-group">
            <label for="tem_variacoes">
                <input type="checkbox" id="tem_variacoes" name="tem_variacoes" value="1"
                    {{ old('tem_variacoes', $produto->tem_variacoes ?? false) ? 'checked' : '' }}>
                Este produto tem variações (tamanhos, cores, etc.)
            </label>
        </div>
        
        <div id="variacoes-container" style="display: none;">
            <h5>Variações</h5>
            
            <div class="variacao-item mb-3 p-3 border">
                <div class="row">
                    <div class="col-md-3">
                        <label>Nome (ex: Tamanho)</label>
                        <input type="text" name="variacoes[0][nome]" class="form-control" value="Tamanho">
                    </div>
                    <div class="col-md-3">
                        <label>Valor (ex: Grande)</label>
                        <input type="text" name="variacoes[0][valor]" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label>Preço Adicional</label>
                        <input type="number" step="0.01" name="variacoes[0][preco_adicional]" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label>Estoque</label>
                        <input type="number" name="variacoes[0][estoque]" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-remove-variacao mt-4">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <button type="button" id="btn-add-variacao" class="btn btn-secondary">
                <i class="fas fa-plus"></i> Adicionar Variação
            </button>
        </div>        
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">
            {{ isset($produto->id) ? 'Atualizar Produto' : 'Adicionar Produto' }}
        </button>
    </div>
</form>

@push('scripts')
    <script>
        $(document).ready(function() {
            console.log('Checkbox está checado?', $('#tem_variacoes').is(':checked'));
            console.log('Estado inicial do container:', $('#variacoes-container').css('display'));
            function toggleVariacoesContainer() {
                $('#variacoes-container').toggle($('#tem_variacoes').is(':checked'));
            }

            $('#tem_variacoes').change(toggleVariacoesContainer);
            toggleVariacoesContainer();

            let variacaoCount = 1;
            $('#btn-add-variacao').click(function() {
                const newItem = $('.variacao-item').first().clone();
                newItem.find('input').val('');
                newItem.find('[name]').each(function() {
                    const name = $(this).attr('name').replace(/\[\d+\]/, `[${variacaoCount}]`);
                    $(this).attr('name', name);
                });
                $('#variacoes-container').append(newItem);
                variacaoCount++;
            });
            $(document).on('click', '.btn-remove-variacao', function() {
                if ($('.variacao-item').length > 1) {
                    $(this).closest('.variacao-item').remove();
                }
            });
        });
    </script>
@endpush