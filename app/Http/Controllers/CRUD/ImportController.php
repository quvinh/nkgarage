<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
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
            'item_id' => 'required',
            'batch_code' => 'required',
            'name' => 'required',
            'amount' => 'required',
            'unit' => 'required',
            'price' => 'required',
            'status' => 'required',
            'created_by' => 'required'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),400);
        }
        $data = Import::create($request->all());

        // $array_data = (array) $data;
        // array_push($array_data,$data);
        
        return response()->json([
            'message' => 'Data created successfully',
            'data' => $data
        ],201);
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

        $validator = Validator::make($request->all(),[
            'item_id' => 'required',
            'batch_code' => 'required',
            'name' => 'required',
            'amount' => 'required',
            'unit' => 'required',
            'price' => 'required',
            'status' => 'required',
            'created_by' => 'required'
        ]);

        if($validator -> fails()) {
            return response()->json($validator->errors()->toJson(),400);
        }

        $data = Import::where('id', $id)->update([
            'item_id' => $request->item_id,
            'batch_code' => $request ->batch_code,
            'name' => $request -> name,
            'amount' => $request->amount,
            'unit' => $request->unit,
            'status' => $request->status,
            'created_by' => $request->created_by,
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


    public function updateStatus(Request $request, $id){

        $validator = Validator::make($request->all(),[
            'status' => 'required'
        ]);

        if($validator -> fails()) {
            return response()->json($validator->errors()->toJson(),400);
        }

        $data = Import::where('id', $id)->update([
            'status' => $request->status
        ]);

        $import = DB::table('imports')
            ->where('id',$id)
            ->get();
        $countItem = DB::table('items')
            ->where('id', $import[0]->item_id)
            ->get()
            ->count();

        if($request->status==1){
            
            if($countItem > 0) {
               
                $amountItem = DB::table('items')
                ->where('id',$import[0]->item_id)
                ->get('amount');

                if($amountItem[0]->amount > 0){
                    Item::where('id', $import[0]->item_id)->update(['amount'=>$amountItem[0]->amount+$import[0]->amount]);
                }
            }
            else { 
                // Item::where('id',$request->item_id)->update(['amount'=>++$itemA[0]->amount]);
                $item = new Item();
                $item->id = $import[0]->item_id ;
                $item->batch_code = $import[0]->batch_code;
                $item->name = $import[0]->name;
                $item->amount = $import[0]->amount;
                $item->unit = $import[0]->unit;
                $item->price = $import[0]->price;
                $item->status = 0;
                $item->save();
            }
        }

        return response()->json([
            'message' => 'Data Import successfully changed',
            'data' =>$data
        ],201);
    }

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
