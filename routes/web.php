<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\VariacaoPizzaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\BordaPizzaController;
use App\Http\Controllers\CaixaController;
use App\Http\Controllers\ComandaController;
use App\Http\Controllers\ItemComandaController;
use App\Models\Categoria;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth.role:admin'])->group(function () {
    Route::resource('users', UserController::class);
});

Route::middleware(['auth.role:gerente'])->group(function () {
    Route::resource('produtos', ProdutoController::class);
});

Route::middleware(['auth.role:garcom'])->group(function () {
    Route::resource('mesas', MesaController::class);
});

Route::prefix('caixa')->name('caixa.')->middleware(['auth.role:caixa'])->group(function () {
    Route::resource('comanda', ComandaController::class);
});

Route::post('caixa/comanda/{comanda}', [ItemComandaController::class, 'store'])->name('caixa.comanda.item.store');
Route::delete('caixa/comanda/{comanda}', [ItemComandaController::class, 'destroy'])->name('caixa.comanda.item.destroy');
Route::post('caixa/comanda/{comanda}/fechar', [ComandaController::class, 'fechar'])->name('caixa.comanda.fechar');
Route::post('caixa/comanda/{comanda}/cancelar', [ComandaController::class, 'cancelar'])->name('caixa.comanda.cancelar');

Route::resource('pizzas', VariacaoPizzaController::class);
Route::resource('categorias', CategoriaController::class);
Route::resource('bordas-pizza', BordaPizzaController::class);
Route::resource('caixa', CaixaController::class);
Route::post('/caixa/{caixa}/fechar', [CaixaController::class, 'fechar'])->name('caixa.fechar');

//Route::resource('users', UserController::class);
//Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
//Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
