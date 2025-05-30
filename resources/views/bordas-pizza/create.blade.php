@extends('adminlte::page')

@section('title', 'Adicionar Borda Pizza')

@section('content_header')
    <h1>Adicionar Borda Pizza</h1>
    @if(session('success'))
        <x-adminlte-alert theme="success" title="Successo">
            {{ session('success') }}
        </x-adminlte-alert>
    @endif

    @if ($errors->any())
        <x-adminlte-alert theme="danger" title="Erro">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-adminlte-alert>
    @endif
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Preencha os Campos</h3>
        </div>
        @include('bordas-pizza.form')
    </div>
@stop
