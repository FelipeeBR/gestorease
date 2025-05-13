@extends('adminlte::page')

@section('title', 'Nova Comanda')

@section('content_header')
    <h1>Nova Comanda</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Preencha os Campos</h3>
        </div>
        <div class="card-body">
            @include('caixa.comanda.form', ['comanda' => $comanda, 'mesas' => $mesas])
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/vendor/adminlte/dist/css/adminlte.min.css">
@stop

@section('js')
    <script src="/vendor/adminlte/dist/js/adminlte.min.js"></script>
@stop