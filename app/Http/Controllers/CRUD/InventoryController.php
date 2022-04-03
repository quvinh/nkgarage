<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\DetailItem;
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
            'item_id' => 'required',
            'warehouse_id' => 'required',
            'shelf_id' => 'required',
            'created_by' => 'required',
            'code' => 'required',
            'difference' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $data = Inventories::create([
            'code' => $request->code,
            'item_id' => $request->item_id,
            'warehouse_id' => $request->warehouse_id,
            'shelf_id' => $request->shelf_id,
            'amount' => $request->amount,
            'difference' => $request->difference,
            'description' => $request->description,
            'created_by' => $request->created_by,
            'status' => false,
        ]);
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
            'item_id' => 'required',
            'warehouse_id' => 'required',
            'shelf_id' => 'required',
            'created_by' => 'required',
            'code' => 'required',
            'difference' => 'required',
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
            ->join('shelves', 'shelves.id', '=', 'exports.shelf_id')
            ->join('users', 'users.id', '=', 'exports.created_by')
            ->select(
                'exports.item_id',
                'exports.id as id',
                'shelves.name as tenKe',
                'exports.name',
                'warehouses.name as tenKho',
                'exports.code',
                'exports.amount as luongXuat',
                'exports.price',
                'exports.created_at',
                'exports.status',
                'exports.unit',
                'users.fullname as fullname'
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
            ->join('shelves', 'shelves.id', '=', 'imports.shelf_id')
            ->join('users', 'users.id', '=', 'imports.created_by') //join user -> get name
            ->select(
                'imports.item_id',
                'imports.name',
                'shelves.name as tenKe',
                'imports.id as id',
                'warehouses.name as tenKho',
                'imports.code',
                'imports.created_by',
                'imports.amount as luongNhap',
                'imports.price',
                'imports.created_at',
                'imports.status',
                'imports.unit',
                'users.fullname as fullname' //
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
            ->join('users', 'users.id', '=', 'imports.created_by') //join user -> get name
            ->select(
                'warehouses.name as tenKho',
                'imports.code',
                DB::raw('date_format(imports.created_at, "%d/%m/%Y %H:%i") as created_at'),
                // 'imports.created_at',
                'imports.created_by',
                'imports.status',
                'users.fullname as fullname' //
            )
            ->where('imports.deleted_at', null)
            ->groupBy('code')
            ->orderBy('status', 'ASC')
            ->orderByDesc('created_at')
            ->get();

        // $history = DB::select('
        //     SELECT code, MIN(created_at) as created_at,  MAX(status) as status,
        //     (SELECT warehouses.name FROM warehouses JOIN imports ON imports.warehouse_id = warehouses.id WHERE warehouses.id = imports.warehouse_id GROUP BY warehouses.name) "tenKho",
        //     (SELECT users.fullname FROM users JOIN imports ON
        //     imports.created_by = users.id WHERE imports.created_by = users.id GROUP BY users.fullname) as fullname
        //     FROM imports
        //     WHERE deleted_at is NULL
        //     GROUP BY code
        //     ORDER BY status ASC, created_at DESC
        // ');

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
            ->join('users', 'users.id', '=', 'exports.created_by')
            ->select(
                'warehouses.name as tenKho',
                'exports.code',
                DB::raw('date_format(exports.created_at, "%d/%m/%Y %H:%i") as created_at'),
                'exports.created_by',
                'exports.status',
                'users.fullname as fullname'
            )
            ->where('exports.deleted_at', null)
            ->groupBy('code')
            ->orderBy('status', 'ASC')
            ->orderByDesc('created_at')
            ->get();

    // $history = DB::select('
    //     SELECT code, MIN(created_at) as created_at,  MAX(status) as status,
    //     (SELECT warehouses.name FROM warehouses JOIN exports ON exports.warehouse_id = warehouses.id WHERE warehouses.id = exports.warehouse_id GROUP BY warehouses.name) "tenKho",
    //     (SELECT users.fullname FROM users JOIN exports ON
    //     exports.created_by = users.id WHERE exports.created_by = users.id GROUP BY users.fullname) as fullname
    //     FROM exports
    //     WHERE deleted_at is NULL
    //     GROUP BY code
    //     ORDER BY status ASC, created_at DESC
    // ');

        return response()->json([
            'message' => 'Show export data',
            'status' => 'History export',
            'data' => $history
        ], 201);
    }
    public function showCodeTransfer()
    {
        $data = DB::table('transfers')
            ->join('users', 'users.id', '=', 'transfers.created_by')
            ->select(
                'transfers.name_from_warehouse',
                'transfers.name_from_shelf',
                'transfers.name_to_warehouse',
                'transfers.name_to_shelf',
                'transfers.code',
                DB::raw('date_format(transfers.created_at, "%d/%m/%Y %H:%i") as created_at'),
                'transfers.created_by',
                'transfers.status',
                'users.fullname as fullname'
            )
            ->where('transfers.deleted_at', null)
            ->groupBy('transfers.code')
            ->orderBy('status', 'ASC')
            ->orderByDesc('created_at')
            ->get();
        return response()->json([
            'message' => 'Show transfer data',
            'status' => 'History transfer',
            'data' => $data
        ], 201);
    }
    public function showHistoryTransfer($code)
    {
        $data = DB::table('transfers')
            ->join('items', 'items.id', '=', 'transfers.item_id')
            ->join('users', 'users.id', '=', 'transfers.created_by')
            ->select('transfers.*', 'items.name', 'users.fullname as fullname')
            ->where('deleted_at', null)
            ->where('code', $code)
            ->get();
        return response()->json([
            'message' => 'Show transfer data',
            'status' => 'History Transfer',
            'data' => $data
        ], 201);
    }
    public function handleInventory($id)
    {
        $data = DB::table('inventories')
            ->where('id', $id)
            ->get();
        $status = Inventories::where('id', $id)->update([
            'status' => true
        ]);
        $amount = DB::table('detail_items')
            ->where([
                ['item_id', $data[0]->item_id],
                ['warehouse_id', $data[0]->warehouse_id],
                ['shelf_id', $data[0]->shelf_id]
            ])
            ->get('amount');
        $item = DetailItem::where([
            ['item_id', $data[0]->item_id],
            ['warehouse_id', $data[0]->warehouse_id],
            ['shelf_id', $data[0]->shelf_id],
        ])
            ->update([
                'amount' => $amount[0]->amount + $data[0]->difference
            ]);

        return response()->json([
            'message' => 'Inventory Success',
            'data' => $status,
            'data2' => $item
        ], 201);
    }

    public function showHistoryInventory($code)
    {
        $history = DB::table('inventories')
            ->join('warehouses', 'warehouses.id', '=', 'inventories.warehouse_id')
            ->join('detail_items', 'detail_items.item_id', '=', 'inventories.item_id')
            ->join('items', 'items.id', '=', 'inventories.item_id')
            ->join('shelves', 'shelves.id', '=', 'inventories.shelf_id')
            ->join('users', 'users.id', '=', 'inventories.created_by')
            ->select(
                'inventories.item_id',
                'inventories.id as id',
                'shelves.name as shelf_name',
                'warehouses.name as warehouse_name',
                'inventories.code',
                'inventories.amount as amount',
                'detail_items.price',
                'inventories.created_at',
                'inventories.status',
                'items.unit as unit',
                'items.name as name',
                'users.fullname as fullname',
                'difference',
                'description',
            )
            ->where('code', $code)
            ->where('inventories.deleted_at', null)
            ->orderBy('status', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->get();
        return response()->json([
            'message' => 'Show inventories data',
            'status' => 'History Inventories',
            'data' => $history
        ], 201);
    }

    public function showCodeInventory()
    {
        $history = DB::table('inventories')
            ->join('warehouses', 'warehouses.id', '=', 'inventories.warehouse_id')
            ->join('users', 'users.id', '=', 'inventories.created_by')
            ->select(
                'warehouses.name as warehouse_name',
                'inventories.code',
                DB::raw('date_format(inventories.created_at, "%d/%m/%Y %H:%i") as created_at'),
                'inventories.created_by',
                'inventories.status',
                'users.fullname as fullname'
            )
            ->where('inventories.deleted_at', null)
            ->groupBy('code')
            ->orderBy('status', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->get();
        return response()->json([
            'message' => 'Show inventories data',
            'status' => 'History inventories',
            'data' => $history
        ], 201);
    }

    public function deleteCode($code)
    {
        Inventories::where('code', $code)->delete();
        return response()->json([
            'status' => 'Delete data Inventories by code',
            'message' => 'Delete successfully',
        ], 201);
    }
}
