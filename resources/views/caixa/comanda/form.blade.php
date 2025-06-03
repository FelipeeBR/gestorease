@php
    $comanda = $comanda ?? null;
@endphp

<form action="{{ isset($comanda->id) ? route('caixa.comanda.update', $comanda->id) : route('caixa.comanda.store') }}" method="POST">
    @csrf
    @if(isset($comanda->id))
        @method('PUT')
    @endif
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="caixa_id">ID Caixa</label>
                    <input type="text" name="caixa_id" id="caixa_id" class="form-control" value="{{ $caixa->id }}" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="tipo">Tipo</label>
                    <select name="tipo" id="tipo" class="form-control" required onchange="mostrarCamposPorTipo()">
                        <option value="">Selecione</option>
                        <option value="mesa" {{ old('tipo', $comanda->tipo ?? '') == 'mesa' ? 'selected' : '' }}>Mesa</option>
                        <option value="delivery" {{ old('tipo', $comanda->tipo ?? '') == 'delivery' ? 'selected' : '' }}>Delivery</option>
                        <option value="balcao" {{ old('tipo', $comanda->tipo ?? '') == 'balcao' ? 'selected' : '' }}>Balcão</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group campo-mesa">
                    <label for="numero_mesa">Número da Mesa</label>
                    <select class="form-control" id="numero_mesa" name="numero_mesa">
                        <option value="">Selecione...</option>
                        @foreach($mesas as $mesa)
                            <option value="{{ $mesa->id }}" {{ old('numero_mesa', $comanda->numero_mesa ?? '') == $mesa->id ? 'selected' : '' }}>
                                {{ $mesa->numero }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Campos para Todos (exceto quando especificado) -->
        <div class="form-group campo-cliente">
            <label for="cliente">Cliente</label>
            <input type="text" name="cliente" id="cliente" class="form-control" value="{{ old('cliente', $comanda->cliente ?? '') }}">
        </div>

        <!-- Campos para Delivery -->
        <div class="form-group campo-delivery">
            <label for="endereco">Endereço (Rua, Bairro, Número)</label>
            <textarea name="endereco" id="endereco" class="form-control">{{ old('endereco', $comanda->endereco ?? '') }}</textarea>
        </div>

        <div class="form-group campo-delivery">
            <label for="telefone">Telefone</label>
            <input type="text" name="telefone" id="telefone" class="form-control" value="{{ old('telefone', $comanda->telefone ?? '') }}"
             data-inputmask='"mask": "(99) 99999-9999"' data-mask placeholder="(__) _____-____">
        </div>

        <div class="form-group campo-delivery">
            <label for="taxa_entrega">Taxa de Entrega</label>
            <input type="number" step="0.01" name="taxa_entrega" id="taxa_entrega" class="form-control" value="{{ old('taxa_entrega', $comanda->taxa_entrega ?? 0) }}">
        </div>

        <!-- Campos comuns a todos -->
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="aberta" {{ old('status', $comanda->status ?? '') == 'aberta' ? 'selected' : '' }}>Aberta</option>
                <option value="fechada" {{ old('status', $comanda->status ?? '') == 'fechada' ? 'selected' : '' }}>Fechada</option>
                <option value="cancelada" {{ old('status', $comanda->status ?? '') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
            </select>
        </div>

        <div class="form-group">
            <label for="total">Total</label>
            <input type="number" step="0.01" name="total" id="total" class="form-control" value="{{ old('total', $comanda->total ?? 0) }}">
        </div>

        <div class="form-group">
            <label for="observacoes">Observações</label>
            <textarea name="observacoes" id="observacoes" class="form-control">{{ old('observacoes', $comanda->observacoes ?? '') }}</textarea>
        </div>
    </div>

    <div class="card-footer">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> {{ isset($comanda->id) ? 'Atualizar Comanda' : 'Salvar' }}
        </button>
        <a href="{{ route('caixa.index') }}" class="btn btn-secondary ml-2">
            <i class="fas fa-arrow-left"></i> Cancelar
        </a>
    </div>
</form>

@section('js')
<script>
    // Função para mostrar/ocultar campos conforme o tipo selecionado
    function mostrarCamposPorTipo() {
        const tipo = $('#tipo').val();
        
        // Esconder todos os campos condicionais
        $('.campo-mesa, .campo-delivery, .campo-cliente').hide();
        
        // Mostrar campos conforme o tipo selecionado
        if (tipo === 'mesa') {
            $('.campo-mesa').show();
            $('#numero_mesa').prop('required', true);
        } 
        else if (tipo === 'delivery') {
            $('.campo-delivery').show();
            $('.campo-cliente').show();
            $('#numero_mesa').prop('required', false);
        } 
        else if (tipo === 'balcao') {
            $('.campo-cliente').show();
            $('#numero_mesa').prop('required', false);
        }
    }

    // Executar ao carregar a página para configurar campos iniciais
    $(document).ready(function() {
        mostrarCamposPorTipo();
        $('#telefone').inputmask('(99) 99999-9999');
    });
</script>
@stop