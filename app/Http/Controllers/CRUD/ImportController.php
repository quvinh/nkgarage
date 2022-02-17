<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\Import;
use App\Models\Permissions;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Import::All();
        return $data;
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
            'item_id' => 'required|char',
            'amount' => 'required',
            'unit' => 'required',
            'status' => 'required',
            'created_by' => 'required'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),400);
        }
        $data = Import::create($request->all());

        return response()->json([
            'message' => 'Data created successfully',
            'data' => $data
        ],201);
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
        $data = Import::find($id);
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
        $validator = Validator::make($request->all(),[
            'item_id' => 'required|char',
            'amount' => 'required',
            'unit' => 'required',
            'status' => 'required',
            'created_by' => 'required',
        ]);

        if($validator -> fails()) {
            return response()->json($validator->errors()->toJson(),400);
        }

        $data = Import::where('id', $id)->update([
            'item_id' => $request->item_id,
            'amount' => $request->amount,
            'unit' => $request->unit,
            'status' => $request->status,
            'create_by' => $request->create_by
        ]);

        return response()->json([
            'message' => 'Data Import successfully changed',
            'data' =>$data
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Import::find($id);
        $data->delete();

        return response()->json([
            'tatus' => 'Delete data Permissions',
            'message' => 'Delete sucessfully',
        ], 201);
    }
}
