<?php

namespace App\Http\Controllers;

use App\Models\Mesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MesaController extends Controller
{
    // Listar todas as mesas
    public function index(Request $request)
    {
        $query = Mesa::query()
        ->with(['criador', 'editor']) 
        ->orderBy('id', 'asc'); 

        if ($request->filled('numero')) {
            $query->where('numero', 'like', '%' . $request->numero . '%');
        }
        if ($request->filled('status')) {
            $query->where('status', 'like', '%' . $request->status . '%');
        }

        $mesas = $query->get();
        return view('mesas.index', compact('mesas'));
    }

    // Mostrar formulário de criação
    public function create()
    {
        return view('mesas.create');
    }

    // Armazenar nova mesa
    public function store(Request $request)
    {
        $validated = $request->validate([
            'numero' => 'required|string|max:50|unique:mesas',
            'status' => 'sometimes|in:livre,ocupada,reservada,inativa'
        ]);

        $mesa = Mesa::create([
            'numero' => $validated['numero'],
            'status' => $validated['status'] ?? 'livre',
            'created_by' => Auth::id(),
            'updated_by' => Auth::id()
        ]);

        return redirect()->route('mesas.index')->with('success', 'Mesa criada com sucesso!');
    }

    // Mostrar uma mesa específica
    public function show(Mesa $mesa)
    {
        return view('mesas.show', compact('mesa'));
    }

    // Mostrar formulário de edição
    public function edit(Mesa $mesa)
    {
        return view('mesas.edit', compact('mesa'));
    }

    // Atualizar mesa
    public function update(Request $request, Mesa $mesa)
    {
        $validated = $request->validate([
            'numero' => 'required|string|max:50|unique:mesas,numero,'.$mesa->id,
            'status' => 'required|in:livre,ocupada,reservada,inativa'
        ]);

        $mesa->update([
            'numero' => $validated['numero'],
            'status' => $validated['status'],
            'updated_by' => Auth::id()
        ]);

        return redirect()->route('mesas.index')->with('success', 'Mesa atualizada com sucesso!');
    }

    // Deletar mesa (soft delete)
    public function destroy(Mesa $mesa)
    {
        $mesa->delete();
        return redirect()->route('mesas.index')->with('success', 'Mesa removida com sucesso!');
    }
}
