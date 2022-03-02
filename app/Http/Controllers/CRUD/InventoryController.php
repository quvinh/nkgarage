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
    public function showHistoryExport($code)
    {
        $history = DB::table('exports')
            ->join('warehouses', 'warehouses.id', '=', 'exports.warehouse_id')
            ->select(
                'exports.item_id',
                'exports.id as id',
                'exports.shelf_id',
                'exports.name',
                'warehouses.name as tenKho',
                'exports.code',
                'exports.created_by',
                'exports.amount as luongXuat',
                'exports.price',
                'exports.created_at',
                'exports.status'
            )
            ->where('code', $code)
            ->where('exports.deleted_at', null)
            ->get();
        return response()->json([
            'message' => 'Show export data',
            'status' => 'History Export',
            'data' => $history
        ], 201);
    }
    public function showHistoryImport($code)
    {
        $history = DB::table('imports')
            ->join('warehouses', 'warehouses.id', '=', 'imports.warehouse_id')
            ->select(
                'imports.item_id',
                'imports.name',
                'imports.shelf_id',
                'imports.id as id',
                'warehouses.name as tenKho',
                'imports.code',
                'imports.created_by',
                'imports.amount as luongNhap',
                'imports.price',
                'imports.created_at',
                'imports.status'
            )
            ->where('code', $code)
            ->where('imports.deleted_at', null)
            ->get();
        return response()->json([
            'message' => 'Show import data',
            'status' => 'History Import',
            'data' => $history
        ], 201);
    }
    public function showCodeImport()
    {
        $history = DB::table('imports')
            ->join('warehouses', 'warehouses.id', '=', 'imports.warehouse_id')
            ->select(
                'warehouses.name as tenKho',
                'imports.code',
                DB::raw('date_format(imports.created_at, "%d/%m/%Y %H:%i") as created_at'),
                'imports.created_by',
                'imports.status'
            )
            ->where('imports.deleted_at', null)
            ->groupBy('code')
            ->get();
        return response()->json([
            'message' => 'Show import data',
            'status' => 'History Import',
            'data' => $history
        ], 201);
    }
    public function showCodeExport()
    {
        $history = DB::table('exports')
            ->join('warehouses', 'warehouses.id', '=', 'exports.warehouse_id')
            ->select(
                'warehouses.name as tenKho',
                'exports.code',
                DB::raw('date_format(exports.created_at, "%d/%m/%Y %H:%i") as created_at'),
                'exports.created_by',
                'exports.status'
            )
            ->where('exports.deleted_at', null)
            ->groupBy('code')
            ->get();
        return response()->json([
            'message' => 'Show export data',
            'status' => 'History export',
            'data' => $history
        ], 201);
    }
}
