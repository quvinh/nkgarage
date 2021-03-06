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
use App\Http\Controllers\CRUD\ManagerController;
use App\Http\Controllers\CRUD\NotificationController;
use App\Http\Controllers\CRUD\StatisticController;
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

    // Route::group(['middleware' => ['role:admin|T???ng gi??m ?????c|Gi??m ?????c|Tr?????ng k??? to??n|K??? to??n|Th??? kho']], function () {
    Route::get('/dashboard/tonKho/{id}', [DashBoardController::class, 'tonKho']);
    Route::get('/dashboard/exportImport/{id}', [DashBoardController::class, 'exportImport']);
    Route::get('/dashboard/tongTonKho', [DashBoardController::class, 'tongTonKho']);
    Route::get('/dashboard/export/{year}', [DashBoardController::class, 'export']);
    Route::get('/dashboard/import/{year}', [DashBoardController::class, 'import']);
    Route::get('/dashboard/importByWarehouse/{id}/{year}', [DashBoardController::class, 'importByWarehouse']);
    Route::get('/dashboard/exportByWarehouse/{id}/{year}', [DashBoardController::class, 'exportByWarehouse']);

    Route::get('/export', [ExportController::class, 'index']);
    Route::get('/export/indexStatus', [ExportController::class, 'indexStatus'])->middleware(['permission:Xem phi???u xu???t']);
    Route::get('/export/add', [ExportController::class, 'create'])->middleware(['permission:Xem phi???u xu???t']);
    Route::post('/export/store', [ExportController::class, 'store'])->middleware(['permission:Th??m phi???u xu???t']);
    Route::get('/export/show/{id}', [ExportController::class, 'edit'])->middleware(['permission:Xem phi???u xu???t|S???a phi???u xu???t']);
    Route::put('/export/update/{id}', [ExportController::class, 'update'])->middleware(['permission:S???a phi???u xu???t']);
    Route::put('/export/updateStatus/{id}', [ExportController::class, 'updateStatus'])->middleware(['permission:S???a phi???u xu???t|Duy???t phi???u xu???t']);
    Route::put('/export/dStatus/{id}', [ExportController::class, 'dStatus'])->middleware(['permission:Xo?? phi???u xu???t']);
    Route::delete('/export/delete/{id}', [ExportController::class, 'destroy'])->middleware(['permission:Xo?? phi???u xu???t']);
    Route::delete('/export/deleteCode/{id}', [ExportController::class, 'deleteCode'])->middleware(['permission:Xo?? phi???u xu???t']);

    Route::get('/import', [ImportController::class, 'index'])->middleware(['permission:Xem phi???u nh???p']);
    Route::get('/import/indexStatus', [ImportController::class, 'indexStatus'])->middleware(['permission:Xem phi???u nh???p']);
    Route::get('/import/add', [ImportController::class, 'create'])->middleware(['permission:Th??m phi???u nh???p']);
    Route::post('/import/store', [ImportController::class, 'store'])->middleware(['permission:Th??m phi???u nh???p']);
    Route::get('/import/show/{id}', [ImportController::class, 'edit'])->middleware(['permission:Xem phi???u nh???p']);
    Route::put('/import/update/{id}', [ImportController::class, 'update'])->middleware(['permission:S???a phi???u nh???p']);
    Route::get('/import/indexStatus', [ExportController::class, 'indexStatus'])->middleware(['permission:Xem phi???u nh???p']);
    Route::put('/import/updateStatus/{id}', [ImportController::class, 'updateStatus'])->middleware(['permission:S???a phi???u nh???p']);
    Route::put('/import/dStatus/{id}', [ImportController::class, 'dStatus'])->middleware(['permission:S???a phi???u nh???p']);
    Route::post('/import/updateAmountItem/{id}', [ImportController::class, 'updateAmountItem'])->middleware(['permission:S???a phi???u nh???p']);
    Route::delete('/import/delete/{id}', [ImportController::class, 'destroy'])->middleware(['permission:Xo?? phi???u nh???p']);
    Route::delete('/import/deleteCode/{code}', [ImportController::class, 'deleteCode'])->middleware(['permission:Xo?? phi???u nh???p']);

    Route::get('/category', [CategoryController::class, 'index']);
    Route::get('/shelf', [ShelvesController::class, 'index']);
    Route::get('/items/searchItem/{id}', [ItemController::class, 'searchItem']);
    Route::get('/warehouse', [WarehouseController::class, 'index']);
    Route::get('/warehouse/{id}', [WarehouseController::class, 'index2'])->middleware(['permission:Xem kho']);
    Route::get('/suppliers', [SuppliersController::class, 'index'])->middleware(['permission:Xem nh?? cung c???p']);

    /**************Notification************/
    Route::get('/notification', [NotificationController::class, 'index']);
    Route::post('/notification/store', [NotificationController::class, 'store']);
    Route::get('/notification/get-person/{id}', [NotificationController::class, 'getPersonInWarehouse']);

    /*************Transfer*************/
    Route::get('/transfer', [TransferController::class, 'index'])->middleware(['permission:Xem phi???u chuy???n']);
    Route::get('/transfer/add', [TransferController::class, 'create'])->middleware(['permission:Xem phi???u chuy???n']);
    Route::post('/transfer/store', [TransferController::class, 'store'])->middleware(['permission:Th??m phi???u chuy???n']);
    Route::get('/transfer/show/{id}', [TransferController::class, 'edit'])->middleware(['permission:Xem phi???u chuy???n']);
    Route::put('/transfer/update/{id}', [TransferController::class, 'update'])->middleware(['permission:S???a phi???u chuy???n']);
    Route::delete('/transfer/delete/{id}', [TransferController::class, 'destroy'])->middleware(['permission:Xo?? phi???u chuy???n']);
    Route::put('/transfer/updateStatus/{id}', [TransferController::class, 'updateStatus'])->middleware(['permission:S???a phi???u chuy???n|Duy???t phi???u chuy???n']);
    Route::put('/transfer/dStatus/{id}', [TransferController::class, 'dStatus'])->middleware(['permission:S???a phi???u chuy???n|Duy???t phi???u chuy???n']);
    Route::delete('/transfer/deleteCode/{id}', [TransferController::class, 'deleteCode'])->middleware(['permission:Xo?? phi???u chuy???n']);

    Route::get('/inventory/showHistoryExport/{id}', [InventoryController::class, 'showHistoryExport'])->middleware(['permission:Xem phi???u xu???t']);
    Route::get('/inventory/showHistoryImport/{id}', [InventoryController::class, 'showHistoryImport'])->middleware(['permission:Xem phi???u nh???p']);
    Route::get('/inventory/showHistoryTransfer/{id}', [InventoryController::class, 'showHistoryTransfer'])->middleware(['permission:Xem phi???u chuy???n']);
    Route::get('/inventory/showCodeExport', [InventoryController::class, 'showCodeExport'])->middleware(['permission:Xem phi???u xu???t']);
    Route::get('/inventory/showCodeImport', [InventoryController::class, 'showCodeImport'])->middleware(['permission:Xem phi???u nh???p']);
    Route::get('/inventory/showCodeTransfer', [InventoryController::class, 'showCodeTransfer'])->middleware(['permission:Xem phi???u chuy???n']);
    // });
    /************Statistic*************/
    Route::post('/statistic/importByDay', [StatisticController::class, 'importByDay']);
    Route::post('/statistic/importByMonth', [StatisticController::class, 'importByMonth']);
    Route::post('/statistic/importByYear', [StatisticController::class, 'importByYear']);
    Route::post('/statistic/exportByDay', [StatisticController::class, 'exportByDay']);
    Route::post('/statistic/exportByMonth', [StatisticController::class, 'exportByMonth']);
    Route::post('/statistic/exportByYear', [StatisticController::class, 'exportByYear']);
    Route::post('/statistic/transferByDay', [StatisticController::class, 'transferByDay']);
    Route::post('/statistic/transferByMonth', [StatisticController::class, 'transferByMonth']);
    Route::post('/statistic/transferByYear', [StatisticController::class, 'transferByYear']);


    // Route::group(['middleware' => ['role:admin|ceo|president|chiefAccountant']], function () {
    // Route::get('/');

    Route::post('/detail_user/store/{id}', [DetailUserController::class, 'store'])->middleware(['permission:Th??m t??i kho???n']);
    Route::get('/detail_user/show/{id}', [DetailUserController::class, 'edit'])->middleware(['permission:Xem t??i kho???n']);
    Route::put('/detail_user/update/{id}', [DetailUserController::class, 'update'])->middleware(['permission:S???a t??i kho???n']);
    Route::delete('/detail_user/delete/{id}', [DetailUserController::class, 'destroy'])->middleware(['permission:Xo?? t??i kho???n']);

    /**************Notification************/
    Route::get('/notification/{id}', [NotificationController::class, 'index2']);
    Route::get('/notification/send/{id}', [NotificationController::class, 'send']);
    Route::get('/notification/add', [NotificationController::class, 'create']);
    Route::get('/notification/show/{id}', [NotificationController::class, 'edit']);
    Route::get('/notification/count/{id}', [NotificationController::class, 'count']);
    Route::put('/notification/update/{id}', [NotificationController::class, 'update']);
    Route::delete('/notification/delete/{id}', [NotificationController::class, 'destroy']);

    Route::get('/inventory', [InventoryController::class, 'index'])->middleware(['permission:Xem phi???u ki???m k??']);
    Route::get('/inventory/add', [InventoryController::class, 'create'])->middleware(['permission:Th??m phi???u ki???m k??']);
    Route::post('/inventory/store', [InventoryController::class, 'store'])->middleware(['permission:Th??m phi???u ki???m k??']);
    Route::get('/inventory/show/{id}', [InventoryController::class, 'edit'])->middleware(['permission:Xem phi???u ki???m k??']);
    Route::put('/inventory/update/{id}', [InventoryController::class, 'update'])->middleware(['permission:S???a phi???u ki???m k??']);
    Route::delete('/inventory/delete/{id}', [InventoryController::class, 'destroy'])->middleware(['permission:Xo?? phi???u ki???m k??']);
    Route::put('/inventory/handleInventory/{code}', [InventoryController::class, 'handleInventory'])->middleware(['permission:Duy???t phi???u ki???m k??']);
    Route::get('/inventory/showCodeInventory', [InventoryController::class, 'showCodeInventory'])->middleware(['permission:Xem phi???u ki???m k??']);
    Route::get('/inventory/showHistoryInventory/{id}', [InventoryController::class, 'showHistoryInventory'])->middleware(['permission:Xem phi???u ki???m k??']);
    Route::delete('/inventory/deleteCode/{code}', [InventoryController::class, 'deleteCode'])->middleware(['permission:Xo?? phi???u ki???m k??']);



    // Route::get('/item', [ItemController::class, 'index']);
    // Route::get('/item/add', [ItemController::class, 'create']);
    // Route::post('/item/store', [ItemController::class, 'store']);
    // Route::get('/item/show/{id}', [ItemController::class, 'edit']);
    // Route::put('/item/update/{id}', [ItemController::class, 'update']);
    // Route::delete('/item/delete/{id}', [ItemController::class, 'destroy']);


    // Route::get('/detail_item', [Detail_ItemController::class, 'index']);
    // Route::get('/detail_item/add', [Detail_ItemController::class, 'create']);
    // Route::post('/detail_item/store', [Detail_ItemController::class, 'store']);
    // Route::get('/detail_item/show/{id}', [Detail_ItemController::class, 'edit']);
    // Route::put('/detail_item/update/{id}', [Detail_ItemController::class, 'update']);
    // Route::delete('/detail_item/delete/{id}', [Detail_ItemController::class, 'destroy']);

    /*************Detail_item**************/
    Route::get('/detail_item', [DetailitemController::class, 'index'])->middleware(['permission:Xem chi ti???t v???t t??']);
    Route::get('/detail_item/add', [DetailitemController::class, 'create'])->middleware(['permission:Th??m chi ti???t v???t t??']);
    Route::post('/detail_item/store', [DetailitemController::class, 'store'])->middleware(['permission:Th??m chi ti???t v???t t??']);
    Route::get('/detail_item/show/{id}', [DetailitemController::class, 'edit'])->middleware(['permission:Xem chi ti???t v???t t??']);
    Route::put('/detail_item/update/{id}', [DetailitemController::class, 'update']);
    Route::delete('/detail_item/delete/{id}', [DetailitemController::class, 'destroy'])->middleware(['permission:Xo?? chi ti???t v???t t??']);


    // Route::get('/category', [CategoryController::class, 'index']);
    Route::get('/category/add', [CategoryController::class, 'create'])->middleware(['permission:Xem lo???i v???t t??']);
    Route::post('/category/store', [CategoryController::class, 'store'])->middleware(['permission:Th??m lo???i v???t t??']);
    Route::get('/category/show/{id}', [CategoryController::class, 'edit'])->middleware(['permission:Xem lo???i v???t t??']);
    Route::put('/category/update/{id}', [CategoryController::class, 'update'])->middleware(['permission:S???a lo???i v???t t??']);
    Route::delete('/category/delete/{id}', [CategoryController::class, 'destroy'])->middleware(['permission:Xo?? lo???i v???t t??']);
    Route::get('/category/itemCategory/{id}', [CategoryController::class, 'itemCategory'])->middleware(['permission:Xem lo???i v???t t??']);
    Route::get('/category/unitCategory/{id}', [CategoryController::class, 'unitCategory'])->middleware(['permission:Xem lo???i v???t t??']);

    /*************Warehouse**************/
    // Route::get('/warehouse', [WarehouseController::class, 'index']);

    Route::get('/warehouse/add', [WarehouseController::class, 'create'])->middleware(['permission:Xem kho']);
    Route::post('/warehouse/store', [WarehouseController::class, 'store'])->middleware(['permission:Th??m kho']);
    Route::get('/warehouse/show/{id}', [WarehouseController::class, 'edit']);
    Route::get('/warehouse/show2/{id}', [WarehouseController::class, 'edit2']);
    Route::put('/warehouse/update/{id}', [WarehouseController::class, 'update'])->middleware(['permission:S???a kho']);
    Route::delete('/warehouse/delete/{id}', [WarehouseController::class, 'destroy'])->middleware(['permission:Xo?? kho']);
    Route::get('/warehouse/shelfWarehouse/{id}', [WarehouseController::class, 'shelfWarehouse']);
    Route::get('/warehouse/itemShelf/{id}/{shelf_id}', [WarehouseController::class, 'itemShelf']);
    Route::get('/warehouse/itemWarehouse/{id}', [WarehouseController::class, 'itemWarehouse'])->middleware(['permission:Xem kho']);
    Route::get('/warehouse/countWarehouse', [WarehouseController::class, 'countWarehouse'])->middleware(['permission:Xem kho']);
    Route::get('/warehouse/amountShelf/{id}', [WarehouseController::class, 'amountShelf'])->middleware(['permission:Xem kho']);
    Route::get('/warehouse/sumAmountItem/{id}', [WarehouseController::class, 'sumAmountItem'])->middleware(['permission:Xem kho']);
    Route::get('/warehouse/searchItems/{name}/{id}', [WarehouseController::class, 'searchItems'])->middleware(['permission:Xem kho']);

    Route::get('/warehouse/kd/{id}/{w_id}/{sh_id}/{bc}/{sup_id}', [WarehouseController::class, 'kd']);
    Route::get('/warehouse/amountItemKKD/{id}/{shelfid}/{warehouseid}', [WarehouseController::class, 'amountItemKKD'])->middleware(['permission:Xem kho']);
    Route::get('/warehouse/detailItemId/{id}/{shelfid}/{warehouseid}', [WarehouseController::class, 'detailItemId'])->middleware(['permission:Xem kho']);
    Route::get('/warehouse/listItem/{id}', [WarehouseController::class, 'listItem'])->middleware(['permission:Xem kho']);
    Route::get('/warehouse/managerShow/{id}', [WarehouseController::class, 'managerShow'])->middleware(['permission:Xem kho']);
    Route::put('/warehouse/statusWarehouse/{id}', [WarehouseController::class, 'statusWarehouse'])->middleware(['permission:S???a kho']);
    Route::get('/warehouse/managerWarehouse/{id}', [WarehouseController::class, 'managerWarehouse'])->middleware(['permission:Xem kho']);


    /****************Manager*************** */



    /*************Shelf*************/
    // Route::get('/shelf', [ShelvesController::class, 'index']);
    Route::get('/shelf/add', [ShelvesController::class, 'create'])->middleware(['permission:Th??m gi??/k???']);
    Route::post('/shelf/store', [ShelvesController::class, 'store'])->middleware(['permission:Th??m gi??/k???']);
    Route::get('/shelf/show/{id}', [ShelvesController::class, 'edit'])->middleware(['permission:Xem gi??/k???']);
    Route::put('/shelf/update/{id}', [ShelvesController::class, 'update'])->middleware(['permission:S???a gi??/k???']);
    Route::delete('/shelf/delete/{id}', [ShelvesController::class, 'destroy'])->middleware(['permission:Xo?? gi??/k???']);
    Route::delete('/shelf/delete-item/{id}', [ShelvesController::class, 'destroyItem'])->middleware(['permission:Xo?? gi??/k???']);
    Route::get('/shelf/amountItem/{id}', [ShelvesController::class, 'amountItem'])->middleware(['permission:Xem gi??/k???']);


    //**********Import**************/
    // Route::group(['middleware' => ['role:admin']], function () {

    // });

    /**************Item***************/
    Route::get('/items', [ItemController::class, 'index']);
    Route::get('/items/add', [ItemController::class, 'create'])->middleware(['permission:Th??m v???t t??']);
    // Route::post('/items/store', [ItemController::class, 'store']);
    Route::post('/items/store', [ItemController::class, 'store'])->middleware(['permission:Th??m v???t t??']);
    Route::get('/items/show/{id}', [ItemController::class, 'edit'])->middleware(['permission:Xem v???t t??']);
    // Route::put('/items/update/{id}', [ItemController::class, 'update']);
    Route::put('/items/update/{id}', [ItemController::class, 'update'])->middleware(['permission:S???a v???t t??']);
    // Route::delete('/items/delete/{id}', [ItemController::class, 'destroy']);
    Route::delete('/items/delete/{id}', [ItemController::class, 'destroy'])->middleware(['permission:Xo?? v???t t??']);
    // Route::get('/items/searchItem/{id}', [ItemController::class, 'searchItem']);
    Route::get('/items/itemInWarehouse', [ItemController::class, 'itemInWarehouse']);

    Route::get('/items/amountItem/{id}/{warehouse_id}/{shelf_id}', [ItemController::class, 'amountItemsplit']);



    /****************Suppliers***************/
    // Route::get('/suppliers', [SuppliersController::class, 'index']);
    Route::get('/suppliers/add', [SuppliersController::class, 'create'])->middleware(['permission:Xem nh?? cung c???p']);
    Route::post('/suppliers/store', [SuppliersController::class, 'store'])->middleware(['permission:Th??m nh?? cung c???p']);
    Route::get('/suppliers/show/{id}', [SuppliersController::class, 'edit'])->middleware(['permission:Xem nh?? cung c???p']);
    Route::put('/suppliers/update/{id}', [SuppliersController::class, 'update'])->middleware(['permission:S???a nh?? cung c???p']);
    Route::delete('/suppliers/delete/{id}', [SuppliersController::class, 'destroy'])->middleware(['permission:Xo?? nh?? cung c???p']);
    Route::get('/suppliers/listImport/{id}', [SuppliersController::class, 'listImport']);


    /**************Category****************/
    // Route::get('/category', [CategoryController::class, 'index']);
    // Route::get('/category/show/{id}', [CategoryController::class, 'edit']);

    // /**************Notification************/
    // Route::get('/notification', [NotificationController::class, 'index']);
    // Route::get('/notification/showNotification/{id}', [NotificationController::class, 'showNotification']);
    // Route::get('/notification/showListItemById/{id}', [NotificationController::class, 'showListItemById']);
    // Route::post('/notification/store', [NotificationController::class, 'store']);

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

        Route::get('/detail_roles/{id}/{role_id}', [RolesController::class, 'detailRoles']);
        Route::post('/user_roles', [RolesController::class, 'userRoles']);
    });
    // });
});
