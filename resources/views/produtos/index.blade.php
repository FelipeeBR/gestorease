@extends('adminlte::page')

@section('title', 'Produtos')

@section('content_header')
    <h4><i class="fa fa-barcode"></i> Produtos</h4>
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
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lista de Produtos Vendidos</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NOME</th>
                                <th>CATEGORIA</th>
                                <th>DESCRIÇÃO</th>
                                <th>QUANTIDADE</th>
                                <th>PREÇO DE VENDA</th>
                                <th>ATUALIZADO EM</th>
                                <th>
                                    <a href="/produtos/create" class="btn btn-primary"><i class="fas fa-plus"></i> Novo Produto</a>
                                    <a href="/categorias" class="btn btn-secondary"><i class="fas fa-list"></i> Categorias</a>
                                </th>
                            </tr>

                            <tr>
                                <form method="GET" action="{{ route('produtos.index') }}">
                                    <th></th>
                                    <th><input type="text" name="nome" class="form-control form-control-sm" placeholder="Filtrar Nome" value="{{ request('nome') }}"></th>
                                    <th>
                                        <select type="text" name="categoria" class="form-control form-control-sm" placeholder="Filtrar Categoria">
                                            <option value="">-- Filtrar Categoria --</option>
                                            @foreach ($categorias as $categoria)
                                                <option value="{{ $categoria->id }}" {{ request('categoria') == $categoria->id ? 'selected' : '' }}>
                                                    {{ $categoria->nome }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </th>
                                    <th></th>
                                    <th></th>
                                    <th><input type="text" name="preco_venda" class="form-control form-control-sm" placeholder="Filtrar Preço" value="{{ request('preco_venda') }}"></th>
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
                                        <a href="{{ route('produtos.index') }}" class="btn btn-secondary btn-sm ml-2">
                                            <i class="fas fa-backspace"></i> Limpar Filtros
                                        </a>
                                    </th>
                                </form>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($produtos as $produto)
                                <tr>
                                    <td>{{ $produto->id }}</td>
                                    <td>{{ $produto->nome }}</td>
                                    <td>
                                        <li>
                                            @if ($produto->categoria)
                                                {{ $produto->categoria->nome }}
                                            @else
                                                <em>Sem Categoria</em>
                                            @endif
                                        </li>
                                    </td>
                                    <td class="text-truncate" style="max-width: 150px;">{{ $produto->descricao }}</td>
                                    <td>{{ $produto->quantidade_estoque }}</td>
                                    <td>
                                        @if ($produto->categoria_id == 3)
                                            <em>Preços variados</em>
                                        @else
                                            R$ {{ $produto->preco_venda }}
                                        @endif
                                    </td>
                                    <td>{{ $produto->updated_at->timezone('America/Sao_Paulo')->format('d/m/Y H:i') }}</td>
                                    <td class="d-flex flex-row project-actions text-right">
                                        <div class="mx-1">
                                            <a href="/produtos/{{ $produto->id }}/edit" class="btn btn-success"><i class="fas fa-edit"></i></a>
                                        </div>
                                        <div class="mx-1">
                                            <form action="{{ route('produtos.destroy', $produto->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este produto?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
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
                        {{ $produtos->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
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