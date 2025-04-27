@extends('adminlte::page')

@section('title', 'Criar Categoria')

@section('content_header')
    <h1>Criar Categoria</h1>
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
        @include('categorias.form')
    </div>
@stop
