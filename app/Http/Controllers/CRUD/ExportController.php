<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\DetailItem;
use App\Models\Export;
use App\Models\Item;
use App\Models\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Export::all();
        return response()->json([
            'data' => $data
        ], 201);
    }
    public function indexStatus()
    {
        //
        $data = DB::table('exports')
            ->where('status', 0)
            ->get();

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
            'amount' => 'required',
            'unit' => 'required',
            'created_by' => 'required',
            'supplier_id' => 'required',
            'shelf_id' => 'required',
            'price' => 'required',
            'code' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $detail_item = DB::table('detail_items')
            ->where([
                ['warehouse_id', '=', $request->warehouse_id],
                ['shelf_id', '=', $request->shelf_id],
                ['item_id', '=', $request->item_id],
                ['batch_code', '=', $request->batch_code],
                ['supplier_id', '=', $request->supplier_id]
            ])
            ->get();
        $item = DB::table('items')
            ->where('id', $detail_item[0]->item_id)
            ->get();
        if ($detail_item->count() > 0) {
            if ($request->amount <= $detail_item[0]->amount) {
                $newExport = new Export();
                $newExport->item_id = $request->item_id;
                $newExport->code = $request->code;
                $newExport->amount = $request->amount;
                $newExport->price = $request->price;
                $newExport->warehouse_id = $request->warehouse_id;
                $newExport->shelf_id = $request->shelf_id;
                $newExport->supplier_id = $request->supplier_id;
                $newExport->batch_code = $request->batch_code;
                $newExport->name = $item[0]->name;
                $newExport->unit = $request->unit;
                $newExport->created_by = $request->created_by;
                $newExport->status = '0';
                $newExport->note = null;
                $newExport->save();
                return response()->json([
                    'message' => 'Data created successfully',
                    'status' => 'Add Export'
                ], 201);
            }
        }
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
        $data = Export::find($id);
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
            'warehouse_id' => 'required',
            'amount' => 'required',
            'unit' => 'required',
            'status' => 'required',
            'created_by' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $data = Export::where('id', $id)->update([
            'shelf_id' => $request->shelf_id,
            'code' => $request->code,
            'detail_item_id' => $request->detail_item_id,
            'warehouse_id' => $request->warehouse_id,
            'amount' => $request->amount,
            'price' => $request->price,
            'unit' => $request->unit,
            'status' => $request->status,
            'created_by' => $request->created_by
        ]);

        return response()->json([
            'message' => 'Data Export successfully changed',
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
        $data = Export::find($id);
        $data->delete();

        return response()->json([
            'status' => 'Delete data Category',
            'message' => 'Delete successfully',
        ], 201);
    }
    public function updateStatus($id)
    {
        $export_item = DB::table('exports')
            ->where('id', $id)
            ->get();
        $detail_item = DB::table('detail_items')
            ->where([
                ['warehouse_id', '=', $export_item[0]->warehouse_id],
                ['shelf_id', '=', $export_item[0]->shelf_id],
                ['item_id', '=', $export_item[0]->item_id],
                ['supplier_id', '=', $export_item[0]->supplier_id],
                ['batch_code', '=', $export_item[0]->batch_code]
            ])
            ->get();
        if ($detail_item[0]->amount >= $export_item[0]->amount) {
            Export::where('id', $id)->update(['status' => '2']);
            DetailItem::where([
                ['warehouse_id', '=', $export_item[0]->warehouse_id],
                ['shelf_id', '=', $export_item[0]->shelf_id],
                ['item_id', '=', $export_item[0]->item_id],
                ['supplier_id', '=', $export_item[0]->supplier_id],
                ['batch_code', '=', $export_item[0]->batch_code]
            ])
                ->update(['amount' => $detail_item[0]->amount - $export_item[0]->amount]);
            return response()->json([
                'message' => 'Data Export successfully changed',
                'status' => 'Changed Status',
                'data' => 1
            ], 201);
        } else {
            return response()->json([
                'message' => 'Thiếu vật tư',
                'status' => 'Không thể duyệt',
                'data' => 0
            ], 201);
        }
    }
    public function dStatus($id)
    {
        $export_item = DB::table('exports')
            ->where('id', $id)
            ->get();
        ///số lượng khả dụng của vật tư
        $export = DB::table('exports')
            ->where([
                ['item_id', $export_item[0]->item_id], ['warehouse_id', $export_item[0]->warehouse_id],
                ['shelf_id', $export_item[0]->shelf_id], ['status', 1], ['deleted_at', null],
                ['batch_code', $export_item[0]->batch_code], ['supplier_id', $export_item[0]->supplier_id]
            ])
            ->selectRaw('sum(amount) as amount')
            ->get();
        $detail_item = DB::table('detail_items')
            ->where([
                ['item_id', $export_item[0]->item_id], ['warehouse_id', $export_item[0]->warehouse_id], ['shelf_id', $export_item[0]->shelf_id],
                ['batch_code', $export_item[0]->batch_code], ['supplier_id', $export_item[0]->supplier_id]
            ])
            ->get();
        $transfer = DB::table('transfers')
            ->where([
                ['item_id', $export_item[0]->item_id], ['from_warehouse', $export_item[0]->warehouse_id],
                ['from_shelf', $export_item[0]->shelf_id], ['status', 1], ['deleted_at', null],
                ['batch_code', $export_item[0]->batch_code], ['supplier_id', $export_item[0]->supplier_id]
            ])
            ->selectRaw('sum(amount) as amount')
            ->get();

        if ($export->count() > 0) $ex = $export[0]->amount;
        else $ex = 0;

        if ($transfer->count() > 0) $tf = $transfer[0]->amount;
        else $tf = 0;

        $kd = $detail_item[0]->amount - $ex - $tf;

        ///thay đổi trạng thái phiếu xuất

        if ($kd >= $export_item[0]->amount) {
            Export::where('id', $id)->update(['status' => '1']);
            return response()->json([
                'message' => 'Data Export successfully changed',
                'status' => 'Changed Status',
                'data' => 1
            ], 201);
        } else {
            return response()->json([
                'message' => 'Thiếu vật tư',
                'status' => 'Không thể duyệt',
                'data' => 0
            ], 201);
        }
    }
    public function deleteCode($code)
    {
        $export = Export::where('code', $code)->delete();
        return response()->json([
            'status' => 'Delete data Imports by code',
            'message' => 'Delete successfully',
        ], 201);
    }
}
