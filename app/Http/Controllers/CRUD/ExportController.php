<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\Export;
use App\Models\Item;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Export::all();
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
        if (Item::where('id', '=',))
            $validator = Validator::make($request->all(), [
                'detail_item_id' => 'required',
                'amount' => 'required',
                'unit' => 'required',
                'status' => 'required',
                'created_by' => 'required'
            ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $data = Export::create($request->all());
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
        //
        $data = Export::find($id);
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
            'detail_item_id' => 'required',
            'amount' => 'required',
            'unit' => 'required',
            'status' => 'required',
            'created_by' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $data = Export::where('id', $id)->update([
            'detail_item_id' => $request->detail_item_id,
            'amount' => $request->amount,
            'unit' => $request->unit,
            'status' => $request->status,
            'created_by' => $request->created_by
        ]);

        return response()->json([
            'message' => 'Data Export successfully changed',
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
        $data = Export::find($id);
        $data->delete();

        return response()->json([
            'status' => 'Delete data Category',
            'message' => 'Delete successfully',
        ], 201);
    }
    // public function updateStatus(Request $request, $id)
    // {
    //     $request->validate([
    //         'detail_item_id' => 'required',
    //         'amount' => 'required',
    //         'unit' => 'required',
    //         'status' => 'required',
    //         'created_by' => 'required'
    //     ]);

    //     $amount = DB::table('detail_item')
    //         ->join('exports', 'detail_item.id', '=', 'export.detail_item_id')
    //         ->join('item', 'detail_item.id', '=', 'item.detail_item_id')
    //         ->select('item.amount as amount_item')
    //         ->where('export.id', '=', $id)
    //         ->get('amount_item');
    //     dd($amount[0]->amount);
    //     if ($request->status == 1) {
    //     }



    //     return response()->json([
    //         'status' => 'Delete data Category',
    //         'message' => 'Delete successfully',
    //     ], 201);
    // }
}
