@extends('adminlte::page')

@section('plugins.TempusDominusBs4', true)
@section('plugins.Moment', true)

@section('title', 'Variações de Pizza')

@section('content_header')
    <h4><i class="fa fa-pizza-slice"></i> Variações de Pizza</h4>
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
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Lista de Variações de Pizza</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>PRODUTO</th>
                                <th>TAMANHO</th>
                                <th>TIPO</th>
                                <th>PREÇO</th>
                                <th>ATUALIZADO EM</th>
                                <th>
                                    <a href="{{ route('pizzas.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Nova Variação
                                    </a>
                                    <a href="/bordas-pizza" class="btn btn-warning"><i class="fas fa-list"></i> Bordas Pizza</a>
                                    <a href="/tamanho-pizza" class="btn btn-danger"><i class="fas fa-list"></i> Tamanhos Pizza</a>
                                </th>
                            </tr>
                            <!-- Linha de filtros -->
                            <tr>
                                <form method="GET" action="{{ route('pizzas.index') }}">
                                    <th><input type="text" name="produto" class="form-control form-control-sm" placeholder="Filtrar Produto" value="{{ request('produto') }}"></th>
                                    <th>
                                        <select type="text" name="tamanho" class="form-control form-control-sm" placeholder="Filtrar Tamanho">
                                            <option value="">-- Filtrar Tamanho --</option>
                                            @foreach ($tamanhos as $tamanho)
                                                <option value="{{ $tamanho->id }}" {{ request('tamanho') == $tamanho->id ? 'selected' : '' }}>
                                                    {{ $tamanho->nome }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </th>
                                    <th>
                                        <select type="text" name="tipo" class="form-control form-control-sm" placeholder="Filtrar Tipo">
                                            <option value="">-- Filtrar Tipo --</option>
                                            <option value="salgada" {{ request('tipo') == 'salgada' ? 'selected' : '' }}>Salgada</option>
                                            <option value="doce" {{ request('tipo') == 'doce' ? 'selected' : '' }}>Doce</option>
                                        </select>
                                    </th>
                                    <th><input type="text" name="preco" class="form-control form-control-sm" placeholder="Filtrar Preço" value="{{ request('preco') }}"></th>
                                    <th>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-gradient-info">
                                                    <i class="fas fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" 
                                                   name="atualizado_em" 
                                                   class="form-control form-control-sm datetimepicker-input" 
                                                   id="atualizado_em_filter"
                                                   placeholder="Filtrar Data"
                                                   value="{{ request('atualizado_em') }}"
                                                   data-toggle="datetimepicker"
                                                   data-target="#atualizado_em_filter">
                                        </div>
                                    </th>
                                    <th>
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="fas fa-filter"></i> Filtrar
                                        </button>
                                        <a href="{{ route('pizzas.index') }}" class="btn btn-secondary btn-sm ml-2">
                                            <i class="fas fa-backspace"></i> Limpar Filtros
                                        </a>
                                    </th>
                                </form>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($variacoes as $variacao)
                                <tr>
                                    <td>{{ $variacao->produto->nome }}</td>
                                    <td>{{ $variacao->tamanhoPizza->nome }}</td>
                                    <td>{{ ucfirst($variacao->tipo) }}</td>
                                    <td>R$ {{ number_format($variacao->preco, 2, ',', '.') }}</td>
                                    <td>{{ $variacao->updated_at->timezone('America/Sao_Paulo')->format('d/m/Y H:i') }}</td>
                                    <td class="d-flex flex-row project-actions text-right">
                                        <div class="mx-1">
                                            <a href="{{ route('pizzas.edit', $variacao->id) }}" class="btn btn-success">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                        <div class="mx-1">
                                            <form action="{{ route('pizzas.destroy', $variacao->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta variação?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">Nenhum registro encontrado</td>
                                </tr>
                            @endforelse  
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    <div class="float-right">
                        {{ $variacoes->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .card-footer {
            background-color: transparent;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            moment.locale('pt-br');
            $('#atualizado_em_filter').datetimepicker({
                format: 'DD/MM/YYYY',
                locale: 'pt-br'
            });
        });
    </script>
@stop