<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\AuthController;

//Cria um usuario autenticado para teste
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::post('/debts/import', [DebtController::class, 'importCsv']);
});

Route::fallback(function () {
    return response()->json([
        'success' => false,
        'message' => 'Rota não encontrada.',
    ], 404);
});

