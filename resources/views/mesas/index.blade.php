@extends('adminlte::page')

@section('title', 'Mesas')

@section('content_header')
    <h1>Mesas</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Mesas disponíveis</h3>

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
                                <th>NUMERO</th>
                                <th>STATUS</th>
                                <th>CRIADO POR</th>
                                <th><a href="/mesas/create" class="btn btn-primary">Nova Mesa <i class="fas fa-plus"></i></a></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($mesas as $mesa)
                                <tr>
                                    <td>{{ $mesa->id }}</td>
                                    <td>{{ $mesa->numero }}</td>
                                    <td>{{ $mesa->status }}</td>
                                    <td>{{ $mesa->created_by }}</td>
                                    <td class="d-flex flex-row project-actions text-right">
                                        <div class="mx-1">
                                            <a href="/mesas/{{ $mesa->id }}/edit" class="btn btn-success"><i class="fas fa-edit"></i></a>
                                        </div>
                                        <div class="mx-1">
                                            <form action="{{ route('mesas.destroy', $mesa->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta mesa?');">
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