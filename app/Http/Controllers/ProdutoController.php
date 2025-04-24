<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Categoria;
use Illuminate\Support\Facades\DB;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::paginate(3);

        return view('produtos.index', compact('produtos'));
    }

    public function create()
    {
        $produto = new Produto();
        $categorias = Categoria::all();
        //$roles = Role::all();
        //return view('produtos.create', compact('produto', 'roles'));
        return view('produtos.create', compact('produto', 'categorias'));
    }

    public function store(Request $request)
    {
        // Validação básica do produto
        $validated = $request->validate([
            'nome' => 'required|string|max:100',
            'preco_base' => 'required|numeric|min:0.01', // Preço base (para o menor tamanho)
            'categoria_id' => 'required|exists:categorias,id',
            'descricao' => 'nullable|string|max:500',
            'tem_variacoes' => 'sometimes|boolean', // Flag para identificar produtos com variações
            'variacoes' => 'required_if:tem_variacoes,true|array',
            'variacoes.*.nome' => 'required_if:tem_variacoes,true|string',
            'variacoes.*.valor' => 'required_if:tem_variacoes,true|string',
            'variacoes.*.preco_adicional' => 'required_if:tem_variacoes,true|numeric|min:0',
            'variacoes.*.estoque' => 'required_if:tem_variacoes,true|integer|min:0'
        ]);

        DB::transaction(function () use ($validated) {
            // Cria o produto base
            $produto = Produto::create([
                'nome' => $validated['nome'],
                'preco_venda' => $validated['preco_base'],
                'categoria_id' => $validated['categoria_id'],
                'descricao' => $validated['descricao'],
                'quantidade_estoque' => 0, // Será calculado somando as variações
                'tem_variacoes' => $validated['tem_variacoes'] ?? false
            ]);

            // Se tiver variações, cria os registros relacionados
            if ($validated['tem_variacoes'] ?? false) {
                $estoqueTotal = 0;
                
                foreach ($validated['variacoes'] as $variacao) {
                    $produto->variacoes()->create([
                        'nome' => $variacao['nome'],
                        'valor' => $variacao['valor'],
                        'preco_adicional' => $variacao['preco_adicional'],
                        'estoque' => $variacao['estoque']
                    ]);
                    
                    $estoqueTotal += $variacao['estoque'];
                }

                // Atualiza o estoque total do produto
                $produto->update(['quantidade_estoque' => $estoqueTotal]);
            }
        });

        return redirect()->route('produtos.index')
                        ->with('success', 'Produto cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $produto = Produto::findOrFail($id);
        $categorias = Categoria::all();
        //$roles = Role::all();
        //return view('produtos.edit', compact('produto', 'roles'));
        return view('produtos.edit', compact('produto', 'categorias'));
    }

    public function update(Request $request, string $id)
    {
        $produto = Produto::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
            'preco_venda' => 'required|numeric|min:0.01',
            'categoria_id' => 'required|exists:categorias,id',
            'descricao' => 'nullable|string|max:255',
            'quantidade_estoque' => 'required|integer|min:0',
        ], [
            'nome.required' => 'O campo Nome é obrigatório.',
            'preco_venda.required' => 'O campo Preço é obrigatório.',
            'categoria_id.required' => 'Categoria obrigatória.',
            'quantidade_estoque.required' => 'Quantidade em estoque obrigatória.',
        ]);

        $produto->nome = $request->input('nome');
        $produto->preco_venda = $request->input('preco_venda');
        $produto->categoria_id = $request->input('categoria_id');
        $produto->descricao = $request->input('descricao');
        $produto->quantidade_estoque = $request->input('quantidade_estoque');

        $produto->save();

        return redirect()->back()->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(string $id)
    {
        $usuario = Produto::findOrFail($id);
        $usuario->delete();

        return redirect()->route('produtos.index')->with('success', 'Produto excluído com sucesso!');
    }

}
