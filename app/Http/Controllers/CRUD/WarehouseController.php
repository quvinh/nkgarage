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
            'tatus' => 'Delete data warehouse',
            'message' => 'Delete sucessfully',
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
            ->where('shelf_id', $shelf_id)
            ->where('detail_items.warehouse_id', $id)
            ->get();

        return response()->json([
            'message' => 'Data itemShelf',
            'data' => $item
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

    public function amountShelf()
    {
        $countShelf = DB::table('shelves')
            ->join('warehouses', 'warehouses.id', '=', 'shelves.warehouse_id')
            ->select(DB::raw('count(id) as countShelf'))
            ->groupBy('warehouse_id',)
            ->get();

        return response()->json([
            'message' => 'Data warehouse successfully',
            'data' => $countShelf,
        ], 201);
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
}
