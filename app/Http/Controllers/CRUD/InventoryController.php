<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\Inventories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Inventories::all();
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
            'detail_item_id' => 'required',
            'department' => 'required',
            'description' => 'required',
            'created_by' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $data = Inventories::create($request->all());
        return response()->json([
            'message' => 'Data created successfully',
            'status' => 'Add Inventory',
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
        $data = Inventories::find($id);
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
            'detail_item_id' => 'required',
            'department' => 'required',
            'description' => 'required',
            'created_by' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $data = Inventories::where('id', $id)->update([
            'detail_item_id' => $request->detail_item_id,
            'department' => $request->department,
            'description' => $request->description,
            'created_by' => $request->created_by
        ]);

        return response()->json([
            'message' => 'Data Inventories successfully changed',
            'status' => 'Change Inventory',
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
        $data = Inventories::find($id);
        $data->delete();

        return response()->json([
            'status' => 'Delete data Category',
            'message' => 'Delete successfully',
        ], 201);
    }

    public function showInventExport() {
        $invent = DB::table('exports')
            ->join('detail_items', 'detail_items.item_id', '=', 'exports.item_id')
            ->join('warehouses', 'warehouses.id', '=', 'detail_items.warehouse_id')
            ->select('exports.item_id', 'warehouses.name','exports.created_by', 'exports.amount as luongXuat', 'exports.created_at', 'detail_items.amount as tonKho', 'exports.status')
            ->where('exports.status', 1)
            ->get();
        return response()->json([
            'message' => 'Show export data',
            'status' => 'Xuất đã duyệt',
            'data' => $invent
        ], 201);
    }
    public function showInventImport() {
        $invent = DB::table('imports')
            ->join('detail_items', 'detail_items.item_id', '=', 'imports.item_id')
            ->join('warehouses', 'warehouses.id', '=', 'detail_items.warehouse_id')
            ->select('imports.item_id', 'warehouses.name', 'imports.created_by', 'imports.amount as luongNhap', 'imports.created_at', 'detail_items.amount as tonKho', 'imports.status')
            ->where('imports.status', 1)
            ->get();
        return response()->json([
            'message' => 'Show import data',
            'status' => 'Nhập đã duyệt',
            'data' => $invent
        ], 201);
    }
}
