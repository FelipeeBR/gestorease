<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }
        /*if ($request->filled('role_id')) {
            $query->where('role_id', $request->role_id);
        }*/
        $users = $query->paginate(15);
        
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usuario = new User();
        $roles = Role::all();
        return view('users.create', compact('usuario', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'senha' => 'required|min:6',
            'role_id' => 'required|exists:roles,id',
        ], [
            'nome.required' => 'O campo Nome é obrigatório.',
            'email.required' => 'O campo Email é obrigatório.',
            'email.email' => 'Informe um email válido.',
            'email.unique' => 'Este email já está em uso.',
            'senha.required' => 'O campo Senha é obrigatório.',
            'senha.min' => 'A senha deve ter pelo menos 6 caracteres.',
        ]);

        $user = User::create([
            'name' => $request->input('nome'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('senha')),
        ]);
        
        $user->roles()->sync($request->input('role_id', []));

        return redirect()->back()->with('success', 'Usuário cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        $roles = Role::all();
        return view('users.edit', compact('usuario', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $usuario = User::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id, 
            'senha' => 'nullable|min:6',
            'role_id' => 'array',
            'role_id' => 'required|exists:roles,id',
        ], [
            'nome.required' => 'O campo Nome é obrigatório.',
            'email.required' => 'O campo Email é obrigatório.',
            'email.email' => 'Informe um email válido.',
            'email.unique' => 'Este email já está em uso.',
            'senha.min' => 'A senha deve ter pelo menos 6 caracteres.',
        ]);

        $usuario->name = $request->input('nome');
        $usuario->email = $request->input('email');

        if($request->filled('senha')) {
            $usuario->password = Hash::make($request->input('senha'));
        }

        $usuario->save();
        $usuario->roles()->sync($request->input('role_id', []));

        return redirect()->back()->with('success', 'Usuário atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();

        return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso!');
    }
}
