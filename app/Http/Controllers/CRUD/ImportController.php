<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\DetailItem;
use App\Models\Import;
use App\Models\Item;
use Illuminate\Support\Facades\DB;

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
        return response()->json([
            'data' => $data
        ], 201);
    }

    public function indexStatus()
    {
        $data = DB::table('imports')
            ->where('status', 0)
            ->get();

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
            'item_id' => 'required',
            // 'detail_item_id' => 'required',
            'batch_code' => 'required',
            'warehouse_id' => 'required',
            'category_id' => 'required',
            'shelf_id' => 'required',
            'name' => 'required',
            'amount' => 'required',
            'unit' => 'required',
            'price' => 'required',
            'supplier_id' => 'required',
            'created_by' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $data = Import::create([
            'item_id' => $request->item_id,
            'code' => $request->code,
            'batch_code' => $request->batch_code,
            'warehouse_id' => $request->warehouse_id,
            'category_id' => $request->category_id,
            'shelf_id' => $request->shelf_id,
            'name' => $request->name,
            'amount' => $request->amount,
            'unit' => $request->unit,
            'price' => $request->price,
            'status' => '0',
            'supplier_id' => $request->supplier_id,
            'created_by' => $request->created_by,
            'note' => $request->note
        ]);

        // $array_data = (array) $data;
        // array_push($array_data,$data);

        return response()->json([
            'message' => 'Data created successfully',
            'data' => $data
        ], 201);
    }


    // public function waitStore(Request $request) {

    //     $validator = Validator::make($request->all(), [
    //         'id' => 'required',
    //         'status' => 'required',
    //     ]);
    //     if($validator->fails()){
    //         return response()->json($validator->errors()->toJson(),400);
    //     }

    //     $itemStatus = DB::table('imports')
    //         ->where('id',$request->id)
    //         ->get('status');
    //     dd($itemStatus);
    // }
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

        $validator = Validator::make($request->all(), [
            'item_id' => 'required',
            'batch_code' => 'required',
            'warehouse_id' => 'required',
            'category_id' => 'required',
            'shelf_id' => 'required',
            'name' => 'required',
            'amount' => 'required',
            'unit' => 'required',
            'price' => 'required',
            'supplier_id' => 'required',
            'created_by' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $data = Import::where('id', $id)->update([
            'item_id' => $request->item_id,
            // 'detail_item_id' => $request->detail_item_id,
            'batch_code' => $request->batch_code,
            'warehouse_id' => $request->warehouse_id,
            'category_id' => $request->category_id,
            'shelf_id' => $request->shelf_id,
            'name' => $request->name,
            'amount' => $request->amount,
            'unit' => $request->unit,
            'price' => $request->price,
            'supplier_id' => $request->supplier_id,
            'created_by' => $request->created_by,
            'note' => $request->note
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


    public function updateStatus($id)
    {
        $import = DB::table('imports')
            ->where('id', $id)
            ->get();

        $data = Import::where('id', $id)->update([
            'status' => '2'
        ]);

        $countItem = DB::table('detail_items')
            ->where([
                ['warehouse_id', '=', $import[0]->warehouse_id],
                ['shelf_id', '=', $import[0]->shelf_id],
                ['item_id', '=', $import[0]->item_id],
                ['batch_code', '=', $import[0]->batch_code],
                ['supplier_id', '=', $import[0]->supplier_id]
            ])
            ->get()
            ->count();

        $amountItem = DB::table('detail_items')->where([
            ['warehouse_id', '=', $import[0]->warehouse_id],
            ['shelf_id', '=', $import[0]->shelf_id],
            ['item_id', '=', $import[0]->item_id],
            ['batch_code', '=', $import[0]->batch_code],
            ['supplier_id', '=', $import[0]->supplier_id]
        ])->get('amount');

        if ($countItem > 0) {
            DetailItem::where([
                ['warehouse_id', '=', $import[0]->warehouse_id],
                ['shelf_id', '=', $import[0]->shelf_id],
                ['item_id', '=', $import[0]->item_id],
                ['batch_code', '=', $import[0]->batch_code],
                ['supplier_id', '=', $import[0]->supplier_id],
            ])->update(['amount' => $amountItem[0]->amount + $import[0]->amount]);
        } else {

            $item = new DetailItem();

            $item->item_id = $import[0]->item_id;
            $item->category_id = $import[0]->category_id;
            $item->warehouse_id = $import[0]->warehouse_id;
            $item->shelf_id = $import[0]->shelf_id;
            $item->batch_code = $import[0]->batch_code;
            $item->supplier_id = $import[0]->supplier_id;
            $item->amount = $import[0]->amount;
            $item->unit = $import[0]->unit;
            $item->price = $import[0]->price;
            $item->status = 0;
            $item->save();
        }

        return response()->json([
            'message' => 'Data Import successfully changed',
            'data' => $data
        ], 201);
    }

    public function dStatus($id)
    {
        $dStatus =  Import::where('id', $id)->update(['status' => '1']);
        return response()->json([
            'message' => 'Data Export successfully changed',
            'status' => 'Changed Status',
            'data' => $dStatus,
        ], 201);
    }

    public function destroy($id)
    {
        $data = Import::find($id);
        $data->delete();

        return response()->json([
            'status' => 'Delete data Imports',
            'message' => 'Delete successfully',
        ], 201);
    }
}
