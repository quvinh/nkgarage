<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CRUD\Auth\PermissionController;
use App\Http\Controllers\CRUD\Auth\RolesController;
use App\Http\Controllers\CRUD\DetailitemController;
use App\Http\Controllers\CRUD\ImportController;
use App\Http\Controllers\CRUD\ItemController;
use App\Http\Controllers\CRUD\ShelvesController;
use App\Http\Controllers\CRUD\SuppliersController;
use App\Http\Controllers\CRUD\WarehouseController;
use App\Models\Import;
use App\Models\Suppliers;
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


    /*************Warehouse**************/
    Route::get('/warehouse', [WarehouseController::class, 'index']);
    Route::get('/warehouse/add', [WarehouseController::class, 'create']);
    Route::post('/warehouse/store', [WarehouseController::class, 'store']);
    Route::get('/warehouse/show/{id}', [WarehouseController::class, 'edit']);
    Route::put('/warehouse/update/{id}', [WarehouseController::class, 'update']);
    Route::delete('/warehouse/delete/{id}', [WarehouseController::class, 'destroy']);
    Route::get('/warehouse/shelfWarehouse/{id}', [WarehouseController::class, 'shelfWarehouse']);
    Route::get('/warehouse/itemShelf/{id}/{shelf_id}', [WarehouseController::class, 'itemShelf']);
    Route::get('/warehouse/itemWarehouse/{id}', [WarehouseController::class, 'itemWarehouse']);
    Route::get('/warehouse/countWarehouse', [WarehouseController::class, 'countWarehouse']);
    Route::get('/warehouse/amountShelf/{id}', [WarehouseController::class, 'amountShelf']);


    /*************Shelf*************/
    Route::get('/shelf', [ShelvesController::class, 'index']);
    Route::get('/shelf/add', [ShelvesController::class, 'create']);
    Route::post('/shelf/store/{id}', [ShelvesController::class, 'store']);
    Route::get('/shelf/show/{id}', [ShelvesController::class, 'edit']);
    Route::put('/shelf/update/{id}', [ShelvesController::class, 'update']);
    Route::delete('/shelf/delete/{id}', [ShelvesController::class, 'destroy']);
    Route::delete('/shelf/delete-item/{id}', [ShelvesController::class, 'destroyItem']);
    Route::get('/shelf/amountItem/{id}', [ShelvesController::class, 'amountItem']);


    //**********Import**************/
    Route::get('/import',[ImportController::class, 'index']);
    Route::get('/import/add', [ImportController::class, 'create']);
    Route::post('/import/store', [ImportController::class, 'store']);
    Route::get('/import/show/{id}', [ImportController::class, 'edit']);
    Route::put('/import/update/{id}', [ImportController::class, 'update']);
    Route::put('/import/updateStatus/{id}', [ImportController::class, 'updateStatus']);
    Route::post('/import/updateAmountItem/{id}', [ImportController::class, 'updateAmountItem']);
    Route::delete('/import/delete/{id}', [ImportController::class, 'destroy']);


    /**************Item***************/
    Route::get('/items',[ItemController::class, 'index']);
    Route::get('/items/add', [ItemController::class, 'create']);
    Route::post('/items/store', [ItemController::class, 'store']);
    Route::get('/items/show/{id}', [ItemController::class, 'edit']);
    Route::put('/items/update/{id}', [ItemController::class, 'update']);
    Route::delete('/items/delete/{id}', [ItemController::class, 'destroy']);
    Route::get('/items/searchItem/{name}/{id}', [ItemController::class, 'searchitem']);
    Route::get('/items/amountItem/{id}/{warehouse_id}/{shelf_id}', [ItemController::class, 'amountItemsplit']);

    /*************Detail_item**************/
    Route::get('/detail_item',[DetailitemController::class, 'index']);
    Route::get('/detail_item/add', [DetailitemController::class, 'create']);
    Route::post('/detail_item/store', [DetailitemController::class, 'store']);
    Route::get('/detail_item/show/{id}', [DetailitemController::class, 'edit']);
    Route::put('/detail_item/update/{id}', [DetailitemController::class, 'update']);
    Route::delete('/detail_item/delete/{id}', [DetailitemController::class, 'destroy']);



    /****************Suppliers***************/
    Route::get('/suppliers',[SuppliersController::class, 'index']);
    Route::get('/suppliers/add', [SuppliersController::class, 'create']);
    Route::post('/suppliers/store', [SuppliersController::class, 'store']);
    Route::get('/suppliers/show/{id}', [SuppliersController::class, 'edit']);
    Route::put('/suppliers/update/{id}', [SuppliersController::class, 'update']);
    Route::delete('/suppliers/delete/{id}', [SuppliersController::class, 'destroy']);

    Route::prefix('auth_model')->group(function() {

        /************Permission*************/
        Route::get('/permission', [PermissionController::class, 'index']);
        Route::get('/permission/add', [PermissionController::class, 'create']);
        Route::post('/permission/store', [PermissionController::class, 'store']);
        Route::get('/permission/show/{id}', [PermissionController::class, 'edit']);
        Route::put('/permission/update/{id}', [PermissionController::class, 'update']);
        Route::delete('/permission/delete/{id}', [PermissionController::class, 'destroy']);
        
        /***************Roles****************/
        Route::get('/roles', [RolesController::class, 'index']);
        Route::get('/roles/add', [RolesController::class, 'create']);
        Route::post('/roles/store', [RolesController::class, 'store']);
        Route::get('/roles/show/{id}', [RolesController::class, 'edit']);
        Route::put('/roles/update/{id}', [RolesController::class, 'update']);
        Route::delete('/roles/delete/{id}', [RolesController::class, 'destroy']);
    });
});
