@php
    $usuario = $usuario ?? null;
@endphp
<form 
    action="{{ isset($usuario->id) ? route('users.update', $usuario->id) : route('users.store') }}" 
    method="POST">

    @csrf
    @if(isset($usuario->id))
        @method('PUT')
    @endif

    <div class="card-body">
        <div class="form-group">
            <label for="inputNome">Nome</label>
            <input type="text" class="form-control" id="inputNome" name="nome" 
                value="{{ old('nome', $usuario->name ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="inputEmail">Email</label>
            <input type="email" class="form-control" id="inputEmail" name="email" 
                value="{{ old('email', $usuario->email ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="inputSenha">Senha</label>
            <input type="password" class="form-control" id="inputSenha" name="senha" 
                placeholder="Deixe em branco para manter (somente edição)">
        </div>

        @php
            $config = [
                "placeholder" => "Selecione os níveis de acesso",
                "allowClear" => true,
            ];
        @endphp
        <div class="form-group">
            <x-adminlte-select2 id="sel2Category" name="role_id[]" label="Nível de Acesso"
                label-class="text-primary" igroup-size="sm" :config="$config" multiple>
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-gradient-blue">
                        <i class="fas fa-user-secret"></i>
                    </div>
                </x-slot>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}"
                        {{ (in_array($role->id, old('role_id', $usuario->roles->pluck('id')->toArray() ?? []))) ? 'selected' : '' }}>
                        {{ ucfirst($role->name) }}
                    </option>
                @endforeach
            </x-adminlte-select2>
        </div>
    </div>

    <div class="card-footer">
        <button type="submit" class="btn btn-primary">
            {{ isset($usuario->id) ? 'Atualizar Usuário' : 'Cadastrar Novo Usuário' }}
        </button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary ml-2">
            <i class="fas fa-arrow-left"></i> Cancelar
        </a>
    </div>
</form>
