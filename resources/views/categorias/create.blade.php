@extends('adminlte::page')

@section('title', 'Criar Categoria')

@section('content_header')
    <h4><i class="fa fa-plus-square"></i> Criar Categoria</h4>
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
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Preencha os Campos</h3>
        </div>
        @include('categorias.form')
    </div>
@stop
