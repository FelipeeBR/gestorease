@extends('adminlte::page')

@section('title', 'Editar Mesa')

@section('content_header')
    <h4><i class="fas fa-pen-square"></i> Editar Mesa</h4>
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
    <div class="card card-outline card-warning">
        <div class="card-header">
            <h3 class="card-title">Atualize os Campos</h3>
        </div>
        @include('mesas.form', ['mesa' => $mesa])
    </div>
@stop
