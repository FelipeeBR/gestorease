@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h4><i class="fa fa-th-large me-2"></i> Dashboard</h4>
@stop

@section('content')
<section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-6">
          <div class="small-box bg-gradient-success">
            <div class="inner">
              <h3>{{ $countUsers }}</h3>
              <p>Pedidos Abertos</p>
            </div>
            <div class="icon">
              <i class="fas fa-file-powerpoint"></i>
            </div>
            <a href="/pedidos" class="small-box-footer">
              Mais Informações <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{ $countUsers }}</h3>
              <p>Usuários do Sistema</p>
            </div>
            <div class="icon">
              <i class="fas fa-user-plus"></i>
            </div>
            <a href="/users" class="small-box-footer">
              Mais Informações <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <div class="small-box bg-primary">
            <div class="inner">
              <h3>{{ $countProdutos }}</h3>
              <p>Produtos</p>
            </div>
            <div class="icon">
              <i class="fas fa-barcode"></i>
            </div>
            <a href="/produtos" class="small-box-footer">
              Mais Informações <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>-</h3>
              <p>Relatórios (EM DESENVOLVIMENTO)</p>
            </div>
            <div class="icon">
              <i class="fas fa-file"></i>
            </div>
            <a href="#" class="small-box-footer">
              Mais Informações <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
  </section>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop
