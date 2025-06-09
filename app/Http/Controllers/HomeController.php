<?php

namespace App\Http\Controllers;

use App\Models\Comanda;
use App\Models\User;
use App\Models\Produto;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $countUsers = User::count();
        $countProdutos = Produto::count();
        $produtosEstoque = Produto::where('quantidade_estoque', '<', 10)->get();
        $vendasFinalizadas = Comanda::where('status', 'Fechada')->get();
        $vendasAbertas = Comanda::where('status', 'Aberta')->count();

        return view('home', compact('countUsers', 'countProdutos', 'produtosEstoque', 'vendasFinalizadas', 'vendasAbertas'));
    }
}
