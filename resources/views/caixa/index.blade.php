@extends('adminlte::page')

@section('title', 'Gestão de Caixa')

@section('content_header')
    <h4><i class="fa fa-cash-register me-2"></i> Gestão de Caixa</h4>
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
    @if($caixaAberto = $caixas->firstWhere('data_fechamento', null))
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h5>Aberto em <span class="badge bg-success">{{ $caixaAberto->data_abertura->timezone('America/Sao_Paulo')->format('d/m/Y H:i') }}</span></h5>
        </div>
        <div class="card-body">
            <div class="d-flex flex-wrap gap-3 mb-4">
                <div class="card card-outline card-success flex-fill text-center shadow-sm mx-2">
                    <div class="card-body">
                        <p class="h3 mb-0">
                            <strong>Total:</strong><br> 
                            R$ {{ number_format($caixaAberto->saldo_inicial + $caixaAberto->total_vendas, 2, ',', '.') }}
                        </p>
                    </div>
                </div>
                <div class="card card-outline card-secondary flex-fill text-center shadow-sm mx-2">
                    <div class="card-body">
                        <div class="btn-group mb-3">
                            <div class="col-md-auto">
                                <a href="/caixa/{{ $caixaAberto->id }}" class="btn btn-primary btn-lg w-100 mb-2 d-flex justify-content-center align-items-center gap-2">
                                    <i class="fas fa-inbox"></i> Gerenciar Caixa
                                </a>
                            </div>
                            <div class="col-md-auto">
                                <a href="/caixa/comanda/create" class="btn btn-success btn-lg w-100 mb-2 d-flex justify-content-center align-items-center gap-2">
                                    <i class="fas fa-plus"></i> Novo Pedido
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-outline card-secondary p-3">
                <form action="{{ route('caixa.fechar', $caixaAberto->id) }}" method="POST">
                    @csrf
                    <div class="row g-3 mb-3">
                        <div class="col-md-4" style="display: none">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="saldo_final" name="saldo_final" value="{{ number_format($caixaAberto->saldo_inicial + $caixaAberto->total_vendas, 2, ',', '.') }}">
                                <label for="saldo_final">Saldo Final</label>
                            </div>
                        </div>
                        <div class="col-md-4" style="display: none">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="total_vendas" name="total_vendas" value="{{ number_format($caixaAberto->total_vendas, 2, ',', '.') }}">
                                <label for="total_vendas">Total de Vendas</label>
                            </div>
                        </div>
                    </div>
                    <div class="observacoes-container" style="display: none;">
                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="observacoes" id="observacoes" style="height: 100px" placeholder="Escreva suas observações (opcional)"></textarea>
                            <label for="observacoes">Observações</label>
                        </div>
                        <button type="submit" class="btn btn-danger btn-lg confirmar-fechamento">
                            <i class="fas fa-lock"></i> Confirmar Fechamento
                        </button>
                    </div>
                    <div class="btn-group mb-3">
                        <div class="col-md-auto">
                            <button type="button" class="btn btn-danger btn-lg iniciar-fechamento">
                                <i class="fas fa-lock"></i> Fechar Caixa
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>        
    </div>
    @else
        <div class="card card-outline card-success">
            <div class="card-header">
                <h5 class="mb-0">Caixa Fechado</h5>
            </div>
            <div class="card-body">
                <p>Nenhum caixa aberto no momento.</p>
            </div>
            <div class="card-footer">
                <a href="{{ route('caixa.create') }}" class="btn btn-success">
                    <i class="fas fa-lock-open"></i> Abrir Caixa
                </a>
            </div>
        </div>
    @endif

    <!-- Histórico de Caixas -->
    <div class="card card-outline card-secondary">
        <div class="card-header">
            <h5 class="mb-0">Histórico de Caixas</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover text-nowrap">
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
                        <tr>
                            <form method="GET" action="{{ route('caixa.index') }}">
                                <th>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-gradient-info">
                                                <i class="fas fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" 
                                            name="data_abertura" 
                                            class="form-control form-control-sm datetimepicker-input" 
                                            id="data_abertura_filter"
                                            placeholder="Filtrar Data"
                                            value="{{ request('data_abertura') }}"
                                            data-toggle="datetimepicker"
                                            data-target="#data_abertura_filter">
                                    </div>
                                </th>
                                <th>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-gradient-info">
                                                <i class="fas fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" 
                                            name="data_fechamento" 
                                            class="form-control form-control-sm datetimepicker-input" 
                                            id="data_fechamento_filter"
                                            placeholder="Filtrar Data"
                                            value="{{ request('data_fechamento') }}"
                                            data-toggle="datetimepicker"
                                            data-target="#data_fechamento_filter">
                                    </div>
                                </th>
                                <th><input type="text" name="name" class="form-control form-control-sm" placeholder="Filtrar Nome" value="{{ request('name') }}"></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="fas fa-filter"></i> Filtrar
                                    </button>
                                    <a href="{{ route('caixa.index') }}" class="btn btn-secondary btn-sm ml-2">
                                        <i class="fas fa-backspace"></i> Limpar Filtros
                                    </a>
                                </th>
                            </form>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($caixas as $caixa)
                            <tr>
                                <td>{{ $caixa->data_abertura->timezone('America/Sao_Paulo')->format('d/m/Y H:i') }}</td>
                                <td>{{ $caixa->data_fechamento ? $caixa->data_fechamento->timezone('America/Sao_Paulo')->format('d/m/Y H:i') : '-' }}</td>
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

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const iniciarFechamento = document.querySelector('.iniciar-fechamento');
        if (iniciarFechamento) {
            iniciarFechamento.addEventListener('click', function() {
                this.style.display = 'none';
                document.querySelector('.observacoes-container').style.display = 'block';
            });
        }

        const confirmarFechamento = document.querySelector('.confirmar-fechamento');
        if (confirmarFechamento) {
            confirmarFechamento.addEventListener('click', function(e) {
                const observacoes = document.getElementById('observacoes').value;
            });
        }

        $(function() {
            moment.locale('pt-br');
            $('#data_abertura_filter').datetimepicker({
                format: 'DD/MM/YYYY',
                locale: 'pt-br'
            });
        });

        $(function() {
            moment.locale('pt-br');
            $('#data_fechamento_filter').datetimepicker({
                format: 'DD/MM/YYYY',
                locale: 'pt-br'
            });
        });
    });
</script>
@stop