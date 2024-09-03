<?php

use App\Http\Controllers\TransacaoTiposController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransacaoController;
use App\Http\Controllers\MetaController;

Route::get('/api', function () {
    return view('welcome');
});
Route::get('/api/transacao_tipos', [TransacaoTiposController::class, 'index']);

Route::get('/api/transacoes', [TransacaoController::class, 'index']);
Route::get('/api/transacoes/{id}', [TransacaoController::class, 'show']);
Route::post('/api/transacoes', [TransacaoController::class, 'store']);
// Route::delete('/transacoes/{id}', [TransacaoController::class, 'delete']);
// Route::update('/transacoes/{id}', [TransacaoController::class, 'update']);


// Route::get('/metas', [MetaController::class, 'index']);
// Route::get('/metas/{id}', [MetaController::class, 'show']);
// Route::post('/metas', [MetaController::class, 'store']);
// Route::delete('/metas/{id}', [MetaController::class, 'delete']);
// Route::update('/metas/{id}', [MetaController::class, 'update']);


use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/signup', [AuthController::class, 'signup']);