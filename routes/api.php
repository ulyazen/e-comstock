<?php

use App\Http\Controllers\BangsalController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\SisaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/bangsal', [BangsalController::class, 'index']);
Route::get('/bangsal/{id}', [BangsalController::class, 'show']);
Route::post('/bangsal', [BangsalController::class, 'store']);
Route::put('/bangsal/{id}', [BangsalController::class, 'update']);
Route::delete('/bangsal/{id}', [BangsalController::class, 'destroy']);

Route::get('/pasien', [PasienController::class, 'index']);
Route::get('/pasien/{id}', [PasienController::class, 'show']);
Route::post('/pasien', [PasienController::class, 'store']);
Route::put('/pasien/{id}', [PasienController::class, 'update']);
Route::delete('/pasien/{id}', [PasienController::class, 'destroy']);

Route::get('/sisa', [SisaController::class, 'index']);
Route::get('/sisa/{id}', [SisaController::class, 'show']);
Route::post('/sisa', [SisaController::class, 'store']);
Route::put('/sisa/{id}', [SisaController::class, 'update']);
Route::delete('/sisa/{id}', [SisaController::class, 'destroy']);
