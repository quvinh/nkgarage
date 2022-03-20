<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\DetailUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]); //except
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'email' => 'required|email',
            'username' => 'required',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|between:2,100|unique:users',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
            'fullname' => 'required|string|between:2,100',
            'phone' => 'required|max:10',
            // 'birthday' => 'required',
            // 'address' => 'required',
            // 'gender' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json([
            'status' => 'logout',
            'message' => 'User successfully signed out'
        ]);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth()->refresh);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        $users = User::role('admin')->get();

        return response()->json([
            'status' => 'user profile',
            // 'data' => Auth::user(),
            'data' => $users,
        ]);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth()->user(),
            'role' => auth()->user()->getAllPermissions(),
            'warehouse_id' => DB::table('managers')->where('user_id', auth()->user()->id)->get('warehouse_id'),
        ]);
    }

    public function changePassWord(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|string|min:6',
            'new_password' => 'required|string|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $userId = auth()->user()->id;

        $user = User::where('id', $userId)->update(
            ['password' => bcrypt($request->new_password)]
        );

        return response()->json([
            'message' => 'User successfully changed password',
            'user' => $user,
        ], 201);
    }

    public function users()
    {
        $data = DB::table('users')
            ->leftJoin('detail_users', 'users.id', '=', 'detail_users.user_id')
            ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->select(
                'users.id as id',
                'users.username as username',
                'users.email as email',
                'users.fullname',
                'users.phone',
                'detail_users.address as address',
                'detail_users.birthday as birthday',
                'detail_users.gender',
                'model_has_roles.role_id as roles_id'
            )
            ->get();

        // $dataRoles = DB::table('roles')
        //     ->where('id', $data[0]->roles_id)
        //     ->get();

        return response()->json([
            'message' => 'All users',
            'data' => $data,
            // 'dataRoles' => $dataRoles,
        ], 201);
    }

    public function getUser($id)
    {
        $data = DB::table('users')
            ->leftJoin('detail_users', 'users.id', '=', 'detail_users.user_id')
            ->where('users.id', $id)
            ->select(
                'users.id as id',
                'users.username as username',
                'users.email as email',
                'users.fullname',
                'users.phone',
                'detail_users.address as address',
                'detail_users.birthday as birthday',
                'detail_users.gender',
            )
            ->get();

        $warehouse_id = DB::table('managers')->where('user_id', $id)
            ->join('warehouses', 'warehouses.id', '=', 'managers.warehouse_id')
            ->get();
        $checkRole = DB::table('model_has_roles')->where('model_id', $id)->count();
        $role = DB::table('model_has_roles')->where('model_id', $id)->get('role_id');
        $role_id = 0;
        if ($checkRole > 0) {
            $role_id = $role[0]->role_id;
        }
        return response()->json([
            'message' => 'get user',
            'data' => $data,
            'warehouse_id' => $warehouse_id,
            'role_id' => $role_id
        ], 201);
    }

    public function updateUser(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required|string|email',
            'fullname' => 'required|string|between:2,100',
            'phone' => 'required|max:10',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        DB::table('users')->where('id', $id)->update([
            'fullname' => $request->fullname,
            'phone' => $request->phone
        ]);

        $checkUser = DB::table('detail_users')->where('user_id', $id)->count();
        if ($checkUser > 0) {
            DB::table('detail_users')->where('user_id', $id)->update([
                'birthday' => $request->birthday,
                'address' => $request->address,
                'gender' => $request->gender,
            ]);
        } else {
            $data = new DetailUser();
            $data->user_id = $id;
            $data->address = $request->address;
            $data->birthday = $request->birthday;
            $data->gender = $request->gender;
            $data->save();
        }

        return response()->json([
            'message' => 'updated user',
            'status' => 'UPDATE'
        ], 201);
    }
}
