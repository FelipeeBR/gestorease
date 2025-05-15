@extends('adminlte::page')

@section('title', 'Comanda #'.$comanda->id)

@section('content_header')
    <h1>Comanda #{{ $comanda->id }}</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
@stop

@section('content')
    <div>
        <div class="card card-primary">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Informações</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Data:</strong> {{ $comanda->updated_at->format('d/m/Y H:i:s') }}</p>
                        <p><strong>Total:</strong> R$ {{ number_format($comanda->total, 2, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-secondary">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">Adicionar</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('caixa.comanda.item.store', $comanda->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="produto_id">Produto</label>
                        <select name="produto_id" id="produto_id" class="form-control" required>
                            <option value="">Selecione...</option>
                            @foreach($produtos as $produto)
                                <option value="{{ $produto->id }}" data-categoria="{{ $produto->categoria_id }}" data-preco="{{ $produto->preco_venda }}">
                                    {{ $produto->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group" id="tamanho-group" style="display: none;">
                        <div>
                            <label for="variacao_pizza">Tamanho da Pizza</label>
                            <select name="variacao_pizza" id="variacao_pizza" class="form-control">
                                <option value="">Selecione o tamanho</option>
                                @foreach($variacoes_pizza as $variacao)
                                    @foreach($tamanhos_pizza as $tamanho)
                                        @if($variacao->tamanho_pizza_id == $tamanho->id)
                                            <option value="{{ $variacao->id }}">{{ $tamanho->nome }} - R$ {{ number_format($variacao->preco, 2, ',', '.') }}</option>
                                        @endif
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="borda_id">Borda da Pizza</label>
                            <select name="borda_id" id="borda_id" class="form-control">
                                <option value="">Selecione a borda</option>
                                @foreach($bordas_pizza as $borda)
                                    <option value="{{ $borda->id }}">{{ $borda->nome }} - R$ {{ number_format($borda->preco_adicional, 2, ',', '.') }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="quantidade">Quantidade</label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-danger btn-number"  data-type="minus" data-field="quantidade">
                                    <span class="fas fa-minus"></span>
                                </button>
                            </span>
                            <input type="text" name="quantidade" id="quantidade" class="form-control input-number" value="1" min="1" max="100">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="quantidade">
                                    <span class="fa fa-plus"></span>
                                </button>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="preco_unitario">Valor Unitário</label>
                        <input type="text" name="preco_unitario" id="preco_unitario" class="form-control" readonly>
                    </div>

                    <button type="submit" class="btn btn-primary">Adicionar</button>
                </form>
            </div>
        </div>

        <div class="card card-success">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Itens</h5>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach($comanda->itens as $item)
                        <li class="list-group-item">
                            @if($item->borda_id !== null)
                                @php
                                    $borda = $bordas_pizza->firstWhere('id', $item->borda_id);
                                @endphp

                                @if($borda)
                                    {{ $item->produto->nome }} + {{ $borda->nome }} - 
                                    R$ {{ number_format($item->preco_unitario + $borda->preco_adicional, 2, ',', '.') }}
                                @else
                                    {{ $item->produto->nome }} - 
                                    R$ {{ number_format($item->preco_unitario, 2, ',', '.') }}
                                @endif
                            @else
                                {{ $item->produto->nome }} - 
                                R$ {{ number_format($item->preco_unitario, 2, ',', '.') }}
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@stop

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const produtoSelect = document.getElementById('produto_id');
        const tamanhoGroup = document.getElementById('tamanho-group');
        const variacaoPizzaSelect = document.getElementById('variacao_pizza');
        const precoUnitarioInput = document.getElementById('preco_unitario');

        produtoSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const categoriaId = selectedOption.getAttribute('data-categoria');
            const preco = selectedOption.getAttribute('data-preco');

            if (categoriaId == '3') {
                tamanhoGroup.style.display = 'block';
                variacaoPizzaSelect.setAttribute('required', 'required');
                precoUnitarioInput.value = ''; 
            } else {
                tamanhoGroup.style.display = 'none';
                variacaoPizzaSelect.removeAttribute('required');
                variacaoPizzaSelect.value = '';
                precoUnitarioInput.value = preco; 
            }
        });

        variacaoPizzaSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const text = selectedOption.textContent;

            const match = text.match(/R\$ ([\d.,]+)/);
            if (match) {
                let precoStr = match[1].replace('.', '').replace(',', '.');
                precoUnitarioInput.value = parseFloat(precoStr).toFixed(2);
            }
        });

        $('.btn-number').click(function(e) {
            e.preventDefault();
            const fieldName = $(this).attr('data-field');
            const type = $(this).attr('data-type');
            const input = $("input[name='" + fieldName + "']");
            let currentVal = parseInt(input.val());

            if (!isNaN(currentVal)) {
                if (type === 'minus' && currentVal > input.attr('min')) {
                    input.val(currentVal - 1).change();
                } else if (type === 'plus' && currentVal < input.attr('max')) {
                    input.val(currentVal + 1).change();
                }
            } else {
                input.val(1);
            }
        });

        $('.input-number').keydown(function(e) {
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                (e.keyCode === 65 && e.ctrlKey === true) || 
                (e.keyCode === 67 && e.ctrlKey === true) ||
                (e.keyCode === 86 && e.ctrlKey === true) ||
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                return;
            }
            if ((e.shiftKey || e.keyCode < 48 || e.keyCode > 57)) {
                e.preventDefault();
            }
        });
    });
</script>
@endsection