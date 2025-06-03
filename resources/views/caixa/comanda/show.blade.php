@extends('adminlte::page')

@section('title', 'Comanda #'.$comanda->id)

@php
    $bgClass = 'bg-success'; 
    if ($comanda->status === 'aberta') {
        $bgClass = 'bg-success';
    } elseif ($comanda->status === 'fechada') {
        $bgClass = 'bg-danger';
    } elseif ($comanda->status === 'cancelada') {
        $bgClass = 'bg-secondary';
    }
@endphp

@section('content_header')
    <h4><i class="fas fa-clipboard"></i> Comanda #{{ $comanda->id }} <span class="badge text-uppercase {{ $bgClass }}">{{ $comanda->status }}</span></h4>
    @if(session('success'))
        @section('js')
            <script type="text/javascript">
                $(document).ready(function() {
                    toastr.success('{{ session('success') }}');
                });
            </script>
        @endsection
    @endif

    @if(session('error'))
        @section('js')
            <script type="text/javascript">
                $(document).ready(function() {
                    toastr.error('{{ session('error') }}');
                });
            </script>
        @endsection
    @endif
@stop

@section('content')
    <div>
        @if($comanda->status == 'aberta')
            <div>
                <x-adminlte-modal id="modalMin" title="Fechar Comanda">
                    <div>
                        <label for="">Escolha a Forma de Pagamento</label>
                        <select name="forma_pagamento" id="forma_pagamento" class="form-control">
                            <option value="dinheiro" {{ old('forma_pagamento', $comanda->forma_pagamento ?? '') == 'dinheiro' ? 'selected' : '' }}>Dinheiro</option>
                            <option value="debito" {{ old('forma_pagamento', $comanda->forma_pagamento ?? '') == 'debito' ? 'selected' : '' }}>Debito</option>
                            <option value="credito" {{ old('forma_pagamento', $comanda->forma_pagamento ?? '') == 'credito' ? 'selected' : '' }}>Credito</option>
                            <option value="pix" {{ old('forma_pagamento', $comanda->forma_pagamento ?? '') == 'pix' ? 'selected' : '' }}>Pix</option>
                        </select>
                    </div>
                    <x-slot name="footerSlot">
                        <form action="{{ route('caixa.comanda.fechar', $comanda->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="forma_pagamento" id="forma_pagamento_hidden">
                            <button type="submit" class="btn btn-success comanda-fechar"><i class="fas fa-lock"></i> Fechar Comanda</button>
                        </form>
                        <x-adminlte-button theme="danger" label="Cancelar" data-dismiss="modal"/>
                    </x-slot>
                </x-adminlte-modal>
            </div>

            <div class="row mb-4 d-flex flex-row-reverse">
                <div class="col-md-auto">
                    <button class="btn btn-primary no-print" onclick="printComanda()"><i class="fas fa-print"></i> Imprimir</button>
                </div>
                <div class="col-md-auto">
                    <button class="btn btn-success" data-toggle="modal" data-target="#modalMin"><i class="fas fa-lock"></i> Fechar Comanda</button>
                </div>
                <div class="col-md-auto">
                    <form action="{{ route('caixa.comanda.cancelar', $comanda->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Tem certeza que deseja cancelar esta comanda?');">
                        @csrf
                        <button type="submit" class="btn btn-danger"><i class="fas fa-times"></i> Cancelar Comanda</button>
                    </form>
                </div>
            </div>
        @endif

        @if($comanda->status == 'fechada')
            <div class="row mb-4 d-flex flex-row-reverse">
                <div class="col-md-auto">
                    <button class="btn btn-primary no-print" onclick="printComanda()"><i class="fas fa-print"></i> Imprimir</button>
                </div>
            </div>
        @endif
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h5 class="mb-0">Informações</h5>  
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card card-outline card-secondary flex-fill text-center shadow-sm mx-2">
                            <div class="card-body">
                                <div class="mb-4">
                                    <p class="h3 mb-0">
                                        <strong>Total:</strong> R$ {{ number_format($comanda->total, 2, ',', '.') }}
                                    </p>
                                    @if($comanda->status == 'fechada')
                                        <p>
                                            <strong>Forma de Pagamento:</strong><span class="badge bg-primary h5">{{ $comanda->forma_pagamento ?? 'N/A' }}</span> 
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card card-outline card-secondary mb-3 shadow-sm">
                            <div class="card-header">
                                <i class="fas fa-sticky-note"></i> Observações
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <p class="mb-2">{{ $comanda->observacoes ?? 'Nenhuma observação registrada.' }}</p>
                                    <a href="{{ route('caixa.comanda.edit', $comanda->id) }}" class="btn btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div>
                    <small class="text-muted">
                        <i class="fas fa-clock"></i>
                        <strong>Abertura:</strong> {{ $comanda->created_at->timezone('America/Sao_Paulo')->format('d/m/Y H:i') }}
                    </small>
                </div>
            </div>
        </div>
        @if($comanda->status == 'aberta')
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h5 class="mb-0">Adicionar</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('caixa.comanda.item.store', $comanda->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="produto_id">Produto</label>
                                <x-adminlte-select2 name="produto_id" id="produto_id" class="form-control" data-placeholder="Selecione..." required>
                                    <option value=""></option>
                                    @foreach($produtos as $produto)
                                        <option value="{{ $produto->id }}"
                                                data-categoria="{{ $produto->categoria_id }}"
                                                data-preco="{{ $produto->preco_venda }}">
                                            {{ $produto->nome }}
                                        </option>
                                    @endforeach
                                </x-adminlte-select2>
                            </div>
        
                            <div class="col-sm-6" id="tamanho-group" style="display: none;">
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
                                        <option value="">Sem borda</option>
                                        @foreach($bordas_pizza as $borda)
                                            <option value="{{ $borda->id }}">{{ $borda->nome }} - R$ {{ number_format($borda->preco_adicional, 2, ',', '.') }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2 form-group">
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
        
                            <div class="col-sm-2">
                                <label for="preco_unitario">Valor Unitário</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">R$</span>
                                    </div>
                                    <input type="text" name="preco_unitario" id="preco_unitario" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Adicionar</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        <div class="card card-outline card-secondary">
            <div class="card-header">
                <h5 class="mb-0">Itens Pedidos</h5>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Quantidade</th>
                            <th>Valor Unitário</th>
                            <th>Subtotal</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($comanda->itens as $item)
                        <tr>
                            <td>
                                @if($item->borda_id !== null)
                                    @php
                                        $borda = $bordas_pizza->firstWhere('id', $item->borda_id);
                                    @endphp

                                    @if($borda)
                                        {{ $item->produto->nome }} <br><small class="text-muted">{{ $item->variacaoPizza->tamanhoPizza->nome ?? '' }} + {{ $borda->nome }} (R$ {{ number_format($bordas_pizza->firstWhere('id', $item->borda_id)->preco_adicional, 2, ',', '.') }})</small>
                                    @else
                                        {{ $item->produto->nome }} <br><small class="text-muted">{{ $item->variacaoPizza->tamanhoPizza->nome ?? '' }}</small>
                                    @endif
                                @else
                                    {{ $item->produto->nome }} <br><small class="text-muted">{{ $item->variacaoPizza->tamanhoPizza->nome ?? '' }}</small>
                                @endif
                            </td>
                            <td>{{ $item->quantidade }}</td>
                            <td>
                                @if($item->borda_id !== null)
                                    @php
                                        $borda = $bordas_pizza->firstWhere('id', $item->borda_id);
                                    @endphp

                                    @if($borda)
                                        R$ {{ number_format($item->preco_unitario, 2, ',', '.') }}
                                    @else
                                        R$ {{ number_format($item->preco_unitario, 2, ',', '.') }}
                                    @endif
                                @else
                                    R$ {{ number_format($item->preco_unitario, 2, ',', '.') }}
                                @endif
                            </td>
                            <td>R$ {{ $item->subtotal }}</td>
                            <td>
                                @if($comanda->status == 'aberta')
                                    <form action="{{ route('caixa.comanda.item.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3">Total</th>
                            <th>R$ {{ number_format($comanda->total, 2, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        {{-- Documento de Impressão Comanda --}}
        <div id="print-area" style="display:none;">
            <div style="width:58mm; font-family: monospace; font-size: 12px; word-wrap: break-word;">
                <div style="text-align: center;">
                    <strong>{{ $empresa->nome }}</strong><br>
                    Endereço: {{ $empresa->endereco }}, {{ $empresa->numero }}<br>
                    Tel: {{ isset($empresa->telefone) ? preg_replace("/(\d{2})(\d{4,5})(\d{4})/", "(\$1) \$2-\$3", $empresa->telefone) : 'N/A' }}
                    {{ isset($empresa->cnpj) ? preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $empresa->cnpj) : 'N/A' }}
                </div>
                <hr style="border-top: 1px dashed #000; margin: 5px 0;">
                <div>
                    <strong>COMANDA: #{{ $comanda->id }}</strong><br>
                    Data: {{ $comanda->created_at->timezone('America/Sao_Paulo')->format('d/m/Y H:i') }}<br>
                    Cliente: {{ $comanda->cliente ?? 'Consumidor' }}<br>
                    Atendente: {{ auth()->user()->name ?? 'Sistema' }}
                </div>
                <hr style="border-top: 1px dashed #000; margin: 5px 0;">
                
                <table style="width:100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="text-align: left; width: 60%;">Item</th>
                            <th style="text-align: center;">Qtd</th>
                            <th style="text-align: right;">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($comanda->itens as $item)
                        <tr>
                            <td style="text-align: left;">
                                @if($item->borda_id !== null)
                                    @php
                                        $borda = $bordas_pizza->firstWhere('id', $item->borda_id);
                                    @endphp

                                    @if($borda)
                                        {{ $item->produto->nome }} <br><small class="text-muted">{{ $item->variacaoPizza->tamanhoPizza->nome ?? '' }} + {{ $borda->nome }} (R$ {{ number_format($bordas_pizza->firstWhere('id', $item->borda_id)->preco_adicional, 2, ',', '.') }})</small>

                                    @else
                                        {{ $item->produto->nome }} <br><small class="text-muted">{{ $item->variacaoPizza->tamanhoPizza->nome ?? '' }}</small>
                                    @endif
                                @else
                                    {{ $item->produto->nome }} <br><small class="text-muted">{{ $item->variacaoPizza->tamanhoPizza->nome ?? '' }}</small>
                                @endif
                            </td>
                            <td style="text-align: center;">{{ $item->quantidade }}</td>
                            <td style="text-align: right;">R$ {{ number_format($item->preco_unitario, 2, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <hr style="border-top: 1px dashed #000; margin: 5px 0;">
                
                <div style="text-align: right;">
                    <strong>TOTAL: R$ {{ number_format($comanda->total, 2, ',', '.') }}</strong>
                </div>
                
                @if($comanda->forma_pagamento)
                    <div>
                        <strong>Pagamento:</strong> {{ ucfirst($comanda->forma_pagamento) }}
                    </div>
                @endif
                
                <hr style="border-top: 1px dashed #000; margin: 5px 0;">
                
                <div style="text-align: center; font-size: 10px;">
                    Obrigado pela preferência!<br>
                    Volte sempre!
                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const produtoSelect = document.getElementById('produto_id');
        const tamanhoGroup = document.getElementById('tamanho-group');
        const variacaoPizzaSelect = document.getElementById('variacao_pizza');
        const precoUnitarioInput = document.getElementById('preco_unitario');
        const bordaSelect = document.getElementById('borda_id');

        function extractPrice(optionText) {
            const match = optionText.match(/R\$ ([\d.,]+)/);
            if(match) {
                let precoStr = match[1].replace('.', '').replace(',', '.');
                return parseFloat(precoStr);
            }
            return 0;
        }

        function updateTotalPrice() {
            let basePrice = 0;
            if(produtoSelect.selectedIndex > 0) {
                const selectedProduto = produtoSelect.options[produtoSelect.selectedIndex];
                const categoriaId = selectedProduto.getAttribute('data-categoria');
                
                if (categoriaId == '3' && variacaoPizzaSelect.selectedIndex > 0) {
                    basePrice = extractPrice(variacaoPizzaSelect.options[variacaoPizzaSelect.selectedIndex].text);
                } else {
                    basePrice = parseFloat(selectedProduto.getAttribute('data-preco')) || 0;
                }
            }
            
            let bordaPrice = 0;
            if (bordaSelect.selectedIndex > 0) {
                bordaPrice = extractPrice(bordaSelect.options[bordaSelect.selectedIndex].text);
            }
            
            const totalPrice = basePrice + bordaPrice;
            precoUnitarioInput.value = totalPrice.toFixed(2);
        }

        $(document).ready(function() {
            $('#produto_id').on('select2:open', function() {
                $(this).data('select2').$dropdown.find(':input.select2-search__field').attr('placeholder', 'Digite para buscar um produto...');
            });
        });

        $('#produto_id').on('change', function () {
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
            
            updateTotalPrice();
        });

        variacaoPizzaSelect.addEventListener('change', function() {
            updateTotalPrice();
        });

        bordaSelect.addEventListener('change', function() {
            updateTotalPrice();
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

        $('.comanda-fechar').click(function(e) {
            e.preventDefault();
            var formaPagamento = document.getElementById('forma_pagamento');
            if(formaPagamento) {
                document.getElementById('forma_pagamento_hidden').value = formaPagamento.value;
                $(this).closest('form').submit();
            } else {
                console.error('Elemento forma_pagamento não encontrado!');
            }
        });
    });

    function printComanda() {
        // Cria um clone da área de impressão
        const printContent = document.getElementById('print-area').cloneNode(true);
        printContent.style.display = 'block';
        
        // Cria uma nova janela
        const printWindow = window.open('', '_blank', 'width=800,height=600');
        
        // Escreve o conteúdo na nova janela
        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Comanda #{{ $comanda->id }}</title>
                <style>
                    body { 
                        font-family: monospace; 
                        font-size: 12px; 
                        margin: 0; 
                        padding: 5px;
                        width: 58mm;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                    }
                    hr {
                        border-top: 1px dashed #000;
                        margin: 3px 0;
                    }
                </style>
            </head>
            <body>
                ${printContent.innerHTML}
            </body>
            </html>
        `);
        
        printWindow.document.close();
        
        // Espera o conteúdo carregar antes de imprimir
        setTimeout(function() {
            printWindow.print();
            printWindow.close();
        }, 200);
    }
</script>
@endpush