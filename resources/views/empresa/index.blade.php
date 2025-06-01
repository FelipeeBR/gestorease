@extends('adminlte::page')

@section('title', 'Empresa')

@section('content_header')
    <h4><i class="fa fa-building me-2"></i> Empresa</h4>
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
            <h3 class="card-title">
                <i class="fas fa-building mr-2"></i>Informações da Empresa
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Seção de Informações Básicas -->
                <div class="col-md-6">
                    <div class="info-box bg-light">
                        <div class="info-box-content">
                            <h4 class="info-box-text">Dados Cadastrais</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Nome da Empresa:</label>
                                        <p class="form-control-static">{{ old('nome', $empresa->nome ?? 'N/A') }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">CNPJ:</label>
                                        <p class="form-control-static">{{ isset($empresa->cnpj) ? preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $empresa->cnpj) : 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Telefone:</label>
                                        <p class="form-control-static">{{ isset($empresa->telefone) ? preg_replace("/(\d{2})(\d{4,5})(\d{4})/", "(\$1) \$2-\$3", $empresa->telefone) : 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Email:</label>
                                        <p class="form-control-static">
                                            {{ old('email', $empresa->email ?? 'N/A') }}
                                            @isset($empresa->email)
                                                <a href="mailto:{{ $empresa->email }}" class="ml-2"><i class="fas fa-envelope"></i></a>
                                            @endisset
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Seção de Endereço -->
                <div class="col-md-6">
                    <div class="info-box bg-light">
                        <div class="info-box-content">
                            <h4 class="info-box-text">Endereço</h4>
                            <div class="address-container">
                                @if(isset($empresa->endereco) && isset($empresa->bairro) && isset($empresa->cidade) && isset($empresa->uf) && isset($empresa->cep))
                                    <div class="form-group">
                                        <p class="form-control-static address-line">
                                            <i class="fas fa-map-marker-alt mr-2"></i>
                                            {{ $empresa->endereco }}, {{ $empresa->bairro }}
                                        </p>
                                        <p class="form-control-static address-line">
                                            <i class="fas fa-city mr-2"></i>
                                            {{ $empresa->cidade }} - {{ $empresa->uf }}
                                        </p>
                                        <p class="form-control-static address-line">
                                            <i class="fas fa-mail-bulk mr-2"></i>
                                            CEP: {{ isset($empresa->cep) ? preg_replace("/(\d{5})(\d{3})/", "\$1-\$2", $empresa->cep) : 'N/A' }}
                                        </p>
                                    </div>
                                @else
                                    <p class="text-muted">Endereço não cadastrado</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('empresa.edit', $empresa->id ?? '') }}" class="btn btn-primary">
                <i class="fas fa-edit mr-2"></i>Editar Informações
            </a>
        </div>
    </div>
@stop

@section('css')
<style>
    .form-control-static {
        padding: 0.375rem 0;
        margin-bottom: 0;
        line-height: 1.5;
        background-color: transparent;
        border-bottom: 1px solid #e9ecef;
    }
    
    .info-box {
        border-radius: 0.25rem;
        padding: 15px;
        margin-bottom: 0;
        height: 100%;
    }
    
    .info-box-text {
        font-size: 1.1rem;
        color: #6c757d;
        margin-bottom: 15px;
        border-bottom: 1px solid #dee2e6;
        padding-bottom: 8px;
    }
    
    .address-container {
        padding: 10px;
    }
    
    .address-line {
        margin-bottom: 8px;
        padding-left: 25px;
        position: relative;
    }
    
    .address-line i {
        position: absolute;
        left: 0;
        top: 5px;
        color: #6c757d;
    }
</style>
@endsection