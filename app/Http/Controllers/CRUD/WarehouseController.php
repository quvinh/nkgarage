<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\Manager;
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
            'data' => $data,
            'status' => 'Get all data warehouse'
        ], 201);
    }

    public function index2($id) {
        $data = DB::table('warehouses')
        ->join('managers', 'managers.warehouse_id','=','warehouses.id')
        ->where('managers.user_id',$id)
        ->select('warehouses.name as name', 'warehouses.location as location', 'warehouses.status as status', 'warehouses.id as id')
        ->get();
        return response()->json([
            'status' => 'Show Warehouse By User_id',
            'message' => 'Show successfully',
            'data' => $data,
        ]);
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
        Manager::create([
            'user_id' => 1,
            'warehouse_id' => $data->id
        ]);

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
        $data = DB::table('managers')
        ->join('warehouses', 'warehouses.id','=','managers.warehouse_id')
        ->where('managers.user_id',$id)
        ->select('warehouses.name as name', 'warehouses.location as location', 'warehouses.status as status', 'warehouses.id as id')
        ->get();
        return response()->json([
            'status' => 'Show Warehouse By User_id',
            'message' => 'Show successfully',
            'data' => $data,
        ]);
    }

    public function edit2($id){
        $data = Warehouse::find($id);
        return response()->json([
            'message' => 'Data warehouse',
            'data' => $data,
        ], 201);
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
        Manager::where('warehouse_id', $id)->delete();
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
                'warehouses.name as warehouse_name',
                'shelves.status as status',
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
                'detail_items.id as id',
                'items.id as item_id', //vvuong fix
                'items.name as itemname',
                'categories.id as category_id',
                'categories.name as categoryname',
                'warehouses.id as warehouse_id',
                'warehouses.name as name_warehouse',
                'shelves.id as shelf_id',
                'shelves.name as shelf_name',
                'supplier_id',
                'batch_code',
                'amount',
                'items.unit',
                'price',

            )
            ->where('shelf_id', $shelf_id)
            ->where('detail_items.warehouse_id', $id)
            ->get();

        $count = DB::table('detail_items')
            ->where('shelf_id', $shelf_id)
            ->where('detail_items.warehouse_id', $id)
            ->get()
            ->count();


        return response()->json([
            'message' => 'Data itemShelf',
            'data' => $item,
            'count' => $count,
            // 'KKD' => $KKD,
        ], 201);
    }


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
                'detail_items.unit as unit',
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
        $export = DB::table('exports')
            ->where([['item_id', $id], ['warehouse_id', $w_id], ['shelf_id', $s_id], ['status', 1], ['deleted_at', null]])
            ->selectRaw('sum(amount) as amount')
            ->get();
        $detail_item = DB::table('detail_items')
            ->where([['item_id', $id], ['warehouse_id', $w_id], ['shelf_id', $s_id]])
            ->get();
        $transfer = DB::table('transfers')
            ->where([['item_id', $id], ['from_warehouse', $w_id], ['from_shelf', $s_id], ['status', 1], ['deleted_at', null]])
            ->selectRaw('sum(amount) as amount')
            ->get();
        if ($export->count() > 0) $ex = $export[0]->amount;
        else $ex = 0;
        if ($transfer->count() > 0) $tf = $transfer[0]->amount;
        else $tf = 0;

        $kd = $detail_item[0]->amount - $ex - $tf;
        if ($kd < 0) $kd = 0;
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
                'items.unit as unit',
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
    public function amountItemKKD($id, $shelfid, $warehouseid)
    {
        $count = DB::table('exports')
            ->where('item_id', $id)
            ->where('shelf_id', $shelfid)
            ->where('warehouse_id', $warehouseid)
            ->where('status', 1)
            ->get()
            ->count();
        if ($count > 0) {
            $kkdAmount = DB::table('exports')
                ->select(DB::raw('sum(amount) as kkdAmount'))
                ->where('status', 1)
                ->where('item_id', $id)
                ->where('shelf_id', $shelfid)
                ->where('warehouse_id', $warehouseid)
                ->groupBy('item_id')
                ->get();
            $resultExport = $kkdAmount[0]->kkdAmount;
        } else $resultExport = 0;

        $countTransfer = DB::table('transfers')
            ->where('item_id', $id)
            ->where('from_shelf', $shelfid)
            ->where('from_warehouse', $warehouseid)
            ->where('status', 1)
            ->get()
            ->count();
        if ($countTransfer > 0) {
            $kkdAmountTransfer = DB::table('transfers')
                ->select(DB::raw('sum(amount) as kkdAmountTransfer'))
                ->where('status', 1)
                ->where('item_id', $id)
                ->where('from_shelf', $shelfid)
                ->where('from_warehouse', $warehouseid)
                ->groupBy('item_id')
                ->get();
            $resultTransfer = $kkdAmountTransfer[0]->kkdAmountTransfer;
        } else $resultTransfer = 0;

        $result = $resultExport + $resultTransfer;
        return response()->json([
            'message' => 'Data amountItemKKD',
            'data' => $result,
            // 'valid' => $resultTransfer,
        ], 201);
    }


    public function listItem($id)
    {
        $list = DB::table('detail_items')
            ->join('items', 'items.id', '=', 'detail_items.item_id')
            ->join('categories', 'categories.id', '=', 'detail_items.category_id')
            ->join('warehouses', 'warehouses.id', '=', 'detail_items.warehouse_id')
            ->join('shelves', 'shelves.id', '=', 'detail_items.shelf_id')
            ->select(
                'detail_items.id as detail_item_id',
                'detail_items.item_id as id',
                'items.name as itemname',
                'batch_code',
                'detail_items.category_id as category_id',
                'categories.name as categoryname',
                'amount',
                'detail_items.unit as unit',
                'shelves.status as shelf_status',
                'detail_items.status',
                'detail_items.warehouse_id',
                'warehouses.name as warehousename',
                'shelf_id',
                'shelves.name as shelfname',
                'price'
            )
            ->where('detail_items.warehouse_id', $id)
            ->get();

        return response()->json([
            'message' => 'Data Item Show',
            'data' => $list

        ], 201);
    }
    public function managerShow($id) {
        $data = DB::table('managers')
        ->join('users', 'users.id', '=', 'managers.user_id')
        ->join('warehouses', 'warehouses.id', '=', 'managers.warehouse_id')
        ->select(
            'managers.user_id as userid',
            'managers.warehouse_id as warehouse_id',
            'fullname',
            'email',
            'phone',
            'warehouses.name as warehousename'
            )
        ->where('managers.warehouse_id',$id)
        ->get();

        return response()->json([
            'message' => 'Data Item Show',
            'data' => $data

        ], 201);
    }

    public function statusWarehouse(Request $request, $id) {
        $data = Warehouse::where('id', $id)->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Data warehouse successfully changed',
            'status' => 'Updated Data',
            'data' => $data,
        ], 201);
    }

    // public function openWarehouse($id) {
    //     $open = Warehouse::where('id', $id)->update([
    //         'status' => false,
    //     ]);

    //     return response()->json([
    //         'message' => 'Data warehouse successfully changed',
    //         'status' => 'Updated Data',
    //         'data' => $open,
    //     ], 201);
    // }

}
