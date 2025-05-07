@extends('adminlte::page')

@section('title', 'Abrir Caixa')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Abrir Caixa</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('caixa.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="saldo_inicial">Saldo Inicial</label>
                            <input type="number" step="0.00" class="form-control" id="saldo_inicial" name="saldo_inicial" required>
                        </div>
                        <div class="form-group">
                            <label for="observacoes">Observações</label>
                            <textarea class="form-control" id="observacoes" name="observacoes" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-lock-open"></i> Abrir Caixa
                        </button>
                        <a href="{{ route('caixa.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Cancelar
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection