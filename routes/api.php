<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CRUD\Auth\DetailUserController;
use App\Http\Controllers\CRUD\Auth\PermissionController;
use App\Http\Controllers\CRUD\Auth\RolesController;
use App\Http\Controllers\CRUD\DetailitemController;
use App\Http\Controllers\CRUD\ImportController;
use App\Http\Controllers\CRUD\ItemController;
use App\Http\Controllers\CRUD\CategoryController;
use App\Http\Controllers\CRUD\DashBoardController;
use App\Http\Controllers\CRUD\ExportController;
use App\Http\Controllers\CRUD\ShelvesController;
use App\Http\Controllers\CRUD\SuppliersController;
use App\Http\Controllers\CRUD\WarehouseController;
use App\Models\Import;
use App\Models\Suppliers;
use App\Http\Controllers\CRUD\Detail_ItemController;
use App\Http\Controllers\CRUD\InventoryController;
use App\Http\Controllers\CRUD\NotificationController;
use App\Http\Controllers\CRUD\TransferController;
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

header('Access-Control-Allow-Origin: http://127.0.0.1:8000/');
//Access-Control-Allow-Origin: *
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');

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
    Route::get('/users', [AuthController::class, 'users']);
    Route::get('/get-user/{id}', [AuthController::class, 'getUser']);
    Route::post('/update-user/{id}', [AuthController::class, 'updateUser']);
});

