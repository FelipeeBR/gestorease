<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemComanda;
use App\Models\Produto;
use App\Models\Comanda;

class ItemComandaController extends Controller
{
    public function store(Request $request, $comanda)
    {
        $validated = $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:1',
            'borda_id' => 'nullable|exists:borda_pizza,id'
        ]);

        $validated['variacao_pizza_id'] = $request->variacao_pizza;
        $validated['preco_unitario'] = $request->preco_unitario;
        $validated['borda_id'] = $request->borda_id;
        $validated['comanda_id'] = $comanda;
        $validated['subtotal'] = $validated['quantidade'] * $request->preco_unitario;

        ItemComanda::create($validated);

        $comanda = Comanda::findOrFail($comanda);
        $comanda->total += $validated['subtotal'];
        $comanda->save();

        return redirect()->route('caixa.comanda.show', ['comanda' => $comanda->id])->with('success', 'Item adicionado com sucesso!');
    }

    public function destroy($id)
    {
        $item = ItemComanda::findOrFail($id);
        $comanda = Comanda::findOrFail($item->comanda_id);
        $comanda->total -= $item->subtotal;
        $comanda->save();
        $item->delete();
        return redirect()->back()->with('success', 'Item excluído com sucesso!');
    }
}
