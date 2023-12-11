<?php

use App\Http\Controllers\CompositionController;
use Illuminate\Http\Request;
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

Route::prefix('composition')->middleware(['auth:sanctum'])->group(function () {
    Route::post('/create', [CompositionController::class, 'create']);
    Route::get('/{composition}', function (\App\Models\Composition $composition) {
        return $composition->with('composers')->with('files')->get();
    });
});
