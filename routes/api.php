<?php

use App\Http\Controllers\ComposerController;
use App\Http\Controllers\CompositionController;
use App\Http\Controllers\CompositionFileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

    Route::get('compositions', [CompositionController::class, 'index']);
    Route::prefix('composition')->group(function () {

        Route::get('{composition}', [CompositionController::class, 'get']);
        Route::post('create', [CompositionController::class, 'create']);
        Route::patch('{composition}', [CompositionController::class, 'update']);
        Route::delete('{composition}', [CompositionController::class, 'delete']);

        Route::get('{composition}/files', [CompositionFileController::class, 'getAll']);
        Route::post('{composition}/files/add', [CompositionFileController::class, 'create']);

        Route::prefix('file')->group(function () {
            Route::get('{file}', [CompositionFileController::class, 'index'])->name('composition.file');
            Route::delete('{file}', [CompositionFileController::class, 'delete']);
        });
    });

    Route::prefix('composers')->group(function () {
        Route::get('{composer}', [ComposerController::class, 'get']);
        Route::get('', [ComposerController::class, 'index']);
        Route::post('create', [ComposerController::class, 'create']);
        Route::patch('{composer}', [ComposerController::class, 'update']);
        Route::delete('{composer}', [ComposerController::class, 'delete']);
    });
});
