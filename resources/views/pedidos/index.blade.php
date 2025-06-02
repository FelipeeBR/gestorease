@extends('adminlte::page')

@section('title', 'Pedidos Abertos')

@section('content_header')
    <h4><i class="fa fa-clipboard-list"></i> Pedidos Abertos</h4>
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
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h5 class="mb-0">Lista de Pedidos</h5>
        </div>
        <div class="card-body">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>N° Comanda</th>
                            <th>Tipo</th>
                            <th>Ações</th>
                        </tr>
                        <tr>
                            <form method="GET">
                                <th>
                                    <input type="text" name="id" id="id" class="form-control form-control-sm" placeholder="N° Pedido">
                                </th>
                                <th>
                                    <select type="text" name="tipo" id="tipo" class="form-control form-control-sm" placeholder="Filtrar Tipo">
                                        <option value="">-- Filtrar Tipo --</option>
                                        <option value="mesa" {{ request('tipo') == 'mesa' ? 'selected' : '' }}>Mesa</option>
                                        <option value="delivery" {{ request('tipo') == 'delivery' ? 'selected' : '' }}>Delivery</option>
                                        <option value="balcao" {{ request('tipo') == 'balcao' ? 'selected' : '' }}>Balcão</option>
                                    </select>
                                </th>
                                <th>
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="fas fa-filter"></i> Filtrar
                                    </button>
                                </th>
                            </form> 
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($comandas as $comanda)
                            <tr>
                                <td>{{ $comanda->id }}</td>
                                <td class="text-uppercase">{{ $comanda->tipo }}</td>
                                <td>
                                    <a href="{{ route('caixa.comanda.show', $comanda->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Visiualizar
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Nenhum pedido registrado</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                <div class="float-right">
                    {{ $comandas->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@stop