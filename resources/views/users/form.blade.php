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

        <div class="form-group">
            <label for="inputRole">Nível de Acesso</label>
            <select class="form-control" id="inputRole" name="role_id" required>
                <option value="">-- Selecione um nível --</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}"
                        {{ old('role_id', optional($usuario->roles->first())->id ?? '') == $role->id ? 'selected' : '' }}>
                        {{ ucfirst($role->name) }}
                    </option>
                @endforeach
            </select>
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
