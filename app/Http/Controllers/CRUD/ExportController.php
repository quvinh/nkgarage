<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
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
            'id' => 'required',
            'amount' => 'required',
            'unit' => 'required',
            'created_by' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $id_detail_item = DB::table('detail_items')
            ->where('item_id', $request->id)
            ->get('id');

        $item = DB::table('items')
            ->where('id', $request->id)
            ->get();

        if ($request->amount <= $item[0]->amount) {
            $de = $item[0]->amount - $request->amount;
            Item::where('id', $item[0]->id)->update(['amount' => $de]);
            $newExport = new Export();
            $newExport->detail_item_id = $id_detail_item[0]->id;
            $newExport->amount = $request->amount;
            $newExport->unit = $request->unit;
            $newExport->created_by = $request->created_by;
            $newExport->status = 0;
            $newExport->note = null;
            $newExport->save();
            return response()->json([
                'message' => 'Data created successfully',
                'status' => 'Add Export'
            ], 201);
        } else {
            $newNotify = new Notification();
            $newNotify->detail_item = $id_detail_item[0]->id;
            $newNotify->title = 'Thiếu vật tư';
            $newNotify->content = 'Cần nhập thêm';
            $newNotify->amount = $request->amount - $item[0]->amount;
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
            'id' => 'required',
            'amount' => 'required',
            'unit' => 'required',
            // 'status' => 'required',
            'created_by' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $data = Export::where('id', $id)->update([
            // 'detail_item_id' => $request->detail_item_id,
            'amount' => $request->amount,
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
}
