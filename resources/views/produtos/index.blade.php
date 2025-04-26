@extends('adminlte::page')

@section('title', 'Produtos')

@section('content_header')
    <h1>Produtos</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lista de Produtos Vendidos</h3>

                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Pesquisar">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
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
                                <th><a href="/produtos/create" class="btn btn-primary">Novo Produto <i class="fas fa-plus"></i></a></th>
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
                                    <td>{{ $produto->updated_at }}</td>
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
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop