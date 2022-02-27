<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\DetailItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DetailitemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DetailItem::All();
        return response()->json([
            'data' => $data
        ],201);
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
            'item_id' => 'required',
            'category_id' => 'required',
            'warehouse_id' => 'required',
            'shelf_id' => 'required',
            'batch_code' => 'required',
            'amount' => 'required',
            'unit' => 'required',
            'price' => 'required'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),400);
        }
        $data = DetailItem::create($request->all());

        return response()->json([
            'message' => 'Data created successfully',
            'data' => $data
        ],201);
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
        $data = DetailItem::find($id);
        
        return response()->json([
            'status' => 'show form edit',
            'message' => 'show successfully',
            'data' => $data
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
        $validator = Validator::make($request->all(),[
            'item_id' => 'required',
            'category_id' => 'required',
            'warehouse_id' => 'required',
            'shelf_id' => 'required',
            'batch_code' => 'required',
            'amount' => 'required',
            'unit' => 'required',
            'price' => 'required'
        ]);

        if($validator -> fails()) {
            return response()->json($validator->errors()->toJson(),400);
        }

        $data = DetailItem::where('id', $id)->update([
            'item_id' => $request->item_id,
            'category_id' => $request->category_id,
            'warehouse_id' =>$request->warehouse_id,
            'shelf_id' => $request->shelf_id,
            'batch_code' => $request->batch_code,
            'amount' => $request->amount,
            'unit'=>$request->unit,
            'price'=>$request->price,
            'status' =>$request->status
        ]);

        return response()->json([
            'message' => 'Data Import successfully changed',
            'data' =>$data
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = DetailItem::find($id);
        $data->delete();

        return response()->json([
            'tatus' => 'Delete data Permissions',
            'message' => 'Delete sucessfully',
        ], 201);
    }

    
}
