<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::paginate(15);
        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        $categoria = new Categoria();
        return view('categorias.create', compact('categoria'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|min:3|max:100', 
        ],[
            'nome.required' => 'O campo nome é obrigatório',
            'nome.min' => 'O campo nome deve ter no mínimo 3 caracteres',
            'nome.max' => 'O campo nome deve ter no máximo 100 caracteres',
        ]);
        Categoria::create($validated);
        return redirect()->route('categorias.index')->with('success', 'Categoria criada com sucesso!');
    }

    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('categorias.edit', compact('categoria'));
    }

    public function update(Request $request, $id)
    {
        $categoria = Categoria::findOrFail($id);
        $validated = $request->validate([
            'nome' => 'required|string|max:100', 
        ]);

        $categoria->nome($request->input('nome'));
        $categoria->save();
        return redirect()->route('categorias.index');
    }

    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();
        return redirect()->route('categorias.index');
    }
}
