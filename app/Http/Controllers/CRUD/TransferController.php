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
            'warehouse_id' => 'required',
            'amount' => 'required',
            'from' =>'required',
            'to' => 'required',
            'unit' => 'required',
            'created_by' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $count_item = DB::table('detail_items')
            ->where([['item_id', $request->item_id], ['warehouse_id', $request->from]])
            ->get()
            ->count();

        $detail_item = DB::table('detail_items')
            ->where('item_id', $request->id)
            ->get();

        if ($count_item > 0) {
            if ($request->amount <= $detail_item[0]->amount) {
                $newTransfer = new Transfers();
                $newTransfer->detail_item_id = $detail_item[0]->id;
                $newTransfer->amount = $request->amount;
                $newTransfer->unit = $request->unit;
                $newTransfer->status = 0;
                $newTransfer->from = $request->from;
                $newTransfer->to = $request->to;
                $newTransfer->created_by = $request->created_by;
                $newTransfer->note = $request->note;
                $newTransfer->save();
                return response()->json([
                    'message' => 'Data created successfully',
                    'status' => 'Add Transfer'
                ], 201);
            }
        } else {
            $newNotify = new Notification();
            $newNotify->detail_item = null;
            $newNotify->title = 'Thiếu vật tư';
            $newNotify->content = 'Không thể chuyển vật tư';
            $newNotify->amount = $request->amount;
            $newNotify->unit = $request->unit;
            $newNotify->created_by = 'Hệ thống';
            $newNotify->save();
            return response()->json([
                'message' => 'Data created successfully',
                'status' => 'Add Notify'
            ], 201);
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
        $transfer = DB::table('transfers')
            ->where('id', $id)
            ->get();
        $detail_item_from = DB::table('detail_items')
            ->where('warehouse_id', $transfer[0]->from)
            ->get();
        $detail_item_to = DB::table('detail_items')
            ->where('warehouse_id', $transfer[0]->to)
            ->get();
        if ($request->status === 1) {
            DetailItem::where('warehouse_id', $transfer[0]->from)->update(['amount' => $detail_item_from[0]->amount - $transfer->amount]);
            DetailItem::where('warehouse_id', $transfer[0]->to)->update(['amount' => $detail_item_to[0]->amount + $transfer->amount]);
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
}
