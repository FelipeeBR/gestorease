@extends('adminlte::page')

@section('title', 'Mesas')

@section('content_header')
    <h4><i class="fa fa-table"></i> Mesas</h4>
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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Mesas disponíveis</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>NUMERO</th>
                                <th>STATUS</th>
                                <th>CRIADO POR</th>
                                <th><a href="/mesas/create" class="btn btn-primary"><i class="fas fa-plus"></i> Nova Mesa</a></th>
                            </tr>
                            <tr>
                                <form method="GET" action="{{ route('mesas.index') }}">
                                    <th><input type="text" name="numero" class="form-control form-control-sm" placeholder="Filtrar Número" value="{{ request('numero') }}"></th>
                                    <th>
                                        <select type="text" name="status" class="form-control form-control-sm" placeholder="Filtrar Status">
                                            <option value="">-- Filtrar Status --</option>
                                            <option value="livre" {{ request('status') == 'livre' ? 'selected' : '' }}>Livre</option>
                                            <option value="ocupada" {{ request('status') == 'ocupada' ? 'selected' : '' }}>Ocupada</option>
                                            <option value="reservada" {{ request('status') == 'reservada' ? 'selected' : '' }}>Reservada</option>
                                            <option value="inativa" {{ request('status') == 'inativa' ? 'selected' : '' }}>Inativa</option>
                                        </select>
                                    </th>
                                    <th></th>
                                    <th>
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="fas fa-filter"></i> Filtrar
                                        </button>
                                        <a href="{{ route('mesas.index') }}" class="btn btn-secondary btn-sm ml-2">
                                            <i class="fas fa-backspace"></i> Limpar Filtros
                                        </a>
                                    </th>
                                </form>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($mesas as $mesa)
                                @php
                                    $bgClass = 'bg-success'; // padrão (livre)
                                    if ($mesa->status === 'ocupada') {
                                        $bgClass = 'bg-danger';
                                    } elseif ($mesa->status === 'reservada') {
                                        $bgClass = 'bg-warning';
                                    } elseif ($mesa->status === 'inativa') {
                                        $bgClass = 'bg-secondary';
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $mesa->numero }}</td>
                                    <td>
                                        <span class="badge {{ $bgClass }} text-uppercase">{{ $mesa->status }}</span>
                                    </td>
                                    <td>{{ $mesa->criador->name }}</td>
                                    <td class="d-flex flex-row project-actions text-right">
                                        <div class="mx-1">
                                            <a href="/mesas/{{ $mesa->id }}/edit" class="btn btn-success"><i class="fas fa-edit"></i></a>
                                        </div>
                                        <div class="mx-1">
                                            <form action="{{ route('mesas.destroy', $mesa->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta mesa?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">Nenhum registro encontrado</td>
                                </tr>
                            @endforelse  
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .card-footer {
            background-color: transparent;
        }
    </style>
@stop


@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop