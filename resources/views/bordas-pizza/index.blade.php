@extends('adminlte::page')

@section('title', 'Bordas Pizza')

@section('content_header')
    <h1>Bordas Pizza</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lista de Bordas</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NOME</th>
                                <th>STATUS</th>
                                <th>
                                    <a href="/bordas-pizza/create" class="btn btn-primary"><i class="fas fa-plus"></i> Nova Borda</a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($bordas as $borda)
                                <tr>
                                    <td>{{ $borda->id }}</td>
                                    <td>{{ $borda->nome }}</td>
                                    <td>{{ $borda->status }}</td>
                                    <td class="d-flex flex-row project-actions text-right">
                                        <div class="mx-1">
                                            <a href="/bordas-pizza/{{ $borda->id }}/edit" class="btn btn-success"><i class="fas fa-edit"></i></a>
                                        </div>
                                        <div class="mx-1">
                                            <form action="{{ route('bordas.destroy', $borda->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta borda?');">
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
    <script> console.log(""); </script>
@stop