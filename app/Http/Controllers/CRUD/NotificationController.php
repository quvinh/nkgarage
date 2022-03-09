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
        //
        $data = Notification::all();
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
            'title' => 'required',
            'content' => 'required',
            'created_by' => 'required',
            'type' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $data = Notification::create($request->all());
        return response()->json([
            'message' => 'Data created successfully',
            'status' => 'Created Data',
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
        $data = Notification::find($id);
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
            'title' => 'required',
            'content' => 'required',
            'created_by' => 'required',
            'type' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $data = Notification::where('id', $id)->update([
            'detail_item_id' => $request->detail_item_id,
            'title' => $request->title,
            'content' => $request->content,
            'item_id' => $request->item_item,
            'amount' => $request->amount,
            'unit' => $request->unit,
            'created_by' => $request->created_by,
            'status' => $request->status,
            'begin_at' => $request->begin_at,
            'end_at' => $request->end_at,
            'type' => $request->type,
        ]);

        return response()->json([
            'message' => 'Data Notification successfully changed',
            'status' => 'Updated Data',
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
        $data = Notification::find($id);
        $data->delete();

        return response()->json([
            'status' => 'Delete data Category',
            'message' => 'Delete successfully',
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
}
