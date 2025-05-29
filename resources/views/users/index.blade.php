@extends('adminlte::page')

@section('title', 'Usuários')

@section('content_header')
    <h4><i class="fa fa-users"></i> Usuários</h4>
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
                    <h3 class="card-title">Lista de Usuários</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NOME</th>
                                <th>EMAIL</th>
                                <th>FUNÇÕES</th>
                                <th>CRIADO EM</th>
                                <th>ATUALIZADO EM</th>
                                <th><a href="/users/create" class="btn btn-primary"><i class="fas fa-plus"></i> Novo Usuário</a></th>
                            </tr>
                            <tr>
                                <form action="">
                                    <th></th>
                                    <th>
                                        <input type="text" class="form-control form-control-sm" name="name" id="name" placeholder="Filtrar Nome">
                                    </th>
                                    <th>
                                        <input type="text" class="form-control form-control-sm" name="email" id="email" placeholder="Filtrar Email">
                                    </th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="fas fa-filter"></i> Filtrar
                                        </button>
                                        <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm ml-2">
                                            <i class="fas fa-backspace"></i> Limpar Filtros
                                        </a>
                                    </th>
                                </form>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <ol>
                                            @forelse ($user->roles as $role)
                                                <li>{{ $role->name }}</li>
                                            @empty
                                                <li>Sem Funções</li>
                                            @endforelse
                                        </ol>
                                    </td>
                                    <td>{{ $user->created_at->timezone('America/Sao_Paulo')->format('d/m/Y H:i') }}</td>
                                    <td>{{ $user->updated_at->timezone('America/Sao_Paulo')->format('d/m/Y H:i') }}</td>
                                    <td class="d-flex flex-row project-actions text-right">
                                        <div class="mx-1">
                                            <a href="/users/{{ $user->id }}/edit" class="btn btn-success"><i class="fas fa-edit"></i></a>
                                        </div>
                                        <div class="mx-1">
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');">
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
                        {{ $users->links('pagination::bootstrap-4') }}
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
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop