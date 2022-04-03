<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\Notification;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Nette\Utils\Arrays;

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
            ->join('users', 'users.id', '=', 'notifications.created_by')
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

    public function index2($id)
    {
        $data = DB::table('notifications')
            // ->join('warehouses', 'warehouses.id', '=', 'notifications.warehouse_id')
            ->join('users', 'users.id', '=', 'notifications.created_by')
            ->select(
                'notifications.id as id',
                'title',
                'content',
                // 'notifications.warehouse_id as warehouse_id',
                // 'warehouses.name as name',
                'created_by',
                'users.fullname as fullname',
                'notifications.created_at as created_at',
                'notifications.status as status',
            )
            ->where('send_to', $id)
            ->orderBy('status', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->get();
        // $count = DB::table('notifications')
        //     ->get()
        //     ->count();
        return response()->json([
            'data' => $data,
            'count' => $data->count()
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
            'send_to' => 'required',
            // 'warehouse_id' => 'required',
            'status' => 'required',
            'content' => 'required',
            'created_by' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $send_to = $request->send_to;
        foreach ($send_to as $send_to) {
            Notification::create([
                'title' => $request->title,
                'content' => $request->content,
                'send_to' => $send_to,
                'created_by' => $request->created_by,
                'status' => 0,
            ]);
        }
        // Notification::create([
        //     'title' => $request->title,
        //     'content' => $request->content,
        //     'warehouse_id' => $request->warehouse_id,
        //     'created_by' => $request->created_by,
        //     'status' => 0,
        //     'send_to' => 0,
        // ]);

        return response()->json([
            'message' => 'Notification created successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function count($id)
    {
        $data = DB::table('notifications')
            ->join('users', 'users.id', '=', 'notifications.created_by')
            ->select(
                'notifications.id as id',
                'title',
                'content',
                'created_by',
                'users.fullname as fullname',
                'notifications.created_at as created_at',
                'notifications.status as status',
            )
            ->where('send_to', $id)
            ->orderBy('status', 'ASC')
            ->orderBy('notifications.created_at', 'DESC')
            ->get()
            ->take(10);

        $count = DB::table('notifications')->where([
            ['status', 0],
            ['send_to', $id]
        ])->count();
        return response()->json([
            'message' => 'Count notification',
            'data' => $data,
            'count' => $count
        ], 201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) // id warehouse
    {
        // dd(DB::table('managers')->where('user_id', $id)->get('warehouse_id')->count());
        $data = DB::table('notifications')
            ->join('users', 'users.id', '=', 'notifications.created_by')
            // ->join('warehouses', 'warehouses.id', '=' ,'notifications.warehouse_id')
            ->select(
                'notifications.id as id',
                'title',
                'content',
                'notifications.created_at as created_at',
                'created_by',
                'users.fullname as fullname',
                'send_to',
            )
            // ->where('warehouse_id', $id)
            ->where('notifications.id', $id)
            ->orderBy('status', 'ASC')
            ->orderBy('created_at', 'DESC')
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
    public function update($id)
    {
        $data = Notification::where('id', $id)->update([
            'status' => 1,
        ]);

        return response()->json([
            'message' => 'Data notifications successfully changed',
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
        DB::table('notifications')->where('id', $id)->delete();
        return response()->json([
            'status' => 'Delete data notification',
            'message' => 'Delete successfully',
        ], 201);
    }

    public function getPersonInWarehouse($id)
    {
        $listWarehouse = DB::table('managers')->where('user_id', $id)->get();
        $count = $listWarehouse->count();

        $listID = array();
        for ($i = 0; $i < $count; $i++) {
            array_push($listID, $listWarehouse[$i]->warehouse_id);
        }

        $data = DB::table('users')
            ->join('managers', 'managers.user_id', 'users.id')
            ->join('warehouses', 'warehouses.id', 'managers.warehouse_id')
            ->join('model_has_roles', 'model_has_roles.model_id', 'users.id')
            ->join('roles', 'roles.id', 'model_has_roles.role_id')
            ->select(
                'users.id as id',
                'users.fullname as fullname',
                'users.username as username',
                'roles.name as role',
                'warehouses.name as warehouse'
            )
            ->whereIn('warehouse_id', $listID)
            ->where([
                ['users.id', '<>', 1],
                ['users.id', '<>', $id]
            ])
            ->get();


        return response()->json([
            'status' => 'Get data user of warehouse',
            'data' => $data,
        ], 201);
    }

    public function send($id)
    {
        $data = DB::table('notifications')
            ->join('users', 'users.id', '=', 'notifications.send_to')
            ->select(
                'notifications.id as id',
                'title',
                'content',
                'notifications.created_at as created_at',
                'created_by',
                'users.fullname as fullname',
                'send_to',
            )
            ->where('created_by', $id)
            ->orderBy('created_at', 'DESC')
            ->get();

        return response()->json([
            'status' => 'Get data user of warehouse',
            'data' => $data,
        ], 201);
    }
}
