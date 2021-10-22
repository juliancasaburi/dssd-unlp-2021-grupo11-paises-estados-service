<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GeographicController;

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

Route::get('topEstados', [GeographicController::class, 'getTopEstados']);
Route::get('topIdiomas', [GeographicController::class, 'getTopIdiomas']);
Route::get('topContinente', [GeographicController::class, 'getTopContinente']);
Route::get('continentesNoSeExporta', [GeographicController::class, 'getContinentesHaciaDondeNoSeExporta']);
Route::get('paisesNoSeExporta', [GeographicController::class, 'getPaisesHaciaDondeNoSeExporta']);