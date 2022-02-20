<?php

namespace App\Http\Controllers\CRUD;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Item::All();
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
            'id' => 'required',
            'batch_code' => 'required',
            'name' => 'required',
            'amount' => 'required',
            'unit' => 'required',
            'price' => 'required',
            'status' => 'required'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),400);
        }
        $data = Item::create($request->all());

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
        $data = Item::find($id);
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
            'id' => 'required',
            'batch_code' => 'required',
            'name' => 'required',
            'amount' => 'required',
            'unit' => 'required',
            'price' => 'required',
            'status' => 'required',
        ]);

        if($validator -> fails()) {
            return response()->json($validator->errors()->toJson(),400);
        }

        $data = Item::where('id', $id)->update([
            'id' => $request->id,
            'batch_code' => $request->batch_code,
            'name' => $request->name,
            'amount' => $request->amount,
            'unit' => $request->unite,
            'price' => $request->price,
            'status' => $request->status,
            'note' => $request->note
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
        $data = Item::find($id);
        $data->delete();

        return response()->json([
            'tatus' => 'Delete data Permissions',
            'message' => 'Delete sucessfully',
        ], 201);
    }
}