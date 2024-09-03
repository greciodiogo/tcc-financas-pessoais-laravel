<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransacaoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Grupo de rotas protegidas por autenticação
// Route::middleware('auth:sanctum')->group(function () {
    
    // Rota para listar transações
    Route::get('/transacoes', [TransacaoController::class, 'index']);

    // Rota para criar uma nova transação
    Route::post('/transacoes', [TransacaoController::class, 'store']);

    // Rota para exibir uma transação específica
    Route::get('/transacoes/{id}', [TransacaoController::class, 'show']);

    // Rota para atualizar uma transação existente
    Route::put('/transacoes/{id}', [TransacaoController::class, 'update']);

    // Rota para deletar uma transação
    Route::delete('/transacoes/{id}', [TransacaoController::class, 'destroy']);
//});

// Rota de exemplo para testar sem autenticação
Route::get('/status', function () {
    return response()->json(['status' => 'API is working']);
});
