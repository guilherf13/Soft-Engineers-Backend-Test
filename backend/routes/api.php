<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//Rotas versionadas.
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::post('/debts/import', [DebtController::class, 'importCsv']);
});

Route::fallback(function () {
    return response()->json([
        'success' => false,
        'message' => 'Rota não encontrada.',
    ], 404);
});

