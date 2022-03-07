<?php

namespace App\Http\Controllers\CRUD\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission as ModelsPermission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Role::all();
        return response()->json([
            'status' => 'get all roles',
            'data' => $data
        ], 201);
        // return $data;
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
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|string|between:2,100',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json($validator->errors()->toJson(), 400);
        // }

        // $data = Roles::create($request->all());

        // return response()->json([
        //     'message' => 'Data created successfully',
        //     'data' => $data
        // ], 201);
        // return $data;
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
        // $data = Roles::find($id);
        // return response()->json([
        //     'status' => 'Show form edit',
        //     'message' => 'Show successfully',
        //     'data' => $data,
        // ]);
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
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|string|between:2,100',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json($validator->errors()->toJson(), 400);
        // }

        // $data = Roles::where('id', $id)->update([
        //     'name' => $request->name,
        //     'note' => $request->note
        // ]);

        // return response()->json([
        //     'message' => 'Data Roles successfully changed',
        //     'data' => $data,
        // ], 201);
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
        // $data = Roles::find($id);
        // $data->delete();

        // return response()->json([
        //     'tatus' => 'Delete data Roles',
        //     'message' => 'Delete sucessfully',
        // ], 201);
    }

    public function detailRoles($id)
    {
        // $data = DB::table('role_has_permission')
        //     ->join('roles', 'roles.id', '=', 'role_has_permission.role_id')
        //     ->join('permissions', 'permissions.id', '=', 'role_has_permission.permission_id')
        //     ->select(
        //         'roles.id as role_id',
        //         'roles.name',
        //         'permissions.id as permission_id',
        //         'permissions.name as permission_name'
        //     )
        //     ->where('roles.id', $id)
        //     ->get();
        $data = Role::findById($id)->permissions()->get();

        return response()->json([
            'message' => 'Data Roles - Permissions',
            'data' => $data,
        ], 201);
    }

    public function userRoles(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'roles_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        // $checkUserId = DB::table('model_has_roles')->where('user_id', $request->user_id)->count();

        // if ($checkUserId > 0) {
        //     DB::table('model_has_roles')->where('user_id', $request->user_id)->update([
        //         'model_id' => $request->user_id,
        //         'role_id' => $request->roles_id
        //     ]);
        // } else {
        //     DB::table('model_has_roles')->create($request->all());
        // }

        $role = Role::findById($request->roles_id);
        // dd($role->name);
        $user = User::find($request->user_id);
        $user->assignRole($role->name);

        return response()->json([
            'message' => 'Data updated successfully',
            'status' => 'User - Roles'
            // 'data' => $data
        ], 201);
    }
}
