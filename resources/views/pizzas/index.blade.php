@extends('adminlte::page')

@section('title', 'Variações de Pizza')

@section('content_header')
    <h1>Variações de Pizza</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
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
                                    <!--<th><input type="text" name="atualizado_em" class="form-control form-control-sm" placeholder="Filtrar Data" value="{{ request('atualizado_em') }}"></th> -->
                                    <th>
                                        <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                                            <input type="text" class="form-control form-control-sm datetimepicker-input" 
                                                   data-target="#datetimepicker1" 
                                                   data-toggle="datetimepicker"/>
                                            <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </th>
                                    <th>
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="fas fa-filter"></i> Filtrar
                                        </button>
                                        <a href="{{ route('pizzas.index') }}" class="btn btn-secondary btn-sm ml-2">
                                            <i class="fas fa-brush"></i> Limpar Filtros
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
                                    <td>{{ $variacao->updated_at->format('d/m/Y H:i') }}</td>
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
        
    </script>
@stop