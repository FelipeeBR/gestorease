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
    @if($caixa->data_fechamento == null)
        <div class="mb-4 d-flex flex-row-reverse">
            <a href="{{ route('caixa.comanda.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nova Comanda
            </a>
        </div>
    @endif

    @if($caixa->data_fechamento)
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Resumo Financeiro</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-success"><i class="far fa-money-bill-alt"></i></span>
                            <div class="card-body text-center">
                                <h6 class="card-title">Total de Vendas</h6>
                                <p class="h4 text-primary">R$ {{ number_format($caixa->total_vendas, 2, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning"><i class="fas fa-not-equal"></i></span>
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
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-info"><i class="fas fa-wallet"></i></span>
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
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>N° Comanda</th>
                                <th>Status</th>
                                <th>Tipo</th>
                                <th>Ações</th>
                            </tr>
                            <tr>
                                <form method="GET" action="{{ route('caixa.show', ['caixa' => $caixa->id]) }}">
                                    <input type="hidden" name="caixa_id" value="{{ $caixa->id }}">
                                    <th>
                                        <input type="text" name="id" id="id" class="form-control form-control-sm" placeholder="N° Pedido">
                                    </th>
                                    <th>
                                        <select type="text" name="status" id="status" class="form-control form-control-sm" placeholder="Filtrar Status">
                                            <option value="">-- Filtrar Status --</option>
                                            <option value="aberta" {{ request('status') == 'aberta' ? 'selected' : '' }}>Aberta</option>
                                            <option value="fechada" {{ request('status') == 'fechada' ? 'selected' : '' }}>Fechada</option>
                                            <option value="cancelada" {{ request('status') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                                        </select>
                                    </th>
                                    <th>
                                        <select type="text" name="tipo" id="tipo" class="form-control form-control-sm" placeholder="Filtrar Tipo">
                                            <option value="">-- Filtrar Tipo --</option>
                                            <option value="mesa" {{ request('tipo') == 'mesa' ? 'selected' : '' }}>Mesa</option>
                                            <option value="delivery" {{ request('tipo') == 'delivery' ? 'selected' : '' }}>Delivery</option>
                                            <option value="balcao" {{ request('tipo') == 'balcao' ? 'selected' : '' }}>Balcão</option>
                                        </select>
                                    </th>
                                    <th>
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="fas fa-filter"></i> Filtrar
                                        </button>
                                    </th>
                                </form> 
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($comandas as $comanda)
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
                                <tr>
                                    <td>{{ $comanda->id }}</td>
                                    <td>
                                        <span class="badge {{ $bgClass }} text-uppercase">{{ $comanda->status }}</span>
                                    </td>
                                    <td>{{ $comanda->tipo }}</td>
                                    <td>
                                        <a href="{{ route('caixa.show', $comanda->id) }}" class="btn btn-sm btn-info">
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

@section('js')
    <script>
        
    </script>
@stop