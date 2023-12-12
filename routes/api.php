<?php

use App\Http\Controllers\CompositionController;
use App\Http\Controllers\CompositionFileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('compositions', [CompositionController::class, 'paging']);
    Route::prefix('composition')->group(function () {

        Route::post('create', [CompositionController::class, 'create']);
        Route::get('{composition}', [CompositionController::class, 'get']);
        Route::delete('{composition}', [CompositionController::class, 'delete']);
        Route::patch('{composition}', [CompositionController::class, 'update']);

        Route::get('{composition}/files', [CompositionFileController::class, 'getAll']);
        Route::post('{composition}/files/add', [CompositionFileController::class, 'create']);

        Route::prefix('file')->group(function () {
            Route::get('{file}', [CompositionFileController::class, 'index'])->name('composition.file');
            Route::delete('{file}', [CompositionFileController::class, 'delete']);
        });
    });
});
