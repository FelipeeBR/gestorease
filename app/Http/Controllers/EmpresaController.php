<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;

class EmpresaController extends Controller
{
    public function index() {
        $empresa = Empresa::first();

        return view('empresa.index', compact('empresa'));
    }

    public function create() {
        $empresa = new Empresa();
        return view('empresa.create', compact('empresa'));
    }

    public function store(Request $request) {
        $request->validate([
            'nome' => 'required|string|min:3|max:100',
            'endereco' => 'required|string|min:3|max:100',
            'telefone' => 'required|string|min:3|max:100',
            'email' => 'required|string|min:3|max:100',
        ]);

        Empresa::create([
            'nome' => $request->input('nome'),
            'endereco' => $request->input('endereco'),
            'telefone' => $request->input('telefone'),
            'email' => $request->input('email'),
        ]);
        return redirect()->route('empresa.index')->with('success', 'Empresa cadastrada com sucesso!');
    }

    public function edit($id) {
        $empresa = Empresa::findOrFail($id);
        return view('empresa.edit', compact('empresa'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'nome' => 'required|string|min:3|max:100',
            'endereco' => 'required|string|min:3|max:100',
            'telefone' => 'required|string|min:3|max:100',
            'email' => 'string|min:3|max:100',
        ], [
            'nome.required' => 'O campo Nome é obrigatório.',
            'endereco.required' => 'O campo Endereço é obrigatório.',
            'telefone.required' => 'O campo Telefone é obrigatório.',
        ]);

        $empresa = Empresa::findOrFail($id);
        $empresa->update([
            'nome' => $request->input('nome'),
            'endereco' => $request->input('endereco'),
            'telefone' => $request->input('telefone'),
            'email' => $request->input('email'),
            'cnpj' => $request->input('cnpj'),
            'cep' => $request->input('cep'),
            'cidade' => $request->input('cidade'),
            'uf' => $request->input('uf'),
            'bairro' => $request->input('bairro'),
            'numero' => $request->input('numero'),
        ]);
        return redirect()->route('empresa.index')->with('success', 'Empresa atualizada com sucesso!');
    }
}
