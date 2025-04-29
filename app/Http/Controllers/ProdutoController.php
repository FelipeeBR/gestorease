<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Categoria;

class ProdutoController extends Controller
{
    public function index(Request $request)
    {
        $query = Produto::query();
        $categorias = Categoria::all();

        if($request->filled('nome')) {
            $query->where('nome', 'like', '%' . $request->nome . '%');
        }
        if($request->filled('categoria')) {
            $query->where('categoria_id', $request->categoria);
        }
        if($request->filled('preco_venda')) {
            $query->where('preco_venda', $request->preco_venda);
        }
        if($request->filled('atualizado_em')) {
            $dataFormatada = \Carbon\Carbon::createFromFormat('d/m/Y', $request->atualizado_em, 'America/Sao_Paulo')
                ->timezone('UTC') // converte para UTC
                ->format('Y-m-d');
            $query->whereDate('updated_at', $dataFormatada);
        }

        $produtos = $query->paginate(15);
        return view('produtos.index', compact('produtos', 'categorias'));
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
            'preco_venda' => 'numeric|min:0.00', 
            'categoria_id' => 'required|exists:categorias,id',  
            'descricao' => 'nullable|string|max:500',  
            'quantidade_estoque' => 'required|integer|min:0'  
        ]);

        Produto::create($validated);

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
            'preco_venda' => 'numeric|min:0.00',
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
