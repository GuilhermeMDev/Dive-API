<?php

use App\Http\Controllers\DiveTableController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//dive-table
//Route::apiResource('dive-table', DiveTableController::class);

Route::get('/dive-table', [DiveTableController::class, 'fullNoDescompressiveDiveTable']);
Route::get('/no-descompressive-dive', [DiveTableController::class, 'noDescompressiveDive']);
Route::get('/repetitive-group', [DiveTableController::class, 'repetitiveGroup']);
Route::get('/surface-interval', [DiveTableController::class, 'surfaceInterval']);
Route::get('/successive-dive', [DiveTableController::class, 'calculateSuccessiveDive']);

