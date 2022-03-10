<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission as ModelsPermission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Warehouse::all();
        return response()->json([
            'data' => $data
        ], 201);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'location' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $data = Warehouse::create($request->all());

        //Import
        ModelsPermission::create(['name' => 'Thêm phiếu nhập '.$data->id]);
        ModelsPermission::create(['name' => 'Sửa phiếu nhập '.$data->id]);
        ModelsPermission::create(['name' => 'Xoá phiếu nhập '.$data->id]);
        ModelsPermission::create(['name' => 'Xem phiếu nhập '.$data->id]);
        ModelsPermission::create(['name' => 'Duyệt phiếu nhập '.$data->id]);

        //Export
        ModelsPermission::create(['name' => 'Thêm phiếu xuất '.$data->id]);
        ModelsPermission::create(['name' => 'Sửa phiếu xuất '.$data->id]);
        ModelsPermission::create(['name' => 'Xoá phiếu xuất '.$data->id]);
        ModelsPermission::create(['name' => 'Xem phiếu xuất '.$data->id]);
        ModelsPermission::create(['name' => 'Duyệt phiếu xuất '.$data->id]);

        //Transfer
        ModelsPermission::create(['name' => 'Thêm phiếu chuyển '.$data->id]);
        ModelsPermission::create(['name' => 'Sửa phiếu chuyển '.$data->id]);
        ModelsPermission::create(['name' => 'Xoá phiếu chuyển '.$data->id]);
        ModelsPermission::create(['name' => 'Xem phiếu chuyển '.$data->id]);
        ModelsPermission::create(['name' => 'Duyệt phiếu chuyển '.$data->id]);

        //Inventory
        ModelsPermission::create(['name' => 'Thêm phiếu kiểm kê '.$data->id]);
        ModelsPermission::create(['name' => 'Sửa phiếu kiểm kê '.$data->id]);
        ModelsPermission::create(['name' => 'Xoá phiếu kiểm kê '.$data->id]);
        ModelsPermission::create(['name' => 'Xem phiếu kiểm kê '.$data->id]);
        ModelsPermission::create(['name' => 'Duyệt phiếu kiểm kê '.$data->id]);

        ModelsPermission::create(['name' => 'Thêm giá/kệ '.$data->id]);
        ModelsPermission::create(['name' => 'Sửa giá/kệ '.$data->id]);
        ModelsPermission::create(['name' => 'Xoá giá/kệ '.$data->id]);
        ModelsPermission::create(['name' => 'Xem giá/kệ '.$data->id]);

        $president = Role::create(['name' => 'Giám đốc '.$data->id]);
        $accountant = Role::create(['name' => 'Kế toán '.$data->id]);
        $storekeeper = Role::create(['name' => 'Thủ kho '.$data->id]);

        $president->givePermissionTo(
            'Thêm phiếu nhập '.$data->id, 'Sửa phiếu nhập '.$data->id, 'Xoá phiếu nhập '.$data->id, 'Xem phiếu nhập '.$data->id, 'Duyệt phiếu nhập '.$data->id,
            'Thêm phiếu xuất '.$data->id, 'Sửa phiếu xuất '.$data->id, 'Xoá phiếu xuất '.$data->id, 'Xem phiếu xuất '.$data->id, 'Duyệt phiếu xuất '.$data->id,
            'Thêm phiếu chuyển '.$data->id, 'Sửa phiếu chuyển '.$data->id, 'Xoá phiếu chuyển '.$data->id, 'Xem phiếu chuyển '.$data->id, 'Duyệt phiếu chuyển '.$data->id,
            'Thêm phiếu kiểm kê '.$data->id, 'Sửa phiếu kiểm kê '.$data->id, 'Xoá phiếu kiểm kê '.$data->id, 'Xem phiếu kiểm kê '.$data->id, 'Duyệt phiếu kiểm kê '.$data->id,
            'Xem kho',
            'Thêm giá/kệ '.$data->id, 'Sửa giá/kệ '.$data->id, 'Xoá giá/kệ '.$data->id, 'Xem giá/kệ '.$data->id,
            'Thêm loại vật tư', 'Sửa loại vật tư', 'Xoá loại vật tư', 'Xem loại vật tư',
            'Thêm nhà cung cấp', 'Sửa nhà cung cấp', 'Xoá nhà cung cấp', 'Xem nhà cung cấp',
            'Thêm thông báo', 'Sửa thông báo', 'Xoá thông báo', 'Xem thông báo',
            'Thêm báo cáo', 'Sửa báo cáo', 'Xoá báo cáo', 'Xem báo cáo',
        );

        $accountant->givePermissionTo(
            'Thêm phiếu nhập '.$data->id, 'Sửa phiếu nhập '.$data->id, 'Xem phiếu nhập '.$data->id, 'Duyệt phiếu nhập '.$data->id,
            'Thêm phiếu xuất '.$data->id, 'Sửa phiếu xuất '.$data->id, 'Xem phiếu xuất '.$data->id, 'Duyệt phiếu xuất '.$data->id,
            'Thêm phiếu chuyển '.$data->id, 'Sửa phiếu chuyển '.$data->id, 'Xem phiếu chuyển '.$data->id, 'Duyệt phiếu chuyển '.$data->id,
            'Thêm phiếu kiểm kê '.$data->id, 'Sửa phiếu kiểm kê '.$data->id, 'Xem phiếu kiểm kê '.$data->id, 'Duyệt phiếu kiểm kê '.$data->id,
            'Thêm giá/kệ '.$data->id, 'Sửa giá/kệ '.$data->id, 'Xoá giá/kệ '.$data->id, 'Xem giá/kệ '.$data->id,
            'Xem loại vật tư',
            'Thêm nhà cung cấp', 'Sửa nhà cung cấp', 'Xem nhà cung cấp',
            'Thêm thông báo', 'Sửa thông báo', 'Xem thông báo',
            'Thêm báo cáo', 'Sửa báo cáo', 'Xoá báo cáo', 'Xem báo cáo',
        );
        $storekeeper->givePermissionTo(
            'Thêm phiếu nhập '.$data->id, 'Sửa phiếu nhập '.$data->id, 'Xem phiếu nhập '.$data->id, 'Xem phiếu nhập '.$data->id, 'Duyệt phiếu nhập '.$data->id,
            'Thêm phiếu xuất '.$data->id, 'Sửa phiếu xuất '.$data->id, 'Xem phiếu xuất '.$data->id, 'Xem phiếu xuất '.$data->id, 'Duyệt phiếu xuất '.$data->id,
            'Thêm phiếu chuyển '.$data->id, 'Sửa phiếu chuyển '.$data->id, 'Xem phiếu chuyển '.$data->id, 'Xem phiếu chuyển '.$data->id, 'Duyệt phiếu chuyển '.$data->id,
            'Thêm phiếu kiểm kê '.$data->id, 'Sửa phiếu kiểm kê '.$data->id, 'Xem phiếu kiểm kê '.$data->id,
            'Thêm nhà cung cấp', 'Sửa nhà cung cấp', 'Xem nhà cung cấp',
            'Thêm thông báo', 'Xem thông báo',
            'Thêm báo cáo', 'Sửa báo cáo', 'Xem báo cáo',
        );

        return response()->json([
            'message' => 'Data created successfully',
            'status' => 'Created Data',
            'data' => $data,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data = Warehouse::find($id);
        return response()->json([
            'status' => 'Show form edit',
            'message' => 'Show successfully',
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'location' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $data = Warehouse::where('id', $id)->update([
            'name' => $request->name,
            'location' => $request->location,
            'note' => $request->note
        ]);

        return response()->json([
            'message' => 'Data warehouse successfully changed',
            'status' => 'Updated Data',
            'data' => $data,
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $data = Warehouse::find($id);
        $data->delete();

        return response()->json([
            'status' => 'Delete data warehouse',
            'message' => 'Delete successfully',
        ], 201);
    }

    public function shelfWarehouse($id)
    {
        $shelf = DB::table('shelves')
            ->join('warehouses', 'warehouses.id', '=', 'shelves.warehouse_id')
            ->select(
                'shelves.id as shelf_id',
                'shelves.name as shelf_name',
                'position',
                'warehouse_id',
                'warehouses.name as warehouse_name'
            )
            ->where('warehouse_id', $id)
            ->get();

        return response()->json([
            'message' => 'Data warehouse successfully',
            'data' => $shelf,
        ], 201);
    }
    public function itemShelf($id, $shelf_id)
    {
        $item = DB::table('detail_items')
            ->join('items', 'items.id', '=', 'detail_items.item_id')
            ->join('categories', 'categories.id', '=', 'detail_items.category_id')
            ->join('shelves', 'shelves.id', '=', 'detail_items.shelf_id')
            ->join('warehouses', 'warehouses.id', '=', 'detail_items.warehouse_id')
            ->select(
                'items.id as item_id',
                'items.name as name_item',
                'categories.id as category_id',
                'warehouses.id as warehouse_id',
                'warehouses.name as name_warehouse',
                'shelves.id as shelf_id',
                'shelves.name as shelf_name',
                'supplier_id',
                'batch_code',
                'amount',
                'items.unit',
                'price'
                // 'unit',
                // 'shelves.status as shelf_status',
                // 'detail_items.status',
                // 'shelf_id',
                // 'shelves.name as shelfname',
                // 'price',
                // 'detail_items.warehouse_id as warehouseid',
                // 'warehouses.name as warehousename'
            )
            ->where('shelf_id', $shelf_id)
            ->where('detail_items.warehouse_id', $id)
            ->get();
        // $KKD = DB::table('exports')
        //     ->select(DB::raw('sum(amount)'))
        //     ->where('status',1)
        //     ->groupBy('item_id')
        //     ->get();

        return response()->json([
            'message' => 'Data itemShelf',
            'data' => $item,
            // 'KKD' => $KKD,
        ], 201);
    }
    public function amountItemKKD($id)
    {
        $count = DB::table('exports')
            ->where('item_id', $id)
            ->where('status', 1)
            ->get()
            ->count();
        if ($count > 0) {
            $kkdAmount = DB::table('exports')
                ->select(DB::raw('sum(amount) as kkdAmount'))
                ->where('status', 1)
                ->where('item_id', $id)
                ->groupBy('item_id')
                ->get();
            $result = $kkdAmount[0]->kkdAmount;
        } else $result = 0;
        //

        // $result = collect($kkdAmount)->pluck('exports')->toArray();
        return response()->json([
            'message' => 'Data amountItemKKD',
            'data' => $result,
        ], 201);
    }
    // public function itemShelf($id, $shelf_id)
    // {
    //     $item = DB::table('detail_items')
    //         ->join('items', 'items.id', '=', 'detail_items.item_id')
    //         ->join('categories', 'categories.id', '=', 'detail_items.category_id')
    //         ->join('warehouses', 'warehouses.id', '=', 'detail_items.warehouse_id')
    //         ->join('shelves', 'shelves.id', '=', 'detail_items.shelf_id')
    //         ->join('exports', 'exports.item_id' ,'=','detail_items.item_id')
    //         ->select(
    //             'detail_items.id as detail_item_id',
    //             'detail_items.item_id as itemid',
    //             'items.name as itemname',
    //             'position',
    //             'categories.name as categoryname',
    //             'detail_items.amount as itemamount',
    //             'detail_items.unit as unit',
    //             'shelves.status as shelf_status',
    //             'detail_items.status',
    //             'detail_items.warehouse_id',
    //             'warehouses.name as warehousename',
    //             'detail_items.shelf_id as shelfid',
    //             'shelves.name as shelfname',
    //             'detail_items.price',
    //             DB::raw('sum(exports.item_id) as KKD')
    //         )
    //         ->where('detail_items.shelf_id', $shelf_id)
    //         ->where('detail_items.warehouse_id', $id)
    //         ->where('exports.status',1)
    //         ->groupBy('exports.item_id')
    //         ->get();
    //     $KKD = DB::table('exports')
    //     ->select(DB::raw('sum(amount)'))
    //     ->where('status',1)
    //     ->groupBy('item_id')
    //     ->get();
    //     dd($item[0]->itemamount - $KKD);
    //     return response()->json([
    //         'message' => 'Data itemShelf',
    //         'data' => $item,
    //         'KKD' => $KKD,
    //     ], 201);
    // }

    // public function

    public function itemWarehouse($id)
    {
        $item = DB::table('detail_items')
            ->join('items', 'items.id', '=', 'detail_items.item_id')
            ->join('categories', 'categories.id', '=', 'detail_items.category_id')
            ->join('warehouses', 'warehouses.id', '=', 'detail_items.warehouse_id')
            ->join('shelves', 'shelves.id', '=', 'detail_items.shelf_id')
            ->select(
                'detail_item.id as detail_item_id',
                'detail_items.item_id as id',
                'items.name as itemname',
                'batch_code',
                'categories.name as categoryname',
                'amount',
                'unit',
                'detail_items.status',
                'detail_items.warehouse_id',
                'warehouses.name as warehousename',
                'shelf_id',
                'shelves.name as shelfname',
                'price'
            )
            ->where('shelf_id', $id)
            // ->where('detail_items.warehouse_id', $id)
            ->get();

        return response()->json([
            'message' => 'Data itemWarehouse',
            'data' => $item
        ], 201);
    }

    // public function amountShelf()
    // {
    //     $countShelf = DB::table('shelves')
    //         ->join('warehouses', 'warehouses.id', '=', 'shelves.warehouse_id')
    //         ->select(DB::raw('count(id) as countShelf'))
    //         ->groupBy('warehouse_id')
    //         ->get();

    //     return response()->json([
    //         'message' => 'Data warehouse successfully',
    //         'data' => $countShelf,
    //     ], 201);
    // }
    public function amountShelf($id)
    {
        $countShelf = DB::table('shelves')
            ->join('warehouses', 'warehouses.id', '=', 'shelves.warehouse_id')
            ->where('warehouse_id', $id)
            ->get()
            ->count();
        $countItem = DB::table('detail_items')
            ->where('warehouse_id', $id)
            ->groupBy('item_id')
            ->get()
            ->count();

        return response()->json([
            'message' => 'Data amountShelf',
            'data' => $countShelf,
            'count' => $countItem,
        ], 201);
    }

    // public function sumAmountItem($id)
    // {
    //     $countItem = DB::table('detail_items')
    //         ->where('warehouse_id', $id)
    //         ->groupBy('item_id')
    //         ->get()
    //         ->count();
    // $totalprice = DB::table('detail_items')
    // ->select(DB::raw('sum(amount * price) as total'))
    // ->where('warehouse_id',$id)
    // ->get();

    // return response()->json([
    //     'message' => 'Data sumAmountItem',
    //     'data' => $countItem,
    // 'totalprice' => $totalprice
    // ], 201);
    // }

    public function warehouseShow()
    {
        $tonKho = DB::table('detail_items')
            ->join('warehouses', 'warehouses.id', '=', 'detail_items.warehouse_id')
            ->select(DB::raw('sum(amount * price) as total,sum(amount) as tonKho, warehouse_id, name'))
            ->groupBy('warehouse_id', 'name')
            ->get();
        return response()->json([
            'message' => 'Data DashBoard',
            'status' => 'DashBoard',
            'data' => $tonKho,
        ], 201);
    }

    public function searchItems($name, $id)
    {
        $search = DB::table('detail_items')
            ->join('items', 'items.id', '=', 'detail_items.item_id')
            ->join('warehouses', 'warehouses.id', '=', 'detail_items.warehouse_id')
            ->join('shelves', 'shelves.id', '=', 'detail_items.shelf_id')
            ->join('categories', 'categories.id', '=', 'detail_items.category_id')
            ->select(
                'detail_items.item_id as id',
                'items.name as itemname',
                'categories.name as categoryname',
                'detail_items.shelf_id as shelf_id',
                'warehouses.name as nameWarehouse',
                'shelves.name as shelfname',
                'batch_code',
                'amount',
                'unit',
                'price',
                'detail_items.status'
            )
            ->where([
                ['items.name', 'like', '%' . $name . '%'],
                ['warehouses.id', '=', $id],
            ])
            ->get();
        // dd($search);
        return response()->json([
            'message' => 'Data Import successfully changed',
            'data' => $search
        ], 201);
    }
    public function kd($id, $w_id, $s_id)
    {
        $export=DB::table('exports')
        ->where([['item_id',$id],['warehouse_id', $w_id],['shelf_id',$s_id],['status',1]])
        ->selectRaw('sum(amount) as amount')
        ->get();
        $detail_item = DB::table('detail_items')
        ->where([['item_id',$id],['warehouse_id', $w_id],['shelf_id',$s_id]])
        ->get();
        $transfer=DB::table('transfers')
        ->where([['item_id',$id],['from_warehouse', $w_id],['from_shelf',$s_id],['status',1]])
        ->selectRaw('sum(amount) as amount')
        ->get();
        if($export->count() >0) $ex = $export[0]->amount;
        else $ex = 0;
        if($transfer->count() >0) $tf = $transfer[0]->amount;
        else $tf = 0;

        $kd = $detail_item[0]->amount - $ex - $tf;
        if($kd < 0) $kd = 0;
        return response()->json([
            'message' => 'Số lượng khả dụng của vật tư ',
            'data' => $kd
        ], 201);
    }

    public function detailItemId($id, $shelfid, $warehouseid)
    {
        $item = DB::table('detail_items')
            ->join('items', 'items.id', '=', 'detail_items.item_id')
            ->join('categories', 'categories.id', '=', 'detail_items.category_id')
            ->join('shelves', 'shelves.id', '=', 'detail_items.shelf_id')
            ->join('warehouses', 'warehouses.id', '=', 'detail_items.warehouse_id')
            ->select(
                'detail_items.id as detail_item_id',
                'detail_items.item_id as id',
                'items.name as itemname',
                'batch_code as batchcode',
                'categories.name as categoryname',
                'detail_items.category_id as categoryid',
                'amount',
                'unit',
                'shelves.status as shelfstatus',
                'detail_items.status',
                'shelf_id as shelfid',
                'shelves.name as shelfname',
                'price',
                'detail_items.warehouse_id as warehouseid',
                'warehouses.name as warehousename',
                'detail_items.status as itemstatus'
            )
            ->where('shelf_id', $shelfid)
            ->where('detail_items.warehouse_id', $warehouseid)
            ->where('detail_items.item_id', $id)
            ->get();
        return response()->json([
            'message' => 'Data Import successfully changed',
            'data' => $item
        ], 201);
    }
}