Route::prefix('admin')->middleware('checklogin')->group(function () {

    // Route::group(['middleware' => ['role:admin|Tổng giám đốc|Giám đốc|Trưởng kế toán|Kế toán|Thủ kho']], function () {
    Route::get('/dashboard/tonKho/{id}', [DashBoardController::class, 'tonKho']);
    Route::get('/dashboard/tongTonKho', [DashBoardController::class, 'tongTonKho']);
    Route::get('/dashboard/export/{year}', [DashBoardController::class, 'export']);
    Route::get('/dashboard/import/{year}', [DashBoardController::class, 'import']);
    Route::get('/dashboard/importByWarehouse/{id}/{year}', [DashBoardController::class, 'importByWarehouse']);
    Route::get('/dashboard/exportByWarehouse/{id}/{year}', [DashBoardController::class, 'exportByWarehouse']);

    Route::get('/export', [ExportController::class, 'index']);
    Route::get('/export/indexStatus', [ExportController::class, 'indexStatus']);
    Route::get('/export/add', [ExportController::class, 'create']);
    Route::post('/export/store', [ExportController::class, 'store']);
    Route::get('/export/show/{id}', [ExportController::class, 'edit']);
    Route::put('/export/update/{id}', [ExportController::class, 'update']);
    Route::put('/export/updateStatus/{id}', [ExportController::class, 'updateStatus']);
    Route::put('/export/dStatus/{id}', [ExportController::class, 'dStatus']);
    Route::delete('/export/delete/{id}', [ExportController::class, 'destroy']);

    Route::get('/import', [ImportController::class, 'index']);
    Route::get('/import/indexStatus', [ImportController::class, 'indexStatus']);
    Route::get('/import/add', [ImportController::class, 'create']);
    Route::post('/import/store', [ImportController::class, 'store']);
    Route::get('/import/show/{id}', [ImportController::class, 'edit']);
    Route::put('/import/update/{id}', [ImportController::class, 'update']);
    Route::get('/import/indexStatus', [ExportController::class, 'indexStatus']);
    Route::put('/import/updateStatus/{id}', [ImportController::class, 'updateStatus']);
    Route::put('/import/dStatus/{id}', [ImportController::class, 'dStatus']);
    Route::post('/import/updateAmountItem/{id}', [ImportController::class, 'updateAmountItem']);
    Route::delete('/import/delete/{id}', [ImportController::class, 'destroy']);


    Route::get('/category', [CategoryController::class, 'index']);
    Route::get('/shelf', [ShelvesController::class, 'index']);
    Route::get('/items/searchItem/{id}', [ItemController::class, 'searchItem']);
    Route::get('/warehouse', [WarehouseController::class, 'index']);
    Route::get('/suppliers', [SuppliersController::class, 'index']);

    /**************Notification************/
    Route::get('/notification', [NotificationController::class, 'index']);
    Route::get('/notification/showNotification/{id}', [NotificationController::class, 'showNotification']);
    Route::get('/notification/showListItemById/{id}', [NotificationController::class, 'showListItemById']);
    Route::post('/notification/store', [NotificationController::class, 'store']);

    /*************Transfer*************/
    Route::get('/transfer', [TransferController::class, 'index']);
    Route::get('/transfer/add', [TransferController::class, 'create']);
    Route::post('/transfer/store', [TransferController::class, 'store']);
    Route::get('/transfer/show/{id}', [TransferController::class, 'edit']);
    Route::put('/transfer/update/{id}', [TransferController::class, 'update']);
    Route::delete('/transfer/delete/{id}', [TransferController::class, 'destroy']);
    Route::put('/transfer/updateStatus/{id}', [TransferController::class, 'updateStatus']);
    Route::put('/transfer/dStatus/{id}', [TransferController::class, 'dStatus']);

    Route::get('/inventory/showHistoryExport/{id}', [InventoryController::class, 'showHistoryExport']);
    Route::get('/inventory/showHistoryImport/{id}', [InventoryController::class, 'showHistoryImport']);
    Route::get('/inventory/showHistoryTransfer/{id}', [InventoryController::class, 'showHistoryTransfer']);
    Route::get('/inventory/showCodeExport', [InventoryController::class, 'showCodeExport']);
    Route::get('/inventory/showCodeImport', [InventoryController::class, 'showCodeImport']);
    Route::get('/inventory/showCodeTransfer', [InventoryController::class, 'showCodeTransfer']);
    // });


    // Route::group(['middleware' => ['role:admin|ceo|president|chiefAccountant']], function () {
    // Route::get('/');

    Route::post('/detail_user/store/{id}', [DetailUserController::class, 'store']);
    Route::get('/detail_user/show/{id}', [DetailUserController::class, 'edit']);
    Route::put('/detail_user/update/{id}', [DetailUserController::class, 'update']);
    Route::delete('/detail_user/delete/{id}', [DetailUserController::class, 'destroy']);


    Route::get('/notification', [NotificationController::class, 'index']);
    Route::get('/notification/add', [NotificationController::class, 'create']);
    Route::post('/notification/store', [NotificationController::class, 'store']);
    Route::get('/notification/show/{id}', [NotificationController::class, 'edit']);
    Route::put('/notification/update/{id}', [NotificationController::class, 'update']);
    Route::delete('/notification/delete/{id}', [NotificationController::class, 'destroy']);

    Route::get('/inventory', [InventoryController::class, 'index']);
    Route::get('/inventory/add', [InventoryController::class, 'create']);
    Route::post('/inventory/store', [InventoryController::class, 'store']);
    Route::get('/inventory/show/{id}', [InventoryController::class, 'edit']);
    Route::put('/inventory/update/{id}', [InventoryController::class, 'update']);
    Route::delete('/inventory/delete/{id}', [InventoryController::class, 'destroy']);


    // Route::get('/item', [ItemController::class, 'index']);
    // Route::get('/item/add', [ItemController::class, 'create']);
    // Route::post('/item/store', [ItemController::class, 'store']);
    // Route::get('/item/show/{id}', [ItemController::class, 'edit']);
    // Route::put('/item/update/{id}', [ItemController::class, 'update']);
    // Route::delete('/item/delete/{id}', [ItemController::class, 'destroy']);


    Route::get('/detail_item', [Detail_ItemController::class, 'index']);
    Route::get('/detail_item/add', [Detail_ItemController::class, 'create']);
    Route::post('/detail_item/store', [Detail_ItemController::class, 'store']);
    Route::get('/detail_item/show/{id}', [Detail_ItemController::class, 'edit']);
    Route::put('/detail_item/update/{id}', [Detail_ItemController::class, 'update']);
    Route::delete('/detail_item/delete/{id}', [Detail_ItemController::class, 'destroy']);




    // Route::get('/category', [CategoryController::class, 'index']);
    Route::get('/category/add', [CategoryController::class, 'create']);
    Route::post('/category/store', [CategoryController::class, 'store']);
    Route::get('/category/show/{id}', [CategoryController::class, 'edit']);
    Route::put('/category/update/{id}', [CategoryController::class, 'update']);
    Route::delete('/category/delete/{id}', [CategoryController::class, 'destroy']);
    Route::get('/category/itemCategory/{id}', [CategoryController::class, 'itemCategory']);
    Route::get('/category/unitCategory/{id}', [CategoryController::class, 'unitCategory']);

    /*************Warehouse**************/
    // Route::get('/warehouse', [WarehouseController::class, 'index']);

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
    Route::get('/warehouse/sumAmountItem/{id}', [WarehouseController::class, 'sumAmountItem']);
    Route::get('/warehouse/searchItems/{name}/{id}', [WarehouseController::class, 'searchItems']);

    Route::get('/warehouse/kd/{id}/{w_id}/{s_id}', [WarehouseController::class, 'kd']);
    Route::get('/warehouse/amountItemKKD/{id}', [WarehouseController::class, 'amountItemKKD']);
    Route::get('/warehouse/detailItemId/{id}/{shelfid}/{warehouseid}', [WarehouseController::class, 'detailItemId']);
    Route::get('/warehouse/listItem/{id}', [WarehouseController::class, 'listItem']);
    // Route::get('/warehouse/warehouseShow', [WarehouseController::class, 'warehouseShow']);


    /*************Shelf*************/
    // Route::get('/shelf', [ShelvesController::class, 'index']);
    Route::get('/shelf/add', [ShelvesController::class, 'create']);
    Route::post('/shelf/store/{id}', [ShelvesController::class, 'store']);
    Route::get('/shelf/show/{id}', [ShelvesController::class, 'edit']);
    Route::put('/shelf/update/{id}', [ShelvesController::class, 'update']);
    Route::delete('/shelf/delete/{id}', [ShelvesController::class, 'destroy']);
    Route::delete('/shelf/delete-item/{id}', [ShelvesController::class, 'destroyItem']);
    Route::get('/shelf/amountItem/{id}', [ShelvesController::class, 'amountItem']);


    //**********Import**************/
    // Route::group(['middleware' => ['role:admin']], function () {

    // });

    /**************Item***************/
    Route::get('/items', [ItemController::class, 'index']);
    Route::get('/items/add', [ItemController::class, 'create']);
    Route::post('/items/store', [ItemController::class, 'store']);
    Route::get('/items/show/{id}', [ItemController::class, 'edit']);
    Route::put('/items/update/{id}', [ItemController::class, 'update']);
    Route::delete('/items/delete/{id}', [ItemController::class, 'destroy']);
    // Route::get('/items/searchItem/{id}', [ItemController::class, 'searchItem']);
    Route::get('/items/itemInWarehouse', [ItemController::class, 'itemInWarehouse']);

    Route::get('/items/amountItem/{id}/{warehouse_id}/{shelf_id}', [ItemController::class, 'amountItemsplit']);

    /*************Detail_item**************/
    Route::get('/detail_item', [DetailitemController::class, 'index']);
    Route::get('/detail_item/add', [DetailitemController::class, 'create']);
    Route::post('/detail_item/store', [DetailitemController::class, 'store']);
    Route::get('/detail_item/show/{id}', [DetailitemController::class, 'edit']);
    Route::put('/detail_item/update/{id}', [DetailitemController::class, 'update']);
    Route::delete('/detail_item/delete/{id}', [DetailitemController::class, 'destroy']);



    /****************Suppliers***************/
    // Route::get('/suppliers', [SuppliersController::class, 'index']);
    Route::get('/suppliers/add', [SuppliersController::class, 'create']);
    Route::post('/suppliers/store', [SuppliersController::class, 'store']);
    Route::get('/suppliers/show/{id}', [SuppliersController::class, 'edit']);
    Route::put('/suppliers/update/{id}', [SuppliersController::class, 'update']);
    Route::delete('/suppliers/delete/{id}', [SuppliersController::class, 'destroy']);



    /**************Category****************/
    // Route::get('/category', [CategoryController::class, 'index']);
    // Route::get('/category/show/{id}', [CategoryController::class, 'edit']);

    /**************Notification************/
    Route::get('/notification', [NotificationController::class, 'index']);
    Route::get('/notification/showNotification/{id}', [NotificationController::class, 'showNotification']);
    Route::get('/notification/showListItemById/{id}', [NotificationController::class, 'showListItemById']);
    Route::post('/notification/store', [NotificationController::class, 'store']);

    Route::prefix('auth_model')->group(function () {

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

        Route::get('/detail_roles/{id}', [RolesController::class, 'detailRoles']);
        Route::post('/user_roles', [RolesController::class, 'userRoles']);
    });
    // });
});
