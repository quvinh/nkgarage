<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Suppliers;
use Illuminate\Support\Facades\DB;

class SuppliersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Suppliers::All();
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
        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'name' => 'required',
            // 'supplier_initials' => 'required',
            'email' => 'required',
            // 'address' => 'required',
            'contact_person' => 'required',
            'phone' => 'required',
            // 'note' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $data = Suppliers::create($request->all());

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
        $data = Suppliers::find($id);
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
            'code' => 'required',
            'name' => 'required',
            // 'supplier_initials' => 'required',
            'email' => 'required',
            // 'address' => 'required',
            'contact_person' => 'required',
            'phone' => 'required',
            // 'note' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $data = Suppliers::where('id', $id)->update([
            'code' => $request->code,
            'name' => $request->name,
            'supplier_initials' => $request->supplier_initials,
            'email' => $request->email,
            'address' => $request->address,
            'contact_person' => $request->contact_person,
            'phone' => $request->phone,
            'note' => $request->note,
        ]);
        return response()->json([
            'message' => 'Data Import successfully changed',
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
        $data = Suppliers::find($id);
        $data->delete();

        return response()->json([
            'tatus' => 'Delete data Supplier',
            'message' => 'Delete sucessfully',
        ], 201);
    }

    // public function showSupplier($id) {
    //     $data = DB::table('suppliers')
    //     ->where('id', $id)
    //     ->get();
    //     return response()->json([
    //         'tatus' => 'Delete data Supplier',
    //         'message' => 'Delete sucessfully',
    //     ], 201);
    // }

    public function totalPrice($id)
    {
        $totalPrice = DB::table('imports')
            ->join('suppliers', 'suppliers.id', '=', 'imports.supplier_id')
            ->select(DB::raw('sum(amount * price) as total'))
            ->groupBy('supplier_id')
            ->where('supplier_id', $id)
            ->where('status', 1)
            ->get();

        return response()->json([
            'message' => 'Total Price',
            'data' => $totalPrice,
        ], 201);
    }

    public function listImport($id)
    {
        $list = DB::table('imports')
            ->join('suppliers', 'suppliers.id', '=', 'imports.supplier_id')
            ->select(
                'imports.id as id',
                'imports.code as code',
                'amount',
                'price',
                'created_at',
                'imports.note as note',
                'created_by',
                'status',
            )
            ->where('supplier_id', $id)
            ->groupBy('imports.code')
            ->get();
        return response()->json([
            'message' => 'Data Import',
            'list' => $list,
        ], 201);
    }

    public function searchDate($id,$begin,$end) {
        $list = DB::table('imports')
        ->join('suppliers', 'suppliers.id', '=', 'imports.supplier_id')
            ->select(
                'imports.id as id',
                'amount',
                'price',
                'created_at',
                'imports.note as note',
                'created_by',
                'status',
            )
            ->where('supplier_id', $id)
            ->where('created_at >', $begin)
            ->where('created_at <', $end)
            ->groupBy('imports.code')
            ->get();
        return response()->json([
            'message' => 'Data Import',
            'list' => $list,
        ], 201);
    }
}