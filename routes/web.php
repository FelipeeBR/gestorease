<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProdutoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['verifica.role:admin'])->group(function () {
    Route::resource('users', UserController::class);
});

Route::resource('produtos', ProdutoController::class);

//Route::resource('users', UserController::class);
//Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
//Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
