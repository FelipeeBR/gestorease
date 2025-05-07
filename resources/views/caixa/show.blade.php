@extends('adminlte::page')

@section('title', 'Detalhes do Caixa')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-4 text-end">
            <a href="{{ route('caixa.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Informações Básicas</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Status:</strong>
                        @if($caixa->data_fechamento)
                            <span class="badge bg-danger">Fechado</span>
                        @else
                            <span class="badge bg-success">Aberto</span>
                        @endif
                    </p>
                    <p><strong>Data de Abertura:</strong> {{ $caixa->data_abertura->format('d/m/Y H:i:s') }}</p>
                    <p><strong>Usuário Responsável:</strong> {{ $caixa->user->name ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Saldo Inicial:</strong> R$ {{ number_format($caixa->saldo_inicial, 2, ',', '.') }}</p>
                    @if($caixa->data_fechamento)
                        <p><strong>Data de Fechamento:</strong> {{ $caixa->data_fechamento->format('d/m/Y H:i:s') }}</p>
                        <p><strong>Saldo Final:</strong> R$ {{ number_format($caixa->saldo_final, 2, ',', '.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($caixa->data_fechamento)
    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Resumo Financeiro</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="card bg-light mb-3">
                        <div class="card-body text-center">
                            <h6 class="card-title">Total de Vendas</h6>
                            <p class="h4 text-primary">R$ {{ number_format($caixa->total_vendas, 2, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-light mb-3">
                        <div class="card-body text-center">
                            <h6 class="card-title">Diferença</h6>
                            @php
                                $diferenca = $caixa->saldo_final - ($caixa->saldo_inicial + $caixa->total_vendas);
                                $classe = $diferenca >= 0 ? 'text-success' : 'text-danger';
                            @endphp
                            <p class="h4 {{ $classe }}">R$ {{ number_format($diferenca, 2, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-light mb-3">
                        <div class="card-body text-center">
                            <h6 class="card-title">Movimentação Total</h6>
                            <p class="h4 text-dark">R$ {{ number_format($caixa->saldo_inicial + $caixa->total_vendas, 2, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($caixa->observacoes)
    <div class="card">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Observações</h5>
        </div>
        <div class="card-body">
            <p class="card-text">{{ $caixa->observacoes }}</p>
        </div>
    </div>
    @endif
    <!--&& auth()->user()->can('fechar-caixa')-->
    @if(!$caixa->data_fechamento)
    <div class="mt-4 text-end">
        <a href="{{ route('caixa.fechar', $caixa->id) }}" class="btn btn-danger">
            <i class="fas fa-lock"></i> Fechar Caixa
        </a>
    </div>
    @endif
</div>
@endsection