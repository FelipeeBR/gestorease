
<form action="{{ route('caixa.store') }}" method="POST">
    @csrf
    <div class="card-body">
        <div class="form-group">
            <label for="saldo_inicial">Saldo Inicial</label>
            <input type="number" step="0.00" class="form-control" id="saldo_inicial" name="saldo_inicial" value="0" required>
        </div>
        <div class="form-group">
            <label for="observacoes">Observações</label>
            <textarea class="form-control" id="observacoes" name="observacoes" rows="3" placeholder="Escreva suas observações (opcional)"></textarea>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-success">
            <i class="fas fa-lock-open"></i> Abrir Caixa
        </button>
        <a href="{{ route('caixa.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Cancelar
        </a>
    </div>
</form>