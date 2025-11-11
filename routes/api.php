<?php

use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\TypeVehicleApiController;
use App\Http\Controllers\VehicleApiController;
use App\Http\Controllers\VisitApiController;
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




Route::apiResource('car', VehicleApiController::class);
Route::apiResource('visit', VisitApiController::class);
Route::get('fizzBuzz', [VisitApiController::class, 'fizzBuzz']); 
Route::get('anagram', [VisitApiController::class, 'anagram']); 
Route::get('number_prime', [VisitApiController::class, 'number_prime']); 
Route::post('polygon', [VisitApiController::class, 'polygon']); 
Route::get('ratio', [VisitApiController::class, 'ratio']); 
Route::get('counting-words', [VisitApiController::class, 'countingWords']); 
Route::get('matriz', [VisitApiController::class, 'matriz']);
Route::get('matriz-table', [VisitApiController::class, 'matrizTable']);
Route::get('decimal-binary',[VisitApiController::class, 'decimalTobinary']);
Route::get('morse-code',[VisitApiController::class, 'morseCode']);
Route::apiResource('type-vehicle',TypeVehicleApiController::class);


Route::post('/login', [AuthApiController::class, 'login']);

Route::post('/logout', [AuthApiController::class, 'logout'])->middleware('auth:sanctum');