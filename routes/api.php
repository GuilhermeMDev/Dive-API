<?php

use App\Http\Controllers\DiveTableController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//dive-table
//Route::apiResource('dive-table', DiveTableController::class);

Route::get('/dive-table', [DiveTableController::class, 'index']);
Route::get('/dive-table-letter', [DiveTableController::class, 'repetitiveGroup']);
Route::get('/surface-interval', [DiveTableController::class, 'surfaceInterval']);
Route::get('/successive-dive', [DiveTableController::class, 'calculateSuccessiveDive']);

