<?php

namespace App\Http\Controllers;

use App\Models\VariacaoPizza;
use App\Models\TamanhoPizza;
use App\Models\Produto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cache;

class VariacaoPizzaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /*$variacoes = VariacaoPizza::with(['produto', 'tamanhoPizza'])
            ->orderBy('produto_id')
            ->orderBy('tamanho_pizza_id')
            ->paginate(15);*/
        $query = VariacaoPizza::query();

        if ($request->filled('produto')) {
            $query->whereHas('produto', function ($q) use ($request) {
                $q->where('nome', 'like', '%' . $request->produto . '%');
            });
        }
    
        if ($request->filled('tamanho')) {
            $query->where('tamanho_pizza_id', $request->tamanho);
        }
    
        if ($request->filled('tipo')) {
            $query->where('tipo', 'like', '%' . $request->tipo . '%');
        }
    
        if ($request->filled('preco')) {
            $query->where('preco', $request->preco);
        }
    
        if ($request->filled('atualizado_em')) {
            $dataFormatada = \Carbon\Carbon::createFromFormat('d/m/Y', $request->atualizado_em)->format('Y-m-d');
            $query->whereDate('updated_at', $dataFormatada);
        }
    
        $variacoes = $query->paginate(15);
        $tamanhos = TamanhoPizza::all();

        return view('pizzas.index', compact('variacoes', 'tamanhos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categoria_pizza = Categoria::where('nome', 'Pizza')->first();
        if (!$categoria_pizza) {
            return back()->with('error', 'Categoria "pizza" não encontrada');
        }
        $produtos = Produto::where('categoria_id', $categoria_pizza->id)->get();
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
    public function edit($id)
    {
        $variacaoPizza = VariacaoPizza::findOrFail($id);
        $categoria_pizza = Cache::remember('categoria_pizza', now()->addDay(), function () {
            return Categoria::where('nome', 'pizza')->firstOrFail();
        });
        
        $produtos = Produto::where('categoria_id', $categoria_pizza->id)
            ->orderBy('nome')
            ->get();
        $tamanhos = TamanhoPizza::all();
        
        return view('pizzas.edit', compact('variacaoPizza', 'produtos', 'tamanhos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $variacaoPizza = VariacaoPizza::findOrFail($id);
        $validated = $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'tamanho_pizza_id' => 'required|exists:tamanho_pizza,id',
            'preco' => 'required|numeric|min:0.01',
            'tipo' => 'required|in:salgada,doce'
        ]);

        $variacaoPizza->update($validated);

        return redirect()->route('pizzas.index')
            ->with('success', 'Variação atualizada com sucesso!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $variacaoPizza = VariacaoPizza::findOrFail($id);
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