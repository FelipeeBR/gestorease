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
      </div>
      <div class="row">
        <div class="col-lg-6 col-4">
          <div class="card card-outline card-warning">
            <div class="card-header">
              <h3 class="card-title"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i> Produtos com estoque baixo</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <table class="table table-hover text-nowrap">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Quantidade</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($produtosEstoque as $produto)
                    <tr>
                      <td>{{ $produto->id }}</td>
                      <td>{{ $produto->nome }}</td>
                      <td>{{ $produto->quantidade_estoque }}</td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="3">Nenhum registro encontrado</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-4">
          <div class="card card-outline card-success">
            <div class="card-header">
              <h3 class="card-title"><i class="fa fa-info" aria-hidden="true"></i> Informações</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div class="info-box">
                <span class="info-box-icon bg-success"><i class="far fa-money-bill-alt"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Vendas Realizadas</span>
                  <span class="info-box-number">{{ $vendasFinalizadas->count() ?? 0 }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop
