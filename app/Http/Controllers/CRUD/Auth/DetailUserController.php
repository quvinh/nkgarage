<?php

namespace App\Http\Controllers\CRUD\Auth;

use App\Http\Controllers\Controller;
use App\Models\DetailUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DetailUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DetailUser::all();
        return response()->json([
            'status' => 'get all roles',
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
    public function store(Request $request, $user_id)
    {
        $validator = Validator::make($request->all(), [
            'address' => 'required|string',
            'birthday' => 'required',
            'gender' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $checkUserID = DB::table('detail_users')
            ->where('user_id', $user_id)
            ->count();
        if ($checkUserID > 0) {
            $data = DetailUser::where('user_id', $user_id)
                ->update([
                    'address' => $request->address,
                    'birthday' => $request->birthday,
                    'gender' => $request->gender
                ]);
            dd($request);
            return response()->json([
                'message' => 'Data updated successfully',
                'status' => 'Update'
            ], 201);
        } else {
            $data = DetailUser::create($request->all());

            return response()->json([
                'message' => 'Data created successfully',
                'data' => $data
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
    public function edit($id) //idUser
    {
        // $data = DetailUser::find($id);
        $data = DB::table('detail_users')
            ->where('user_id', $id)
            ->get();

        $permission = User::find($id)->getAllPermissions();
        return response()->json([
            'status' => 'Show form edit',
            'message' => 'Show successfully',
            'data' => $data,
            'permission' => $permission
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
            'address' => 'required|string',
            'birthday' => 'required',
            'gender' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $data = DetailUser::where('id', $id)->update([
            'name' => $request->name,
            'note' => $request->note
        ]);

        return response()->json([
            'message' => 'Data DetailUser successfully changed',
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
        $data = User::find($id);
        $data->delete();

        return response()->json([
            'status' => 'Delete data User',
            'message' => 'Delete sucessfully',
        ], 201);
    }

    // public function deleteUser($id)
    // {
    //     User::where('id', $id)->delete();
    //     return response()->json([
    //         'status' => 'Delete data User',
    //         'message' => 'Delete sucessfully',
    //     ], 201);
    // }
}
