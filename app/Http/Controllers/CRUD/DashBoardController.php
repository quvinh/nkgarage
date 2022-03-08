<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
        $export = DB::table('exports')
            ->select(DB::raw('sum(exports.amount) as exportAmount'), DB::raw('date_format(created_at, "%M") as month, year(created_at) as year'))
            ->where('deleted_at', null)
            ->orderBy('created_at', 'asc')
            ->groupBy('month', 'status')
            ->having('status', 2)
            ->having('year', $year)
            ->get();
        return response()->json([
            'message' => 'Data DashBoard',
            'status' => 'DashBoard',
            'data' => $export,
        ], 201);
    }

    public function import($year)
    {
        $import = DB::table('imports')
            ->select(DB::raw('sum(imports.amount) as importAmount'), DB::raw('date_format(created_at, "%M") as month, year(created_at) as year'))
            ->where('deleted_at', null)
            ->orderBy('created_at', 'asc')
            ->groupBy('month', 'year', 'status')
            ->having('status', 2)
            ->having('year', $year)
            ->get();
        return response()->json([
            'message' => 'Data DashBoard',
            'status' => 'DashBoard',
            'data' => $import,
        ], 201);
    }

    public function solgKho()
    {
        $solgKho = DB::table('warehouses')
            ->select(DB::raw('count(id) as solgKho'))
            ->where('status',true)
            ->get();
        return response()->json([
            'message' => 'Data DashBoard',
            'status' => 'DashBoard',
            'data' => $solgKho,
        ], 201);
    }
    public function tonKho()
    {
        $tonKho = DB::table('detail_items')
            ->join('warehouses', 'warehouses.id', '=', 'detail_items.warehouse_id')
            ->select(DB::raw('sum(amount * price) as total,sum(amount) as tonKho'))
            ->addSelect( 'warehouses.id', 'name', 'warehouses.status')
            ->groupBy('warehouse_id', 'name')
            ->get();
        return response()->json([
            'message' => 'Data DashBoard',
            'status' => 'DashBoard',
            'data' => $tonKho,
        ], 201);
    }
    public function exportCode ($month, $year)
    {
        $exportCode = DB::table('exports')
        ->select(DB::raw('count(code) as exportCode, date_format(created_at, "%M") as month, day(created_at) as day'))
        ->groupBy('month', 'day', 'status')
        ->having('status', 2)
        ->having('month',$month)
        ->having('year', $year)
        ->get();
        return response()->json([
            'message' => 'Data DashBoard',
            'status' => 'DashBoard',
            'data' => $exportCode,
        ], 201);
    }
    public function importCode ($month, $year)
    {
        $importCode = DB::table('imports')
        ->select(DB::raw('count(code) as importCode, date_format(created_at, "%M") as month, day(created_at) as day,year(created_at) as year'))
        ->groupBy('month', 'day', 'status')
        ->having('status', 2)
        ->having('month',$month)
        ->having('year', $year)
        ->get();
        return response()->json([
            'message' => 'Data DashBoard',
            'status' => 'DashBoard',
            'data' => $importCode,
        ], 201);
    }

}
