<?php

namespace App\Http\Controllers;

use App\Models\Caixa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comanda;

class CaixaController extends Controller
{
    // Listar todos os caixas
    public function index()
    {
        $caixas = Caixa::with('user')->latest()->get();
        return view('caixa.index', compact('caixas'));
    }

    // Mostrar formulário para abrir novo caixa
    public function create()
    {
        if (Caixa::whereNull('data_fechamento')->exists()) {
            return redirect()->route('caixa.index')
                ->with('error', 'Já existe um caixa aberto. Feche-o antes de abrir outro.');
        }
        
        return view('caixa.create');
    }

    // Armazenar novo caixa
    public function store(Request $request)
    {
        $request->validate([
            'saldo_inicial' => 'required|numeric|min:0',
            'observacoes' => 'nullable|string'
        ], [
            'saldo_inicial.required' => 'O campo Saldo Inicial é obrigatório.'
        ]);

        $caixa = Caixa::create([
            'data_abertura' => now(),
            'saldo_inicial' => $request->saldo_inicial,
            'user_id' => Auth::id(),
            'observacoes' => $request->observacoes
        ]);

        return redirect()->route('caixa.show', $caixa->id)
            ->with('success', 'Caixa aberto com sucesso!');
    }

    // Mostrar um caixa específico
    public function show($id)
    {
        $caixa = Caixa::with('user')->findOrFail($id);
        $comandas = Comanda::where('caixa_id', $id)->orderBy('created_at', 'desc')->get();
        return view('caixa.show', compact('caixa','comandas'));
    }

    // Fechar o caixa
    public function fechar(Request $request, Caixa $caixa)
    {
        if (!$caixa->isAberto()) {
            return back()->with('error', 'Este caixa já está fechado.');
        }

        $request->merge([
            'saldo_final' => str_replace(['.', ','], ['', '.'], $request->saldo_final),
            'total_vendas' => str_replace(['.', ','], ['', '.'], $request->total_vendas)
        ]);

        $request->validate([
            'saldo_final' => 'required|numeric|min:0',
            'total_vendas' => 'required|numeric|min:0',
            'observacoes' => 'nullable|string'
        ], [
            'saldo_final.required' => 'O campo Saldo Final é obrigatório.',
            'total_vendas.required' => 'O campo Total de Vendas é obrigatório.',
            'total_vendas.min' => 'O campo Total de Vendas deve ser maior ou igual a zero.',
            'saldo_final.min' => 'O campo Saldo Final deve ser maior ou igual a zero.',
            'saldo_final.numeric' => 'O campo Saldo Final deve ser um número.',
            'total_vendas.numeric' => 'O campo Total de Vendas deve ser um número.'
        ]);

        $caixa->update([
            'data_fechamento' => now(),
            'saldo_final' => intval($request->saldo_final),
            'total_vendas' => intval($request->total_vendas),
            'observacoes' => $request->observacoes ?? $caixa->observacoes
        ]);

        return redirect()->route('caixa.index', $caixa->id)
            ->with('success', 'Caixa fechado com sucesso!');
    }

    // Relatório de caixas
    public function relatorio(Request $request)
    {
        $query = Caixa::with('user');

        if ($request->data_inicio) {
            $query->where('data_abertura', '>=', $request->data_inicio);
        }

        if ($request->data_fim) {
            $query->where('data_abertura', '<=', $request->data_fim);
        }

        $caixas = $query->latest()->get();

        return view('caixas.relatorio', compact('caixas'));
    }
}