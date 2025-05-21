@extends('adminlte::page')

@section('title', 'Detalhes do Caixa')

@section('content_header')
    <h4><i class="fa fa-box"></i> Detalhes do Caixa</h4>
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
<div class="">
    <div class="card card-outline card-info mb-4">
        <div class="card-header">
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
                    <p><strong>Data de Abertura:</strong> {{ $caixa->data_abertura->timezone('America/Sao_Paulo')->format('d/m/Y H:i') }}</p>
                    <p><strong>Usuário Responsável:</strong> {{ $caixa->user->name ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Saldo Inicial:</strong> R$ {{ number_format($caixa->saldo_inicial, 2, ',', '.') }}</p>
                    @if($caixa->data_fechamento)
                        <p><strong>Data de Fechamento:</strong> {{ $caixa->data_fechamento->timezone('America/Sao_Paulo')->format('d/m/Y H:i') }}</p>
                        <p><strong>Saldo Final:</strong> R$ {{ number_format($caixa->saldo_final, 2, ',', '.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="mb-4 d-flex flex-row-reverse">
        <a href="{{ route('caixa.comanda.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nova Comanda
        </a>
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
    @else
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h5 class="mb-0">Pedidos</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>N° Pedido</th>
                                <th>Status</th>
                                <th>Tipo</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($comandas as $comanda)
                                <tr>
                                    <td>{{ $comanda->id }}</td>
                                    <td>{{ $comanda->status }}</td>
                                    <td>{{ $comanda->tipo }}</td>
                                    <td>
                                        <a href="{{ route('caixa.comanda.show', $comanda->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> Visiualizar
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Nenhum pedido registrado</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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
    <div class="card-footer">
        <a href="{{ route('caixa.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>
    @endif
</div>
@endsection