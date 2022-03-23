<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    }
    public function export($year)
    {
        // $warehouse = DB::table('warehouses')
        //     ->get('id');
        // $count = DB::table('warehouses')
        //     ->get('id')
        //     ->count();

        $export = DB::table('exports')
            ->join('warehouses', 'warehouses.id', '=', 'exports.warehouse_id')
            ->select(DB::raw('sum(exports.amount) as exportAmount'), DB::raw('date_format(created_at, "%M") as month, year(created_at) as year'), 'warehouses.name as warehouse_name', 'warehouse_id')
            // ->where('exports.warehouse_id',$warehouse)
            // ->where('deleted_at', null)
            ->orderBy('created_at', 'asc')
            ->groupBy('month', 'year', 'exports.status')
            ->having('status', 2)
            ->having('year', $year)
            ->get();
        // for ($i = 0; $i < count($warehouse); $i++) {
        //     for ($j = 0; $j < count($export); $j++) {
        //         if ($export[$j]->warehouse_id != $warehouse[$i]) {
        //             $export[$j]->exportAmount = 0;
        //         }
        //     }
        // }
        return response()->json([
            // 'listWarehouse' => $warehouse,
            'message' => 'Data DashBoard',
            // 'status' => 'DashBoard',
            'data' => $export,
            // 'count' => $count
        ], 201);
    }

    public function import($year)
    {
        $import = DB::table('imports')
            ->join('warehouses', 'warehouses.id', '=', 'imports.warehouse_id')
            ->select(DB::raw('sum(imports.amount) as importAmount'), DB::raw('date_format(created_at, "%M") as month, year(created_at) as year'), 'warehouses.name as warehouse_name', 'warehouse_id')
            // ->where('deleted_at', null)
            ->orderBy('created_at', 'asc')
            ->groupBy('month', 'year', 'imports.status', 'warehouse_id')
            ->having('status', 2)
            ->having('year', $year)
            ->get();
        // dd($import = $import->toArray());
        // $import = DB::table('warehouses')
        //     ->join('exports', 'exports.warehouse_id', '=', 'warehouses.id')
        //     ->join('imports', 'imports.warehouse_id', '=', 'warehouses.id')
        //     ->select(DB::raw('sum(imports.amount) as importAmount'),DB::raw('sum(exports.amount) as exportAmount'), DB::raw('date_format(imports.created_at, "%M") as month, year(imports.created_at) as year'),DB::raw('date_format(exports.created_at, "%M") as month, year(exports.created_at) as year'), 'warehouses.name')
        //     // ->where('deleted_at', null)
        //     ->orderBy('imports.created_at', 'asc')
        //     ->groupBy('month', 'year', 'imports.status','exports.status', 'exports.warehouse_id', 'imports.warehouse_id')
        //     ->where('exports.status',2)
        //     ->where('imports.status',2)
        //     // ->having('exports.status', 2)
        //     // ->having('imports.status', 2)
        //     ->having('year', $year)
        //     ->get();
        return response()->json([
            'data' => $import,
            'message' => 'Data DashBoard',
            // 'status' => 'DashBoard',

        ], 201);
    }

    public function tonKho($id)
    {
        $tonKho = DB::table('detail_items')
            ->join('warehouses', 'warehouses.id', '=', 'detail_items.warehouse_id')
            ->select(DB::raw('sum(amount * price) as total,sum(amount) as tonKho'))
            ->addSelect('warehouse_id', 'name', 'warehouses.status as status')
            ->where('warehouses.id', $id)
            ->get();
        return response()->json([
            'message' => 'Data DashBoard',
            'status' => 'DashBoard',
            'data' => $tonKho,
        ], 201);
    }
    public function tongTonKho()
    {
        $tongTonKho = DB::table('detail_items')
            ->join('warehouses', 'warehouses.id', '=', 'detail_items.warehouse_id')
            ->select(DB::raw('sum(amount * price) as total,sum(amount) as tonKho'))
            ->addSelect('warehouse_id', 'name', 'warehouses.status')
            ->groupBy('warehouse_id', 'name')
            ->get();
        return response()->json([
            'message' => 'Data DashBoard',
            'status' => 'DashBoard',
            'data' => $tongTonKho,
        ], 201);
    }
    public function exportByWarehouse($id, $year)
    {
        $export = DB::table('exports')
            ->select(DB::raw('sum(exports.amount) as exportAmount'), DB::raw('date_format(created_at, "%M") as month, year(created_at) as year'),)
            ->orderBy('created_at', 'asc')
            ->groupBy('month', 'year', 'status', 'warehouse_id')
            ->having('status', 2)
            ->having('warehouse_id', $id)
            ->having('year', $year)
            ->get();
        return response()->json([
            'message' => 'Data DashBoard',
            'status' => 'DashBoard',
            'data' => $export,
        ], 201);
    }
    public function importByWarehouse($id, $year)
    {
        $import = DB::table('imports')
            ->select(DB::raw('sum(imports.amount) as importAmount'), DB::raw('date_format(created_at, "%M") as month, year(created_at) as year'))
            ->orderBy('created_at', 'asc')
            ->groupBy('month', 'year', 'status', 'warehouse_id')
            ->having('status', 2)
            ->having('warehouse_id', $id)
            ->having('year', $year)
            ->get();
        return response()->json([
            'message' => 'Data DashBoard',
            'status' => 'DashBoard',
            'data' => $import,
        ], 201);
    }

    public function listInWarehouse($id)
    {
        $tongTonKho = DB::table('detail_items')
            ->join('items', 'items.id', '=', 'detail_items.item_id')
            ->select(DB::raw('sum(amount * price) as total,sum(amount) as tonKho, name, item_id'))
            ->orderBy('total', 'desc')
            // ->addSelect( 'warehouse_id', 'name', 'warehouses.status')
            ->where('warehouse_id', $id)
            ->groupBy('item_id')
            ->get();
        return response()->json([
            'message' => 'Data DashBoard',
            'status' => 'DashBoard',
            'data' => $tongTonKho,
        ], 201);
    }

    public function exportImport($year)
    {
        $data = DB::table('warehouses')
            ->join('exports', 'exports.warehouse_id', '=', 'warehouses.id')
            ->join('imports', 'imports.warehouse_id', '=', 'warehouses.id')
            ->select(DB::raw('sum(imports.amount) as importAmount'), DB::raw('sum(exports.amount) as exportAmount'), DB::raw('date_format(created_at, "%M") as month, year(created_at) as year'), 'warehouses.name')
            // ->where('deleted_at', null)
            ->orderBy('created_at', 'asc')
            ->groupBy('month', 'year', 'imports.status', 'exports.status', 'warehouse_id')
            ->having('status', 2)
            ->having('year', $year)
            ->get();
    }
}
