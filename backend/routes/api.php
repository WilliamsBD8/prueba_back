<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Salones\SalonsController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\AuthController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('salones')->group(function () {
    Route::get('/',[ SalonsController::class, 'getAll']);
    Route::post('/create',[ SalonsController::class, 'create']);
    Route::post('/edit',[ SalonsController::class, 'edit']);
    Route::get('/delete/{id}',[ SalonsController::class, 'delete']);
});

Route::prefix('cursos')->group(function () {
    Route::get('/',[ CursosController::class, 'getAll']);
    Route::post('/create',[ CursosController::class, 'create']);
    Route::post('/edit',[ CursosController::class, 'edit']);
    Route::get('/delete/{id}',[ CursosController::class, 'delete']);
});

Route::prefix('schedule')->group(function () {
    Route::get('/{id}',[ ScheduleController::class, 'getAll']);
    Route::post('/create',[ ScheduleController::class, 'create']);
    Route::post('/edit',[ ScheduleController::class, 'edit']);
    Route::get('/delete/{id}',[ ScheduleController::class, 'delete']);
});

Route::prefix('add-member')->group(function () {
    Route::get('/{id}',[ MemberController::class, 'getAll']);
    Route::post('/create',[ MemberController::class, 'create']);
    Route::get('/delete/{id}',[ MemberController::class, 'delete']);
});

Route::prefix('historial')->group(function () {
    Route::get('/{id}',[ HistorialController::class, 'getAll']);
});

Route::prefix('login')->group(function () {
    Route::post('/',[ AuthController::class, 'login']);
    Route::get('/user',[ AuthController::class, 'user'])->middleware('auth:sanctum');
});

