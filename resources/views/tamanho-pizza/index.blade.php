@extends('adminlte::page')

@section('plugins.TempusDominusBs4', true)
@section('plugins.Moment', true)

@section('title', 'Tamanhos de Pizza')

@section('content_header')
    <h4><i class="fa fa-pizza-slice"></i> Tamanhos de Pizza</h4>
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
                    <h3 class="card-title">Lista de Tamanhos</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NOME</th>
                                <th>ATUALIZADO EM</th>
                                <th>
                                    <a href="/tamanho-pizza/create" class="btn btn-primary"><i class="fas fa-plus"></i> Novo Tamanho</a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tamanhos as $tamanho)
                                <tr>
                                    <td>{{ $tamanho->id }}</td>
                                    <td>{{ $tamanho->nome }}</td>
                                    <td>{{ $tamanho->updated_at->timezone('America/Sao_Paulo')->format('d/m/Y H:i') }}</td>
                                    <td class="d-flex flex-row project-actions text-right">
                                        <div class="mx-1">
                                            <a href="/tamanho-pizza/{{ $tamanho->id }}/edit" class="btn btn-success"><i class="fas fa-edit"></i></a>
                                        </div>
                                        <div class="mx-1">
                                            <form action="{{ route('tamanho-pizza.destroy', $tamanho->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta tamanho?');">
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
                        {{ $tamanhos->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop