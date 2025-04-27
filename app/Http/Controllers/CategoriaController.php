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
            'nome' => 'required|string|max:100', 
        ]);
        Categoria::create($validated);
        return redirect()->route('categorias.index');
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
