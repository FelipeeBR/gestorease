@php
    $empresa = $empresa ?? null;
@endphp

<form action="{{ isset($empresa->id) ? route('empresa.update', $empresa->id) : route('empresa.store') }}" method="POST">
    @csrf
    @if(isset($empresa->id))
        @method('PUT')
    @endif
    <div class="">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="nome">Nome da Empresa</label>
                        <input type="text" class="form-control" id="nome" name="nome" 
                            value="{{ old('nome', $empresa->nome ?? '') }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="telefone">CNPJ</label>
                        <input type="text" class="form-control" id="cnpj" name="cnpj" 
                            value="{{ old('cnpj', $empresa->cnpj ?? '') }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="telefone">Telefone</label>
                        <input type="text" class="form-control" id="telefone" name="telefone" 
                            value="{{ old('telefone', $empresa->telefone ?? '') }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                            value="{{ old('email', $empresa->email ?? '') }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="endereco">Endereço</label>
                        <input type="text" class="form-control" id="endereco" name="endereco" 
                            value="{{ old('endereco', $empresa->endereco ?? '') }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="cep">CEP</label>
                        <input type="text" class="form-control" id="cep" name="cep" 
                            value="{{ old('cep', $empresa->cep ?? '') }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="bairro">Bairro</label>
                        <input type="text" class="form-control" id="bairro" name="bairro" 
                            value="{{ old('bairro', $empresa->bairro ?? '') }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="cidade">Cidade</label>
                        <input type="text" class="form-control" id="cidade" name="cidade" 
                            value="{{ old('cidade', $empresa->cidade ?? '') }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="uf">UF</label>
                        <input type="text" class="form-control" id="uf" name="uf" 
                            value="{{ old('uf', $empresa->uf ?? '') }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="uf">Número</label>
                        <input type="text" class="form-control" id="numero" name="numero" 
                            value="{{ old('numero', $empresa->numero ?? '') }}" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Editar</button>
        </div>
    </div>
</form>