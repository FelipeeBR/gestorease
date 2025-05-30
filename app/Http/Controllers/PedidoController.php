<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comanda;
use App\Models\Caixa;

class PedidoController extends Controller
{
    public function index()
    {
        $comandas = Comanda::query()
        ->where('status', 'aberta') 
        ->when(request('id'), function($query, $id) {
            $query->where('id', $id);
        })
        ->when(request('tipo'), function($query, $tipo) {
            $query->where('tipo', $tipo);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(15);
        return view('pedidos.index', compact('comandas'));
    }
}
