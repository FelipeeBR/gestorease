<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TamanhoPizza;

class TamanhoPizzaController extends Controller
{
    public function index() {
        $query = TamanhoPizza::query();
        $tamanhos = $query->paginate(15);
        return view('tamanho-pizza.index', compact('tamanhos'));
    }

    public function create() {
        $tamanho = new TamanhoPizza();
        return view('tamanho-pizza.create', compact('tamanho'));
    }

    public function store(Request $request) {
        $validation = $request->validate([
            'nome' => 'required|string|max:100'
        ],[
            'nome.required' => 'O campo Nome é obrigatório.',
        ]);

        TamanhoPizza::create($validation);
        
        return redirect()->route('tamanho-pizza.index')->with('success', 'Tamanho criado com sucesso!');
    }

    public function edit($id) {
        $tamanho = TamanhoPizza::findOrFail($id);
        return view('tamanho-pizza.edit', compact('tamanho'));  
    }

    public function update(Request $request, string $id) {
        $tamanho = TamanhoPizza::findOrFail($id);

        $validation = $request->validate([
            'nome' => 'required|string|max:100'
        ],[
            'nome.required' => 'O campo Nome é obrigatório.',
        ]);

        $tamanho->fill($validation); 
        $tamanho->save();
        return redirect()->route('tamanho-pizza.index')->with('success', 'Tamanho atualizado com sucesso!');
    }

    public function destroy(string $id) {
        $tamanho = TamanhoPizza::findOrFail($id);
        $tamanho->delete();
        return redirect()->route('tamanho-pizza.index')->with('success', 'Tamanho excluido com sucesso!');
    }
}
