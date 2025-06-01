@extends('adminlte::page')

@section('title', 'Editar Empresa')

@section('content_header')
    <h4><i class="fas fa-pen-square"></i> Editar Empresa</h4>
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
        @include('empresa.form', ['empresa' => $empresa])
    </div>
@stop
