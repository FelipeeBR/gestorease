@php
    $variacao = $variacao ?? null;
@endphp
<form action="{{ isset($variacao) ? route('pizzas.update', $variacao->id) : route('pizzas.store') }}" method="POST">
    @csrf
    @if(isset($variacao))
        @method('PUT')
    @endif

    <div class="row">
        <!-- Produto -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="produto_id">Produto (Pizza)</label>
                <select class="form-control @error('produto_id') is-invalid @enderror" id="produto_id" name="produto_id" required>
                    <option value="">Selecione um produto</option>
                    @foreach($produtos as $produto)
                        <option value="{{ $produto->id }}" 
                            {{ (old('produto_id', $variacao->produto_id ?? '') == $produto->id) ? 'selected' : '' }}>
                            {{ $produto->nome }}
                        </option>
                    @endforeach
                </select>
                @error('produto_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <!-- Tamanho -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="tamanho_pizza_id">Tamanho</label>
                <select class="form-control @error('tamanho_pizza_id') is-invalid @enderror" id="tamanho_pizza_id" name="tamanho_pizza_id" required>
                    <option value="">Selecione um tamanho</option>
                    @foreach($tamanhos as $tamanho)
                        <option value="{{ $tamanho->id }}"
                            {{ (old('tamanho_pizza_id', $variacao->tamanho_pizza_id ?? '') == $tamanho->id) ? 'selected' : '' }}>
                            {{ $tamanho->nome }}
                        </option>
                    @endforeach
                </select>
                @error('tamanho_pizza_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Preço -->
        <div class="col-md-4">
            <div class="form-group">
                <label for="preco">Preço</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">R$</span>
                    </div>
                    <input type="number" step="0.01" min="0.01" class="form-control @error('preco') is-invalid @enderror" 
                           id="preco" name="preco" 
                           value="{{ old('preco', $variacao->preco ?? '') }}" required>
                </div>
                @error('preco')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <!-- Estoque -->
       <!-- <div class="col-md-4">
            <div class="form-group">
                <label for="estoque">Estoque</label>
                <input type="number" min="0" class="form-control @error('estoque') is-invalid @enderror" 
                       id="estoque" name="estoque" 
                       value="{{ old('estoque', $variacao->estoque ?? 0) }}" required>
                @error('estoque')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div> -->

        <!-- Tipo -->
        <div class="col-md-4">
            <div class="form-group">
                <label for="tipo">Tipo</label>
                <select class="form-control @error('tipo') is-invalid @enderror" id="tipo" name="tipo" required>
                    <option value="salgada" {{ (old('tipo', $variacao->tipo ?? '') == 'salgada') ? 'selected' : '' }}>Salgada</option>
                    <option value="doce" {{ (old('tipo', $variacao->tipo ?? '') == 'doce') ? 'selected' : '' }}>Doce</option>
                </select>
                @error('tipo')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </div>

    <div class="form-group mt-4">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> {{ isset($variacao) ? 'Atualizar' : 'Salvar' }}
        </button>
        <a href="{{ route('pizzas.index') }}" class="btn btn-secondary ml-2">
            <i class="fas fa-arrow-left"></i> Cancelar
        </a>
    </div>
</form>
