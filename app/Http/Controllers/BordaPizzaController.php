<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BordaPizza;

class BordaPizzaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bordas = BordaPizza::all();
        return view('bordas-pizza.index', compact('bordas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bordas = new BordaPizza();
        return view('bordas-pizza.create', compact('bordas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'ativo' => $request->input('ativo') === 'true'
        ]);
        
        $request->validate([
            'nome' => 'required|string|max:100',
            'preco_adicional' => 'required|numeric|min:0',
            'ativo' => 'boolean'
        ]);

        BordaPizza::create($request->all());

        return redirect()->route('bordas-pizza.index')
            ->with('success', 'Borda criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(BordaPizza $borda)
    {
        return view('bordas-pizza.show', compact('borda'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $borda = BordaPizza::findOrFail($id);
        return view('bordas-pizza.edit', compact('borda'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $borda = BordaPizza::findOrFail($id);
        $request->merge([
            'ativo' => $request->input('ativo') === 'true'
        ]);

        $request->validate([
            'nome' => 'required|string|max:100',
            'preco_adicional' => 'required|numeric|min:0',
            'ativo' => 'boolean'
        ]);

        $borda->nome = $request->input('nome');
        $borda->preco_adicional = $request->input('preco_adicional');
        $borda->ativo = $request->input('ativo');

        $borda->save();

        return redirect()->route('bordas-pizza.index')
            ->with('success', 'Borda atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BordaPizza $borda)
    {
        $borda->delete();

        return redirect()->route('bordas-pizza.index')
            ->with('success', 'Borda removida com sucesso!');
    }
}
