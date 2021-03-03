<?php

use App\Http\Controllers\BangsalController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\SisaPagiController;
use App\Http\Controllers\SisaSiangController;
use App\Http\Controllers\SisaMalamController;
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
Route::get('/pasienBangsal/{id_bangsal}', [PasienController::class, 'showBangsal']);
Route::post('/pasien', [PasienController::class, 'store']);
Route::put('/pasien/{id}', [PasienController::class, 'update']);
Route::delete('/pasien/{id}', [PasienController::class, 'destroy']);

Route::get('/sisa/pagi', [SisaPagiController::class, 'index']);
Route::get('/sisa/pagi/{id}', [SisaPagiController::class, 'show']);
Route::get('/sisa/pasienPagi/{id_pasien}', [SisaPagiController::class, 'showPagi']);
Route::post('/sisa/pagi', [SisaPagiController::class, 'store']);
Route::put('/sisa/pagi/{id}', [SisaPagiController::class, 'update']);
Route::delete('/sisa/pagi/{id}', [SisaPagiController::class, 'destroy']);

Route::get('/sisa/siang', [SisaSiangController::class, 'index']);
Route::get('/sisa/siang/{id}', [SisaSiangController::class, 'show']);
Route::get('/sisa/pasienSiang/{id_pasien}', [SisaMalamController::class, 'showSiang']);
Route::post('/sisa/siang', [SisaSiangController::class, 'store']);
Route::put('/sisa/siang/{id}', [SisaSiangController::class, 'update']);
Route::delete('/sisa/siang/{id}', [SisaSiangController::class, 'destroy']);

Route::get('/sisa/malam', [SisaMalamController::class, 'index']);
Route::get('/sisa/malam/{id}', [SisaMalamController::class, 'show']);
Route::get('/sisa/pasienMalam/{id_pasien}', [SisaMalamController::class, 'showMalam']);
Route::post('/sisa/malam', [SisaMalamController::class, 'store']);
Route::put('/sisa/malam/{id}', [SisaMalamController::class, 'update']);
Route::delete('/sisa/malam/{id}', [SisaMalamController::class, 'destroy']);
