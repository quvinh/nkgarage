<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

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

        return response()->json([
            'message' => 'Data created successfully',
            'status' => 'Created Data',
            'data' => $data
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
            ->join('warehouses', 'warehouses.id', '=', 'detail_items.warehouse_id')
            ->join('shelves', 'shelves.id', '=', 'detail_items.shelf_id')
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
            )
            ->where('shelf_id', $shelf_id)
            ->where('detail_items.warehouse_id', $id)
            ->get();

        return response()->json([
            'message' => 'Data itemShelf',
            'data' => $item
        ], 201);
    }
    // public function itemShelf($id, $shelf_id)
    // {
    //     $item = DB::table('detail_items')
    //         ->join('items', 'items.id', '=', 'detail_items.item_id')
    //         ->join('categories', 'categories.id', '=', 'detail_items.category_id')
    //         ->join('warehouses', 'warehouses.id', '=', 'detail_items.warehouse_id')
    //         ->join('shelves', 'shelves.id', '=', 'detail_items.shelf_id')
    //         ->joim('exports', 'exports.item_id','=','detail_items.item_id')
    //         ->select(DB::raw(
    //             'detail_items.id as detail_item_id',
    //             'detail_items.item_id as id',
    //             'items.name as itemname',
    //             'shelves.position as position',
    //             'categories.name as categoryname',
    //             'amount',
    //             'unit',
    //             'shelves.status as shelf_status',
    //             'detail_items.status',
    //             'detail_items.warehouse_id',
    //             'warehouses.name as warehousename',
    //             'shelf_id',
    //             'shelves.name as shelfname',
    //             'price')
    //         )
    //         ->where('shelf_id', $shelf_id)
    //         ->where('detail_items.warehouse_id', $id)
    //         ->get();

    //     return response()->json([
    //         'message' => 'Data itemShelf',
    //         'data' => $item
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
            'message' => 'Data itemShelf',
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

        return response()->json([
            'message' => 'Data warehouse successfully',
            'data' => $countShelf,
        ], 201);
    }

    public function sumAmountItem($id)
    {
        $countItem = DB::table('detail_items')
            ->join('warehouses', 'warehouses.id', '=', 'detail_items.warehouse_id')
            ->select(DB::raw('sum(amount) as amountItem'))
            ->where('warehouse_id', $id)
            ->get();

        return response()->json([
            'message' => 'Data warehouse successfully',
            'data' => $countItem
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
                'unit',
                'price',
                'detail_items.status'
            )
            ->where([
                ['items.name', 'like', '%' . $name . '%'],
                ['warehouses.id','=',$id],
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

}
