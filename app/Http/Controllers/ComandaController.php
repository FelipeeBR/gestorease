<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comanda;
use App\Models\Mesa;
use App\Models\Caixa;
use App\Models\Produto;
use App\Models\VariacaoPizza;
use App\Models\BordaPizza;
use App\Models\TamanhoPizza;

class ComandaController extends Controller
{
    // Listar todas as comandas
    public function index()
    {
        $comandas = Comanda::orderBy('created_at', 'desc')->get();
        //return response()->json($comandas);
        return view('caixa.show', compact('comandas'));
    }

    public function create()
    {
        $comanda = new Comanda();
        $mesas = Mesa::query()->where('status', 'livre')->get();
        $caixa = Caixa::query()->where('data_fechamento', null)->first();
        return view('caixa.comanda.create', compact('comanda', 'mesas', 'caixa'));
    }

    // Mostrar uma comanda específica
    public function show($id)
    {
        $comanda = Comanda::with('itens')->findOrFail($id);
        $produtos = Produto::all();
        $variacoes_pizza = VariacaoPizza::all();
        $bordas_pizza = BordaPizza::all();
        $tamanhos_pizza = TamanhoPizza::all();
        return view('caixa.comanda.show', compact(
            'comanda', 'produtos', 'variacoes_pizza', 'bordas_pizza', 'tamanhos_pizza'
        ));
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
        ], [
            'tipo.required' => 'O campo Tipo é obrigatório.',
            'status.required' => 'O campo Status é obrigatório.',
            'caixa_id.required' => 'O campo Caixa é obrigatório.',
        ]);

        $mesa = Mesa::find($validated['numero_mesa']);
        if($mesa) {
            $mesa->status = 'ocupada';
            $mesa->save();
        }

        $comanda = Comanda::create($validated);

        return redirect()->route('caixa.comanda.show', ['comanda' => $comanda->id]);
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

        return redirect()->route('caixa.comanda.show', ['comanda' => $comanda->id]);
    }

    // Deletar comanda
    public function destroy($id)
    {
        $comanda = Comanda::findOrFail($id);
        $comanda->delete();

        return response()->json(['message' => 'Comanda deletada com sucesso']);
    }

    public function edit($id)
    {
        $comanda = Comanda::findOrFail($id);
        $mesas = Mesa::query()->where('status', 'livre')
            ->orWhere('id', $comanda->numero_mesa)->get();
        $caixa = Caixa::query()->where('data_fechamento', null)->first();
        return view('caixa.comanda.edit', compact('comanda', 'mesas', 'caixa'));
    }

    public function fechar($id, Request $request)
    {
        $comanda = Comanda::findOrFail($id);
        $caixa = Caixa::query()->where('data_fechamento', null)->first();
        $mesa = Mesa::find($comanda->numero_mesa);
        if($mesa) {
            $mesa->status = 'livre';
            $mesa->save();
        }
        
        $caixa->total_vendas += $comanda->total;
        $caixa->save();

        $comanda->forma_pagamento = $request->input('forma_pagamento');
        $comanda->status = 'fechada';
        $comanda->save();
        return redirect()->route('caixa.comanda.show', ['comanda' => $comanda->id]);
    }

    public function cancelar($id)
    {
        $comanda = Comanda::findOrFail($id);
        $mesa = Mesa::find($comanda->numero_mesa);
        if($mesa) {
            $mesa->status = 'livre';
            $mesa->save();
        }
        $comanda->status = 'cancelada';
        $comanda->save();
        return redirect()->route('caixa.comanda.show', ['comanda' => $comanda->id]);
    }
}
