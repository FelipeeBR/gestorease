<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemComanda;
use App\Models\Produto;

class ItemComandaController extends Controller
{
    // Adicionar item na comanda
    public function store(Request $request, $comanda)
    {
        $validated = $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:1',
        ]);

        $produto = Produto::findOrFail($validated['produto_id']);
        $validated['preco_unitario'] = $produto->preco_venda;
        $validated['comanda_id'] = $comanda;
        $validated['subtotal'] = $validated['quantidade'] * $produto->preco;

        $item = ItemComanda::create($validated);

        return redirect()->back()->with('success', 'Item adicionado com sucesso!');
    }
}
