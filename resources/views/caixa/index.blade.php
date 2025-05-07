@extends('adminlte::page')

@section('title', 'Gestão de Caixa')

@section('content_header')
    <h1>Gestão de Caixa</h1>
@stop

@section('content')
<div class="container">
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

    <!-- Card de Status do Caixa -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Status do Caixa</h5>
        </div>
        <div class="card-body">
            @if($caixaAberto = $caixas->firstWhere('data_fechamento', null))
                <div class="alert alert-warning">
                    <h5>Caixa Aberto</h5>
                    <p><strong>Aberto em:</strong> {{ $caixaAberto->data_abertura->format('d/m/Y H:i') }}</p>
                    <p><strong>Por:</strong> {{ $caixaAberto->user->name }}</p>
                    <p><strong>Saldo Inicial:</strong> R$ {{ number_format($caixaAberto->saldo_inicial, 2, ',', '.') }}</p>
                    
                    <form action="{{ route('caixa.fechar', $caixaAberto->id) }}" method="POST" class="mt-3">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="saldo_final">Saldo Final</label>
                                    <input type="number" step="0.01" class="form-control" id="saldo_final" name="saldo_final" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="total_vendas">Total de Vendas</label>
                                    <input type="number" step="0.01" class="form-control" id="total_vendas" name="total_vendas" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="observacoes">Observações</label>
                                    <input type="text" class="form-control" id="observacoes" name="observacoes">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-lock"></i> Fechar Caixa
                        </button>
                    </form>
                </div>
            @else
                <div class="alert alert-success">
                    <h5>Caixa Fechado</h5>
                    <p>Nenhum caixa aberto no momento.</p>
                    <a href="{{ route('caixa.create') }}" class="btn btn-success">
                        <i class="fas fa-lock-open"></i> Abrir Caixa
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Histórico de Caixas -->
    <div class="card">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Histórico de Caixas</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Data Abertura</th>
                            <th>Data Fechamento</th>
                            <th>Usuário</th>
                            <th>Saldo Inicial</th>
                            <th>Saldo Final</th>
                            <th>Total Vendas</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($caixas as $caixa)
                            <tr>
                                <td>{{ $caixa->data_abertura->format('d/m/Y H:i') }}</td>
                                <td>{{ $caixa->data_fechamento ? $caixa->data_fechamento->format('d/m/Y H:i') : '-' }}</td>
                                <td>{{ $caixa->user->name }}</td>
                                <td>R$ {{ number_format($caixa->saldo_inicial, 2, ',', '.') }}</td>
                                <td>{{ $caixa->saldo_final ? 'R$ ' . number_format($caixa->saldo_final, 2, ',', '.') : '-' }}</td>
                                <td>{{ $caixa->total_vendas ? 'R$ ' . number_format($caixa->total_vendas, 2, ',', '.') : '-' }}</td>
                                <td>
                                    <a href="{{ route('caixa.show', $caixa->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Detalhes
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Nenhum caixa registrado</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
