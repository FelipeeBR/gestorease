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
        return view('bordas-pizza.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
    public function edit(BordaPizza $borda)
    {
        return view('bordas-pizza.edit', compact('borda'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BordaPizza $borda)
    {
        $request->validate([
            'nome' => 'required|string|max:100',
            'preco_adicional' => 'required|numeric|min:0',
            'ativo' => 'boolean'
        ]);

        $borda->update($request->all());

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
