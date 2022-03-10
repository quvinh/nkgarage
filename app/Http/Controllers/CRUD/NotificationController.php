<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\Notification;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('notifications')
            ->join('warehouses', 'warehouses.id', '=', 'notifications.warehouse_id')
            ->select(
                'detail_item_id',
                'notifications.id as id',
                'item_id',
                'item_name',
                'title',
                'content',
                'amount',
                'warehouse_id',
                'warehouses.name as name',
                'unit',
                'created_by',
                'created_at',
                'code'
            )
            ->groupBy('code')
            ->get();
        $count = DB::table('notifications')
            ->get()
            ->groupBy('code')
            ->count();
        return response()->json([
            'data' => $data,
            'count' => $count
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
        $validator = Validator::make($request->all(), [
            // 'detail_item_id' => 'required',
            'item_id' => 'required',
            'title' => 'required',
            'content' => 'required',
            'amount' => 'required',
            'unit' => 'required',
            'warehouse_id' => 'required',
            'created_by' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $data = Notification::create([
            'item_id' => $request->item_id,
            'item_name' => $request->item_name,
            'title' => $request->title,
            'content' => $request->content,
            'amount' => $request->amount,
            'unit' => $request->unit,
            'warehouse_id' => $request->warehouse_id,
            'created_by' => $request->created_by,
            'code' => $request->code,
        ]);

        return response()->json([
            'message' => 'Data created successfully',
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
        $data = Notification::find($id);

        return response()->json([
            'status' => 'show form edit',
            'message' => 'show successfully',
            'data' => $data
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
        $validator = Validator::make($request->all(), [
            // 'detail_item_id' => 'required',
            'item_id' => 'required',
            'item_name' => 'required',
            'title' => 'required',
            'content' => 'required',
            'amount' => 'required',
            'unit' => 'required',
            'warehouse_id' => 'required',
            'created_by' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $data = Notification::where('id', $id)->update([
            'item_id' => $request->item_id,
            'item_name' => $request->item_name,
            'title' => $request->title,
            'content' => $request->content,
            'amount' => $request->amount,
            'unit' => $request->unit,
            'warehouse_id' => $request->warehouse_id,
            'created_by' => $request->create_by,
        ]);

        return response()->json([
            'message' => 'Data notifications successfully changed',
            'data' => $data
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
    }

    public function showNotification($code)
    {
        $notification = DB::table('notifications')
            // ->join('detail_items', 'detail_items.item_id', '=', 'notifications.item_id')
            // ->join('items', 'items.id', '=', 'notifications.item_id')
            // ->join('users','users.id','=','notifications.created_by')
            ->join('warehouses', 'warehouses.id', '=', 'notifications.warehouse_id')
            ->select(
                'notifications.id as notification_id',
                // 'detail_item_id',
                'notifications.item_id',
                'notifications.item_name as item_name',
                'title',
                'content',
                'notifications.amount as amount',
                'notifications.unit as unit',
                'created_by',
                'notifications.created_at',
                'warehouse_id',
                'warehouses.name as warehouse_name',
            )
            ->where('code', $code)
            ->get();
        return response()->json([
            'message' => 'Data Notification',
            'data' => $notification
        ], 201);
    }

    public function showListItemById($id)
    {
        $count = DB::table('detail_items')
            ->where('item_id', $id)
            ->get()->count();
        if ($count <> 0) {
            $listItem = DB::table('detail_items')
                ->join('items', 'detail_items.item_id', '=', 'items.id')
                ->join('shelves', 'shelves.id', '=', 'detail_items.shelf_id')
                ->join('warehouses', 'warehouses.id', '=', 'detail_items.warehouse_id')
                ->select(
                    'detail_items.item_id as itemid',
                    'items.name as itemname',
                    'detail_items.shelf_id as shelfid',
                    'detail_items.warehouse_id as warehouseid',
                    'warehouses.name as warehousename',
                    'shelves.name as shelfname',
                    'detail_items.amount as itemamount',
                    'detail_items.unit as itemunit',
                )
                ->where('detail_items.item_id', $id)
                ->get();
        }
        return response()->json([
            'message' => 'Data listItem',
            'data' => $listItem
        ], 201);
    }
}
