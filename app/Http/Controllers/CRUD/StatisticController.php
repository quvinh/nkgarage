<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function importByDay(Request $request)
    {
        $import = DB::table('imports')
            ->join('shelves', 'shelves.id', '=', 'imports.shelf_id')
            ->join('suppliers', 'suppliers.id', '=', 'imports.supplier_id')
            ->select(
                'imports.item_id',
                'imports.name',
                'imports.amount',
                'shelves.name as shelf_name',
                'suppliers.name as supplier_name',
                'imports.unit',
                'imports.price',
                'imports.created_at'
            )
            ->orderBy('imports.created_at', 'asc')
            ->groupBy('imports.shelf_id')
            ->where([
                ['imports.status', 2],
                [DB::raw('day(imports.created_at)'), $request->day],
                [DB::raw('year(imports.created_at)'), $request->year],
                [DB::raw('month(imports.created_at)'), $request->month],
                ['imports.warehouse_id', $request->warehouse_id],

            ])
            ->get();
        return response()->json([
            'message' => 'Statistic By Day',
            'status' => 'Import',
            'data' => $import,
        ], 201);
    }
    public function importByMonth(Request $request)
    {
        $import = DB::table('imports')
            ->join('shelves', 'shelves.id', '=', 'imports.shelf_id')
            ->join('suppliers', 'suppliers.id', '=', 'imports.supplier_id')
            ->select(
                'imports.item_id',
                'imports.name',
                'imports.amount',
                'shelves.name as shelf_name',
                'suppliers.name as supplier_name',
                'imports.unit',
                'imports.price',
                'imports.created_at'
            )
            ->orderBy('imports.created_at', 'asc')
            ->groupBy('imports.shelf_id')
            ->where([
                ['imports.status', 2],
                [DB::raw('year(imports.created_at)'), $request->year],
                [DB::raw('month(imports.created_at)'), $request->month],
                ['imports.warehouse_id', $request->warehouse_id],

            ])
            ->get();
        return response()->json([
            'message' => 'Statistic By Month',
            'status' => 'Import',
            'data' => $import,
        ], 201);
    }
    public function importByYear(Request $request)
    {
        $import = DB::table('imports')
            ->join('shelves', 'shelves.id', '=', 'imports.shelf_id')
            ->join('suppliers', 'suppliers.id', '=', 'imports.supplier_id')
            ->select(
                'imports.item_id',
                'imports.name',
                'imports.amount',
                'shelves.name as shelf_name',
                'suppliers.name as supplier_name',
                'imports.unit',
                'imports.price',
                'imports.created_at'
            )
            ->orderBy('imports.created_at', 'asc')
            ->groupBy('imports.shelf_id')
            ->where([
                ['imports.status', 2],
                [DB::raw('year(imports.created_at)'), $request->year],
                ['imports.warehouse_id', $request->warehouse_id],

            ])
            ->get();
        return response()->json([
            'message' => 'Statistic By Year',
            'status' => 'Import',
            'data' => $import,
        ], 201);

    }
    public function exportByDay(Request $request)
    {
        $export = DB::table('exports')
            ->join('shelves', 'shelves.id', '=', 'exports.shelf_id')
            ->select(
                'exports.item_id',
                'exports.name',
                'exports.amount',
                'shelves.name as shelf_name',
                'exports.unit',
                'exports.price',
                'exports.created_at'
            )
            ->orderBy('exports.created_at', 'asc')
            ->groupBy('exports.shelf_id')
            ->where([
                ['exports.status', 2],
                [DB::raw('day(exports.created_at)'), $request->day],
                [DB::raw('year(exports.created_at)'), $request->year],
                [DB::raw('month(exports.created_at)'), $request->month],
                ['exports.warehouse_id', $request->warehouse_id],

            ])
            ->get();
        return response()->json([
            'message' => 'Statistic By Day',
            'status' => 'Export',
            'data' => $export,
        ], 201);
    }
    public function exportByMonth(Request $request)
    {
        $export = DB::table('exports')
            ->join('shelves', 'shelves.id', '=', 'exports.shelf_id')
            ->select(
                'exports.item_id',
                'exports.name',
                'exports.amount',
                'shelves.name as shelf_name',
                'exports.unit',
                'exports.price',
                'exports.created_at'
            )
            ->orderBy('exports.created_at', 'asc')
            ->groupBy('exports.shelf_id')
            ->where([
                ['exports.status', 2],
                [DB::raw('year(exports.created_at)'), $request->year],
                [DB::raw('month(exports.created_at)'), $request->month],
                ['exports.warehouse_id', $request->warehouse_id],

            ])
            ->get();
        return response()->json([
            'message' => 'Statistic By Month',
            'status' => 'Export',
            'data' => $export,
        ], 201);
    }
    public function exportByYear(Request $request)
    {
        $export = DB::table('exports')
            ->join('shelves', 'shelves.id', '=', 'exports.shelf_id')
            ->select(
                'exports.item_id',
                'exports.name',
                'exports.amount',
                'shelves.name as shelf_name',
                'exports.unit',
                'exports.price',
                'exports.created_at'
            )
            ->orderBy('exports.created_at', 'asc')
            ->groupBy('exports.shelf_id')
            ->where([
                ['exports.status', 2],
                [DB::raw('year(exports.created_at)'), $request->year],
                ['exports.warehouse_id', $request->warehouse_id],

            ])
            ->get();
        return response()->json([
            'message' => 'Statistic By Year',
            'status' => 'Export',
            'data' => $export,
        ], 201);

    }
    public function transferByDay(Request $request)
    {
        $transfer = DB::table('transfers')
            ->orderBy('transfers.created_at', 'asc')
            ->groupBy('transfers.from_shelf')
            ->where([
                ['transfers.status', 2],
                [DB::raw('day(transfers.created_at)'), $request->day],
                [DB::raw('year(transfers.created_at)'), $request->year],
                [DB::raw('month(transfers.created_at)'), $request->month],
                ['transfers.from_warehouse', $request->warehouse_id],

            ])
            ->get();
        return response()->json([
            'message' => 'Statistic By Day',
            'status' => 'transfer',
            'data' => $transfer,
        ], 201);
    }
    public function transferByMonth(Request $request)
    {
        $transfer = DB::table('transfers')
            ->orderBy('transfers.created_at', 'asc')
            ->groupBy('transfers.from_shelf')
            ->where([
                ['transfers.status', 2],
                [DB::raw('year(transfers.created_at)'), $request->year],
                [DB::raw('month(transfers.created_at)'), $request->month],
                ['transfers.from_warehouse', $request->warehouse_id],

            ])
            ->get();
        return response()->json([
            'message' => 'Statistic By Month',
            'status' => 'transfer',
            'data' => $transfer,
        ], 201);
    }
    public function transferByYear(Request $request)
    {
        $transfer = DB::table('transfers')
            ->orderBy('transfers.created_at', 'asc')
            ->groupBy('transfers.from_shelf')
            ->where([
                ['transfers.status', 2],
                [DB::raw('year(transfers.created_at)'), $request->year],
                ['transfers.from_warehouse', $request->warehouse_id],

            ])
            ->get();
        return response()->json([
            'message' => 'Statistic By Year',
            'status' => 'transfer',
            'data' => $transfer,
        ], 201);

    }
}
