<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\Shelves;
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
            'position' => 'required',
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
            'position' => $request->position
        ]);

        return response()->json([
            'message' => 'Data Shelves successfully changed',
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
        $data = Shelves::find($id);
        $data->delete();

        return response()->json([
            'status' => 'Delete data Shelves',
            'message' => 'Delete successfully',
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
                'amount','unit','status')
            ->where('shelf_id',$id)
            ->get();

        return response()->json([
            'message' => 'Data Shelves successfully changed',
            'data' => $item
        ], 201);

    }
}
