<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Item::all();
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
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $data = Item::create($request->all());

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
        $data = Item::find($id);
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
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $data = Item::where('id', $id)->update([
            'id' => $request->id,
            'name' => $request->name
        ]);

        return response()->json([
            'message' => 'Data Import successfully changed',
            'data' => $data
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
        $data = Item::find($id);
        $data->delete();

        return response()->json([
            'tatus' => 'Delete data Permissions',
            'message' => 'Delete sucessfully',
        ], 201);
    }

    public function searchItem($id)
    {

        $search = DB::table('detail_items')
            ->join('items', 'items.id', '=', 'detail_items.item_id')
            ->join('warehouses', 'warehouses.id', '=', 'detail_items.warehouse_id')
            ->join('shelves', 'shelves.id', '=', 'detail_items.shelf_id')
            ->join('categories', 'categories.id', '=', 'detail_items.category_id')
            // ->join('imports', 'import.id', '=', 'detail_items.category_id')
            ->select(
                'items.id as item_id',
                'items.name as name_item',
                'categories.id as category_id',
                'warehouses.id as warehouse_id',
                'warehouses.name as name_warehouse',
                'shelves.id as shelf_id',
                'batch_code',
                'amount',
                'unit',
                'price'
            )
            ->where([
                // ['items.name', 'like', '%' . $name . '%'],
                ['warehouses.id', '=', $id]
            ])
            ->get();
        // dd($search);
        return response()->json([
            'message' => 'Data Import successfully changed',
            'data' => $search
        ], 201);
    }

    public function itemInWarehouse($id) {
        $search = DB::table('detail_items')
        ->join('items','items.id','=','detail_items.item_id')
        ->join('warehouses','warehouses.id','=','detail_items.warehouse_id')
        ->join('shelves','shelves.id','=','detail_items.shelf_id')
        ->join('categories','categories.id','=','detail_items.category_id')
        ->select('items.id as itemId','items.name as nameItem','categories.name as nameCategory',
            'warehouses.name as nameWarehouse','shelves.name as nameShelves',
            'batch_code','amount',
            'unit','price','status')
        ->where('warehouses.id',$id)
        ->get();
        return response()->json([
            'message' => 'Get all Item in Warehouse',
            'data' => $search
        ], 201);
    }

    // public function itemInWarehouse($id)
    // {
    //     $search = DB::table('detail_items')
    //         ->join('items', 'items.id', '=', 'detail_items.item_id')
    //         ->join('warehouses', 'warehouses.id', '=', 'detail_items.warehouse_id')
    //         ->join('shelves', 'shelves.id', '=', 'detail_items.shelf_id')
    //         ->join('categories', 'categories.id', '=', 'detail_items.category_id')
    //         ->select(
    //             'items.id as itemId',
    //             'items.name as nameItem',
    //             'categories.name as nameCategory',
    //             'warehouses.name as nameWarehouse',
    //             'warehouses.id as warehouse_id',
    //             'shelves.name as nameShelves',
    //             'batch_code',
    //             'amount',
    //             'unit',
    //             'price'
    //         )
    //         ->where('warehouses.id', $id)
    //         ->get();
    //     // dd($search);
    //     return response()->json([
    //         'message' => 'Get all Item in Warehouse',
    //         'data' => $search
    //     ], 201);
    // }

    public function amountItemsplit($id,$warehouse_id,$shelf_id){
        $amountKKD = DB::table('exports')
            ->where([['item_id','=',$id],
                ['warehouse_id','=',$warehouse_id],
                ['shelf_id','=',$shelf_id]])
            ->get('amount')
            ->sum();

        $amountitems = DB::table('detail_items')
        ->where([['item_id','=',$id],
        ['warehouse_id','=',$warehouse_id],
        ['shelf_id','=',$shelf_id]])
            ->get('amount')
            ->sum();

        $amountKD = $amountitems - $amountKKD;

        return response()->json([
            'message' => 'Data Import successfully changed',
            'amountKD' => $amountKD,
            'amountKKD' => $amountKKD,
            'amountitems' => $amountitems
        ], 201);
    }

}
