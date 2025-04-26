<?php

namespace App\Http\Controllers;

use App\Models\VariacaoPizza;
use App\Models\TamanhoPizza;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VariacaoPizzaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $variacoes = VariacaoPizza::with(['produto', 'tamanhoPizza'])
            ->orderBy('produto_id')
            ->orderBy('tamanho_pizza_id')
            ->paginate(10);

        return view('pizzas.index', compact('variacoes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $produtos = Produto::where('categoria_id', 3)->get();
        $tamanhos = TamanhoPizza::all();
        
        return view('pizzas.create', compact('produtos', 'tamanhos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'tamanho_pizza_id' => [
                'required',
                'exists:tamanho_pizza,id',
                Rule::unique('variacao_pizza')->where(function ($query) use ($request) {
                    return $query->where('produto_id', $request->produto_id)
                                 ->where('tamanho_pizza_id', $request->tamanho_pizza_id);
                })
            ],
            'preco' => 'required|numeric|min:0.01',
            'tipo' => 'required|in:salgada,doce'
        ], [
            'tamanho_pizza_id.unique' => 'Já existe uma variação para este produto com o mesmo tamanho.'
        ]);

        VariacaoPizza::create($validated);

        return redirect()->route('pizzas.index')
            ->with('success', 'Variação criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(VariacaoPizza $variacaoPizza)
    {
        return view('pizzas.show', compact('variacaoPizza'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VariacaoPizza $variacaoPizza)
    {
        $produtos = Produto::where('tipo', 'pizza')->get();
        $tamanhos = TamanhoPizza::all();
        
        return view('pizzas.edit', compact('variacaoPizza', 'produtos', 'tamanhos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VariacaoPizza $variacaoPizza)
    {
        $validated = $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'tamanho_pizza_id' => [
                'required',
                'exists:tamanhos_pizza,id',
                Rule::unique('variacoes_pizza')
                    ->where(function ($query) use ($request) {
                        return $query->where('produto_id', $request->produto_id)
                                    ->where('tamanho_pizza_id', $request->tamanho_pizza_id);
                    })
                    ->ignore($variacaoPizza->id)
            ],
            'preco' => 'required|numeric|min:0.01',
            'estoque' => 'required|integer|min:0',
            'tipo' => 'required|in:salgada,doce'
        ], [
            'tamanho_pizza_id.unique' => 'Já existe uma variação para este produto com o mesmo tamanho.'
        ]);

        $variacaoPizza->update($validated);

        return redirect()->route('pizzas.index')
            ->with('success', 'Variação atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VariacaoPizza $variacaoPizza)
    {
        try {
            $variacaoPizza->delete();
            return redirect()->route('pizzas.index')
                ->with('success', 'Variação excluída com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao excluir variação: ' . $e->getMessage());
        }
    }

    /**
     * API: Get variations by product ID
     */
    public function getByProduto($produtoId)
    {
        $variacoes = VariacaoPizza::with('tamanhoPizza')
            ->where('produto_id', $produtoId)
            ->get();

        return response()->json($variacoes);
    }
}