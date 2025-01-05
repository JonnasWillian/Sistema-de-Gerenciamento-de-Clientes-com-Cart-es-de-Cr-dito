<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Cartoes;
use App\Http\Controllers\Users;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/criarUsuarios', [Users::class, 'store']);
Route::put('/editarUsuarios/{id}', [Users::class, 'update']);
Route::delete('/deletarUsuarios/{id}', [Users::class, 'destroy']); 

Route::get('/listar', [Cartoes::class, 'view'])->name('api');
Route::post('/criarCartoes', [Cartoes::class, 'store']);
Route::put('/editarCartoes/{id}', [Cartoes::class, 'update']);
Route::delete('/deletarCartoes/{id}', [Cartoes::class, 'destroy']);