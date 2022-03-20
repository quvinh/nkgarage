<?php

namespace App\Http\Controllers\CRUD\Auth;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $data = Permission::all();
        $data = Permission::all();

        $roleWarehouse = ['Thêm kho', 'Sửa kho', 'Xoá kho', 'Xem kho'];
        $roleShelf = ['Thêm giá/kệ', 'Sửa giá/kệ', 'Xoá giá/kệ', 'Xem giá/kệ'];
        $roleCategory = ['Thêm loại vật tư', 'Sửa loại vật tư', 'Xoá loại vật tư', 'Xem loại vật tư'];
        $roleImport = ['Thêm phiếu nhập', 'Sửa phiếu nhập', 'Xoá phiếu nhập', 'Xem phiếu nhập', 'Duyệt phiếu nhập'];
        $roleExport = ['Thêm phiếu xuất', 'Sửa phiếu xuất', 'Xoá phiếu xuất', 'Xem phiếu xuất', 'Duyệt phiếu xuất'];
        $roleTransfer = ['Thêm phiếu chuyển', 'Sửa phiếu chuyển', 'Xoá phiếu chuyển', 'Xem phiếu chuyển', 'Duyệt phiếu chuyển'];
        $roleInventory = ['Thêm phiếu kiểm kê', 'Sửa phiếu kiểm kê', 'Xoá phiếu kiểm kê', 'Xem phiếu kiểm kê', 'Duyệt phiếu kiểm kê'];
        $roleNotification = ['Thêm thông báo', 'Sửa thông báo', 'Xoá thông báo', 'Xem thông báo'];
        $roleSupplier = ['Thêm nhà cung cấp', 'Sửa nhà cung cấp', 'Xoá nhà cung cấp', 'Xem nhà cung cấp'];

        return response()->json([
            'status' => 'All permission',
            'data' => $data,
            'dataWarehouse' => $roleWarehouse,
            'dataShelf' => $roleShelf,
            'dataCategory' => $roleCategory,
            'dataImport' => $roleImport,
            'dataExport' => $roleExport,
            'dataTransfer' => $roleTransfer,
            'dataInventory' => $roleInventory,
            'dataNotification' => $roleNotification,
            'dataSupplier' => $roleSupplier,
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
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|string|between:2,100',
        // ]);

        // if($validator->fails()) {
        //     return response()->json($validator->errors()->toJson(), 400);
        // }

        // $data = Permissions::create($request->all());

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
        // $data = Permissions::find($id);
        // return response()->json([
        //     'status' => 'Show form edit',
        //     'message' => 'Show successfully',
        //     'data' => $data,
        // ]);
        // return $data;
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
        //     'name' => 'required',
        // ]);

        // if($validator->fails()) {
        //     return response()->json($validator->errors()->toJson(), 400);
        // }

        // $data = Permissions::where('id', $id)->update([
        //     'name' => $request->name,
        //     'note' => $request->note
        // ]);

        // return response()->json([
        //     'message' => 'Data Permissions successfully changed',
        //     'data' => $data,
        // ], 201);
        // return $data;
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
        // $data = Permissions::find($id);
        // $data->delete();

        // return response()->json([
        //     'tatus' => 'Delete data Permissions',
        //     'message' => 'Delete sucessfully',
        // ], 201);
    }
}
