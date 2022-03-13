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
            ->join('users', 'users.id','=','notifications.created_by')
            ->select(
                'notifications.id as id',
                'title',
                'content',
                'notifications.warehouse_id as warehouse_id',
                'warehouses.name as name',
                'created_by',
                'users.fullname as fullname',
                'notifications.created_at as created_at',
            )
            ->get();
        $count = DB::table('notifications')
            ->get()
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
            'title' => 'required',
            'content' => 'required',
            'created_by' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $data = Notification::create([
            'title' => $request->title,
            'content' => $request->content,
            'warehouse_id' => $request->warehouse_id,
            'created_by' => $request->created_by,
            'status' => 0,
            // 'type' => $request->type,
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
        $data = DB::table('notifications')
        ->join('users', 'users.id', '=' , 'notifications.created_by')
        // ->join('warehouses', 'warehouses.id', '=' ,'notifications.warehouse_id')
        ->select(
            'notifications.id as id',
            'title',
            'content',
            'notifications.created_at as created_at',
            'created_by',
            'users.fullname as fullname',
            // 'warehouses.name as name',
            // 'warehouse_id'
        )
        ->where('notifications.id', $id)
        ->get();

        return response()->json([
            'status' => 'show form notification',
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
            'title' => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $data = Notification::where('id', $id)->update([
            'title' => $request->title,
            'content' => $request->content,
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
        $data = Notification::find($id);
        $data->delete();
        return response()->json([
            'status' => 'Delete data notification',
            'message' => 'Delete successfully',
        ], 201);
    }

    public function showNotification()
    {
        $notification = DB::table('notifications')
            // ->join('detail_items', 'detail_items.item_id', '=', 'notifications.item_id')
            // ->join('items', 'items.id', '=', 'notifications.item_id')
            // ->join('users','users.id','=','notifications.created_by')
            ->join('warehouses', 'warehouses.id', '=', 'notifications.warehouse_id')
            ->select(
                'notifications.id as notification_id',
                'title',
                'content',
                'created_by',
                'notifications.created_at',
                'warehouse_id',
                'warehouses.name as warehouse_name',
            )
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

    public function notificationEvent($typeE) {
        $eventN = DB::table('notifications')
        ->select('title',
        'content',
        'created_by',
        'begin_at',
        'end_at',
        'type'
        )
        ->where('type',$typeE)
        ->get();

        return response()->json([
            'message' => 'Data Notification Event',
            'data' => $eventN,
        ], 201);
    }

    public function notificationItem($typeI) {
        $itemN = DB::table('notifications')
        ->select('title',
        'content',
        'created_by',
        'item_id',
        'amount',
        'code',
        'unit',
        'status',
        )
        ->where('type',$typeI)
        ->get();

        return response()->json([
            'message' => 'Data Notification Event',
            'data' => $itemN,
        ], 201);
    }

    // public function dataNotification ($id) {
    //     $data = DB::table('notifications')
    //     ->
    //     ->join('users', 'users.id', '=', 'notifications.created_by')
    //     ->select(
    //         'notifications.id as id',
    //         'title',
    //         'content',
    //         'warehouse_id',
    //         'warehouses.name as name',
    //         'created_by',
    //         'users.fullname',
    //         'notifications.created_at as created_at'
    //     )
    //     ->
    // }
    public function updateStatus($id) {
        $data = Notification::where('id', $id)->update([
            'status' => 1
        ]);
        return response()->json([
            'message' => 'Data notifications successfully changed',
            'data' => $data
        ], 201);
    }
}
