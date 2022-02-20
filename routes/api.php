<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CRUD\Auth\PermissionController;
use App\Http\Controllers\CRUD\Auth\RolesController;
use App\Http\Controllers\CRUD\CategoryController;
use App\Http\Controllers\CRUD\ExportController;
use App\Http\Controllers\CRUD\ShelvesController;
use App\Http\Controllers\CRUD\WarehouseController;
use App\Http\Controllers\CRUD\Detail_ItemController;
use App\Http\Controllers\CRUD\NotificationController;
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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::post('/change-pass', [AuthController::class, 'changePassWord']);
});

Route::prefix('admin')->group(function() {
    Route::get('/');

    Route::get('/notification', [NotificationController::class, 'index']);
    Route::get('/notification/add', [NotificationController::class, 'create']);
    Route::post('/notification/store', [NotificationController::class, 'store']);
    Route::get('/notification/show/{id}', [NotificationController::class, 'edit']);
    Route::put('/notification/update/{id}', [NotificationController::class, 'update']);
    Route::delete('/notification/delete/{id}', [NotificationController::class, 'destroy']);

    Route::get('/detail_item', [Detail_ItemController::class, 'index']);
    Route::get('/detail_item/add', [Detail_ItemController::class, 'create']);
    Route::post('/detail_item/store', [Detail_ItemController::class, 'store']);
    Route::get('/detail_item/show/{id}', [Detail_ItemController::class, 'edit']);
    Route::put('/detail_item/update/{id}', [Detail_ItemController::class, 'update']);
    Route::delete('/detail_item/delete/{id}', [Detail_ItemController::class, 'destroy']);


    Route::get('/export', [ExportController::class, 'index']);
    Route::get('/export/add', [ExportController::class, 'create']);
    Route::post('/export/store', [ExportController::class, 'store']);
    Route::get('/export/show/{id}', [ExportController::class, 'edit']);
    Route::put('/export/update/{id}', [ExportController::class, 'update']);
    Route::delete('/export/delete/{id}', [ExportController::class, 'destroy']);

    Route::get('/category', [CategoryController::class, 'index']);
    Route::get('/category/add', [CategoryController::class, 'create']);
    Route::post('/category/store', [CategoryController::class, 'store']);
    Route::get('/category/show/{id}', [CategoryController::class, 'edit']);
    Route::put('/category/update/{id}', [CategoryController::class, 'update']);
    Route::delete('/category/delete/{id}', [CategoryController::class, 'destroy']);


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

    Route::prefix('auth_model')->group(function() {
        Route::get('/permission', [PermissionController::class, 'index']);
        Route::get('/permission/add', [PermissionController::class, 'create']);
        Route::post('/permission/store', [PermissionController::class, 'store']);
        Route::get('/permission/show/{id}', [PermissionController::class, 'edit']);
        Route::put('/permission/update/{id}', [PermissionController::class, 'update']);
        Route::delete('/permission/delete/{id}', [PermissionController::class, 'destroy']);

        Route::get('/roles', [RolesController::class, 'index']);
        Route::get('/roles/add', [RolesController::class, 'create']);
        Route::post('/roles/store', [RolesController::class, 'store']);
        Route::get('/roles/show/{id}', [RolesController::class, 'edit']);
        Route::put('/roles/update/{id}', [RolesController::class, 'update']);
        Route::delete('/roles/delete/{id}', [RolesController::class, 'destroy']);
    });
});
