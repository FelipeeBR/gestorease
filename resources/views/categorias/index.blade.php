@extends('adminlte::page')

@section('title', 'Categorias')

@section('content_header')
    <h1>Categorias</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lista de Categorias</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NOME</th>
                                <th>ATUALIZADO EM</th>
                                <th>
                                    <a href="/categorias/create" class="btn btn-primary"><i class="fas fa-plus"></i> Nova Categoria</a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categorias as $categoria)
                                <tr>
                                    <td>{{ $categoria->id }}</td>
                                    <td>{{ $categoria->nome }}</td>
                                    <td>{{ $categoria->updated_at }}</td>
                                    <td class="d-flex flex-row project-actions text-right">
                                        <div class="mx-1">
                                            <a href="/categorias/{{ $categoria->id }}/edit" class="btn btn-success"><i class="fas fa-edit"></i></a>
                                        </div>
                                        <div class="mx-1">
                                            <form action="{{ route('categorias.destroy', $categoria->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta categoria?');">
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
                        {{ $categorias->links('pagination::bootstrap-4') }}
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
    <script> console.log(""); </script>
@stop