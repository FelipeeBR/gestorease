<?php

namespace App\Http\Controllers;

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
        return view('home', compact('countUsers', 'countProdutos'));
    }
}
