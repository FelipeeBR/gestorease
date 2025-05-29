@extends('adminlte::page')

@section('title', 'Editar Usuário')

@section('content_header')
    <h4><i class="fa fa-pen-square"></i> Editar Usuário</h4>
    @if(session('success'))
        @section('js')
            <script type="text/javascript">
                $(document).ready(function() {
                    toastr.success('{{ session('success') }}');
                });
            </script>
        @endsection
    @endif

    @if($errors->any())
        @section('js')
            <script type="text/javascript">
                $(document).ready(function() {
                    toastr.error('{{ $errors->first() }}');
                });
            </script>
        @endsection
    @endif
@stop

@section('content')
    <div class="card card-outline card-warning">
        <div class="card-header">
            <h3 class="card-title">Atualize os Campos</h3>
        </div>
        @include('users.form', ['usuario' => $usuario])
    </div>
@stop
