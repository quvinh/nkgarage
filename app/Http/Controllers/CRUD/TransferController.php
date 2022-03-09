<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\DetailItem;
use App\Models\Notification;
use App\Models\Transfers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Transfers::all();
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
            'code' => 'required',
            'supplier_id' => 'required',
            'category_id' => 'required',
            'fromWarehouse' => 'required',
            'fromShelf' => 'required',
            'toWarehouse' => 'required',
            'toShelf' => 'required',
            'amount' => 'required',
            'unit' => 'required',
            'created_by' => 'required',
            // 'status' => 'required'

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $detail_item = DB::table('detail_items')
            ->where([
                ['item_id', $request->item_id],
                ['warehouse_id', $request->fromWarehouse],
                ['shelf_id', $request->fromShelf],
                ['supplier_id', $request->supplier_id]
            ])
            ->get();

        if ($detail_item->count() > 0) {
            if ($request->amount <= $detail_item[0]->amount) {
                $newTransfer = new Transfers();
                $newTransfer->item_id = $request->item_id;
                $newTransfer->code = $request->code;
                $newTransfer->name = $request->name;
                $newTransfer->amount = $request->amount;
                $newTransfer->unit = $request->unit;
                $newTransfer->status = 0;
                $newTransfer->from_warehouse = $request->fromWarehouse;
                $newTransfer->to_warehouse = $request->toWarehouse;
                $newTransfer->from_shelf = $request->fromShelf;
                $newTransfer->to_shelf = $request->toShelf;
                $newTransfer->name_from_warehouse = $request->nameFromWarehouse;
                $newTransfer->name_to_warehouse = $request->nameToWarehouse;
                $newTransfer->name_from_shelf = $request->nameFromShelf;
                $newTransfer->name_to_shelf = $request->nameToShelf;
                $newTransfer->supplier_id = $request->supplier_id;
                $newTransfer->created_by = $request->created_by;
                $newTransfer->note = $request->note;
                $newTransfer->save();
                return response()->json([
                    'message' => 'Data created successfully',
                    'status' => 'Add Transfer',
                    'data' => $newTransfer,
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
        $data = Transfers::find($id);
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
            'amount' => 'required',
            'unit' => 'required',
            'status' => 'required',
            'created_by' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $data = Transfers::where('id', $id)->update([
            'detail_item_id' => $request->id,
            'amount' => $request->amount,
            'from' => $request->from,
            'to' => $request->to,
            'unit' => $request->unit,
            'status' => $request->status,
            'created_by' => $request->created_by,
            'note' => $request->note
        ]);

        return response()->json([
            'message' => 'Data Transfers successfully changed',
            'status' => ' Updated Data',
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
        $data = Transfers::find($id);
        $data->delete();

        return response()->json([
            'status' => 'Delete data Category',
            'message' => 'Delete successfully',
        ], 201);
    }
    public function updateStatus($id)
    {
        $transfer = DB::table('transfers')
            ->where('id', $id)
            ->get();

        $detail_item_from = DB::table('detail_items')
            ->where([
                ['item_id', $transfer[0]->item_id],
                ['warehouse_id', $transfer[0]->from_warehouse],
                ['shelf_id', $transfer[0]->from_shelf],
                ['supplier_id', $transfer[0]->supplier_id]
            ])
            ->get();

        $detail_item_to = DB::table('detail_items')
            ->where([
                ['item_id', $transfer[0]->item_id],
                ['warehouse_id', $transfer[0]->to_warehouse],
                ['shelf_id', $transfer[0]->to_shelf],
                ['supplier_id', $transfer[0]->supplier_id]
            ])
            ->get();

        $count_to = DB::table('detail_items')
            ->where([
                ['item_id', $transfer[0]->item_id],
                ['warehouse_id', $transfer[0]->to_warehouse],
                ['shelf_id', $transfer[0]->to_shelf],
                ['supplier_id', $transfer[0]->supplier_id]
            ])
            ->get()->count();
        Transfers::where('id', $id)->update(['status' => '2']);
        if ($detail_item_from[0]->amount >= $transfer[0]->amount) {
            DetailItem::where([
                ['item_id', $transfer[0]->item_id],
                ['warehouse_id', $transfer[0]->from_warehouse],
                ['shelf_id', $transfer[0]->from_shelf],
                ['supplier_id', $transfer[0]->supplier_id]
            ])
                ->update(['amount' => $detail_item_from[0]->amount - $transfer[0]->amount]);

            if ($count_to > 0) {
                DetailItem::where([
                    ['item_id', $transfer[0]->item_id],
                    ['warehouse_id', $transfer[0]->to_warehouse],
                    ['shelf_id', $transfer[0]->to_shelf],
                    ['supplier_id', $transfer[0]->supplier_id]
                ])
                    ->update(['amount' => ($detail_item_to[0]->amount) + $transfer[0]->amount]);
            } else {
                $newDetail_Item = new DetailItem();
                $newDetail_Item->item_id = $transfer[0]->item_id;
                $newDetail_Item->category_id = $detail_item_from[0]->category_id;
                $newDetail_Item->warehouse_id = $transfer[0]->to_warehouse;
                $newDetail_Item->shelf_id = $transfer[0]->to_shelf;
                $newDetail_Item->supplier_id = $transfer[0]->supplier_id;
                $newDetail_Item->amount = $transfer[0]->amount;
                $newDetail_Item->unit = $transfer[0]->unit;
                $newDetail_Item->price = $detail_item_from[0]->price;
                $newDetail_Item->status = 0;
                $newDetail_Item->batch_code = $detail_item_from[0]->batch_code;
                $newDetail_Item->save();
                return response()->json([
                    'message' => 'Data created successfully',
                    'status' => 'Add Detail_Item'
                ], 201);
            }
            return response()->json([
                'message' => 'Data Transfer successfully changed',
                'status' => 'Changed Status',
            ], 201);
        }
    }
    public function dStatus($id)
    {
        $transfer_item = DB::table('transfers')
            ->where('id', $id)
            ->get();

        ///số lượng khả dụng của vật tư
        $export = DB::table('exports')
            ->where([['item_id', $transfer_item[0]->item_id], ['warehouse_id', $transfer_item[0]->warehouse_id], ['shelf_id', $transfer_item[0]->shelf_id], ['status', 1]])
            ->selectRaw('sum(amount) as amount')
            ->get();
        $detail_item = DB::table('detail_items')
            ->where([['item_id', $transfer_item[0]->item_id], ['warehouse_id', $transfer_item[0]->warehouse_id], ['shelf_id', $transfer_item[0]->shelf_id]])
            ->get();
        $transfer = DB::table('transfers')
            ->where([['item_id', $transfer_item[0]->item_id], ['from_warehouse', $transfer_item[0]->warehouse_id], ['from_shelf', $transfer_item[0]->shelf_id], ['status', 1]])
            ->selectRaw('sum(amount) as amount')
            ->get();
        if ($export->count() > 0) $ex = $export[0]->amount;
        else $ex = 0;
        if ($transfer->count() > 0) $tf = $transfer[0]->amount;
        else $tf = 0;

        $kd = $detail_item[0]->amount - $ex - $tf;
        ///thay đổi trạng thái phiếu chuyển kho
        if ($kd >= $transfer_item[0]->amount) {
            $dStatus =  Transfers::where('id', $id)->update(['status' => '1']);
            return response()->json([
                'message' => 'Data Transfer successfully changed',
                'status' => 'Changed Status',
                'data' => $dStatus,
            ], 201);
        }
    }
}
