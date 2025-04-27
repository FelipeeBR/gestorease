<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\VariacaoPizzaController;
use App\Http\Controllers\CategoriaController;
use App\Models\Categoria;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['verifica.role:admin'])->group(function () {
    Route::resource('users', UserController::class);
});

Route::middleware(['verifica.role:gerente'])->group(function () {
    Route::resource('produtos', ProdutoController::class);
});

Route::resource('mesas', MesaController::class);
Route::resource('pizzas', VariacaoPizzaController::class);
Route::resource('categorias', CategoriaController::class);

//Route::resource('users', UserController::class);
//Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
//Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
