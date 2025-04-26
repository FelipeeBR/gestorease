@extends('adminlte::page')

@section('title', 'Pizzas')

@section('content_header')
    <h1>Pizzas</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lista de Pizzas Vendidas</h3>

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
                                <th>NOME</th>
                                <th>TAMANHO</th>
                                <th>TIPO</th>
                                <th>PREÇO DE VENDA</th>
                                <th>ATUALIZADO EM</th>
                                <th><a href="/pizzas/create" class="btn btn-primary">Nova Pizza <i class="fas fa-plus"></i></a></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pizzas as $pizza)
                                <tr>
                                    <td>{{ $pizza->nome }}</td>
                                    <td>{{ $pizza->tamanho }}</td>
                                    <td>{{ $pizza->tipo }}</td>
                                    <td>R$ {{ $pizza->preco_venda }}</td>
                                    <td>{{ $pizza->updated_at }}</td>
                                    <td class="d-flex flex-row project-actions text-right">
                                        <div class="mx-1">
                                            <a href="/pizzas/{{ $pizza->id }}/edit" class="btn btn-success"><i class="fas fa-edit"></i></a>
                                        </div>
                                        <div class="mx-1">
                                            <form action="{{ route('pizzas.destroy', $pizza->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este produto?');">
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
 
@stop

@section('js')
    <script> console.log(""); </script>
@stop