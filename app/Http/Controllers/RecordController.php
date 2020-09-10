<?php

namespace App\Http\Controllers;

use App\Record;
use Illuminate\Http\Request;
use DB;

class RecordController extends Controller
{
   function add(Request $request){
        try {
            $record = new Record;
            $record->id = $request->id;
            $record->temperature = $request->temperature; 
            $record->humidity = $request->humidity; 
            $record->radiation = $request->radiation;
            $record->updated_at = date("Y-m-d h:i:s A", time()); 
            $record->created_at = date("Y-m-d h:i:s A", time()); 
            $record->save();
            return response()->json(['message'=>'success']);
        } catch (\Throwable $th) {
            return response()->json(['message'=>'failed']);
        }
   }

   function get($id){
       try{
            $records = DB::table('record')->where(['id'=>$id])->get();
            return response()->json(['message'=>'success', 'records'=>$records]);
        } catch (\Throwable $th) {
            return response()->json(['message'=>'failed']);
        }
   }
}
