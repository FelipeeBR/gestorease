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
                                <th>PRODUTO</th>
                                <th>TAMANHO</th>
                                <th>TIPO</th>
                                <th>PREÇO</th>
                                <th>ATUALIZADO EM</th>
                                <th>
                                    <a href="{{ route('pizzas.create') }}" class="btn btn-primary">
                                        Nova Variação <i class="fas fa-plus"></i>
                                    </a>
                                </th>
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
        $(document).ready(function() {
            $('input[name="table_search"]').on('keyup', function() {
                const value = $(this).val().toLowerCase();
                $('table tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
@stop