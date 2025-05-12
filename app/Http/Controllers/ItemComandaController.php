<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemComanda;

class ItemComandaController extends Controller
{
    // Adicionar item na comanda
    public function store(Request $request)
    {
        $validated = $request->validate([
            'comanda_id' => 'required|exists:comandas,id',
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:1',
            'preco_unitario' => 'required|numeric|min:0',
        ]);

        // Calcula subtotal
        $validated['subtotal'] = $validated['quantidade'] * $validated['preco_unitario'];

        $item = ItemComanda::create($validated);

        return response()->json($item, 201);
    }
}
