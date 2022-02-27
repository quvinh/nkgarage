<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\Shelves;
use App\Models\Export;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ShelvesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Shelves::all();
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
            'position' => 'required|string',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $data = Shelves::create([
            'name' => $request->name,
            'position' => $request->position,
            'warehouse_id' => $request->warehouse_id,
            'status' => '0',
        ]);

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
        // $data = DB::table('shelves')
        //     ->join('warehouses','warehouses.id','=','shelves.warehouse_id')
        //         ->select('shelves.id as id',   
        //             'shelves.warehouse_id as warehouse_id',
        //             'warehouses.name as warehouse_name',
        //             'shelves.name as name',
        //             'position','status')
        //         ->where('shelves.id',$id)
        //         ->get();
        $data = Shelves::find($id);
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
            'position' => 'required|string',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $data = Shelves::where('id', $id)->update([
            'name' => $request->name,
            'position' => $request->position,
            'warehouse_id' => $request->warehouse_id,
            'status' => $request-> status,
        ]);

        return response()->json([
            'message' => 'Data Shelves successfully changed',
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
        $data = Shelves::find($id);
        $data->delete();

        return response()->json([
            'tatus' => 'Delete data Shelves',
            'message' => 'Delete sucessfully',
        ], 201);
    }

    public function destroyItem($id)
    {
        $item = DB::table('detail_items')
            ->where('shelf_id', $id)
            ->get();

        $item->delete();

        return response()->json([
            'tatus' => 'Delete data Shelves',
            'message' => 'Delete sucessfully',
        ], 201);
    }

    public function itemShelf($id)
    {
        // $shelf = DB::table('shelves')
        //     // ->join('warehouses','warehouses.id','=','shelves.warehouse_id')
        //     ->where('warehouse_id',$id)
        //     ->get();


        $item = DB::table('detail_items')
            ->join('items','items.id','=','detail_items.item_id')
            ->join('categories','categories.id','=','detail_items.category_id')
            ->select('detail_items.item_id as id','items.name as itemname',
                'batch_code','categories.name as categoryname',
                'amount','unit','status',
                'warehouse_id','shelf_id')
            ->where('shelf_id',$id)
            ->get();

        return response()->json([
            'message' => 'Data Shelves successfully changed',
            'data' => $item
        ], 201);

    }
    public function amountItem(){
        $count_item = DB::table('detail_items')
            ->select(DB::raw('count(item_id) as countItem'))
            ->groupBy('shelf_id')
            ->get();
        $amount_item =  DB::table('detail_items')
            ->join('shelves','shelves.id','=','detail_items.shelf_id')
            ->select(DB::raw('sum(amount) as amountItem'))
            ->groupBy('shelf_id')
            ->get();
        return response()->json([
            'message' => 'Data warehouse successfully',
            'data' => $count_item,
            'data_amout'=>$amount_item
        ], 201);
    }
    // public function countItem()
    
}
