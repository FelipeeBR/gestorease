<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comanda;

class ComandaController extends Controller
{
    // Listar todas as comandas
    public function index()
    {
        $comandas = Comanda::orderBy('created_at', 'desc')->get();
        return response()->json($comandas);
    }

    // Mostrar uma comanda específica
    public function show($id)
    {
        $comanda = Comanda::with('itens')->findOrFail($id);
        return response()->json($comanda);
    }

    // Criar nova comanda
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo' => 'required|in:mesa,delivery,balcao',
            'numero_mesa' => 'nullable|integer',
            'cliente' => 'nullable|string',
            'endereco' => 'nullable|string',
            'telefone' => 'nullable|string',
            'status' => 'required|in:aberta,fechada,cancelada',
            'total' => 'required|numeric',
            'caixa_id' => 'required|exists:caixas,id',
            'observacoes' => 'nullable|string',
        ]);

        $comanda = Comanda::create($validated);

        return response()->json($comanda, 201);
    }

    // Atualizar comanda
    public function update(Request $request, $id)
    {
        $comanda = Comanda::findOrFail($id);

        $validated = $request->validate([
            'tipo' => 'sometimes|in:mesa,delivery,balcao',
            'numero_mesa' => 'nullable|integer',
            'cliente' => 'nullable|string',
            'endereco' => 'nullable|string',
            'telefone' => 'nullable|string',
            'status' => 'sometimes|in:aberta,fechada,cancelada',
            'total' => 'nullable|numeric',
            'caixa_id' => 'nullable|exists:caixas,id',
            'observacoes' => 'nullable|string',
        ]);

        $comanda->update($validated);

        return response()->json($comanda);
    }

    // Deletar comanda
    public function destroy($id)
    {
        $comanda = Comanda::findOrFail($id);
        $comanda->delete();

        return response()->json(['message' => 'Comanda deletada com sucesso']);
    }
}
