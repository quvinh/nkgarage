<?php

use App\Http\Controllers\CRUD\ShelvesController;
use App\Http\Controllers\CRUD\WarehouseController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('admin')->group(function() {
    Route::get('/');

    Route::get('/warehouse', [WarehouseController::class, 'index']);
    Route::get('/warehouse/add', [WarehouseController::class, 'create']);
    Route::post('/warehouse/store', [WarehouseController::class, 'store']);
    Route::get('/warehouse/show/{id}', [WarehouseController::class, 'edit']);
    Route::put('/warehouse/update/{id}', [WarehouseController::class, 'update']);
    Route::delete('/warehouse/delete/{id}', [WarehouseController::class, 'destroy']);

    Route::get('/shelf', [ShelvesController::class, 'index']);
    Route::get('/shelf/add', [ShelvesController::class, 'create']);
    Route::post('/shelf/store', [ShelvesController::class, 'store']);
    Route::get('/shelf/show/{id}', [ShelvesController::class, 'edit']);
    Route::put('/shelf/update/{id}', [ShelvesController::class, 'update']);
    Route::delete('/shelf/delete/{id}', [ShelvesController::class, 'destroy']);
});
