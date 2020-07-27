<?php

namespace App\Http\Controllers;

use App\Registro;
use Illuminate\Http\Request;
use DB;

class RegistroController extends Controller
{
   function add(Request $request){
        try {
            $registro = new Registro;
            $registro->id = $request->id;
            $registro->temperatura = $request->temperatura; 
            $registro->humedad = $request->humedad; 
            $registro->radiacion = $request->radiacion;
            $registro->updated_at = date("Y-m-d h:i:s A", time()); 
            $registro->created_at = date("Y-m-d h:i:s A", time()); 
            $registro->save();
            return response()->json(['message'=>'success']);
        } catch (\Throwable $th) {
            return response()->json(['message'=>'failed']);
        }
   }

   function get($id){
       try{
            $registros = DB::table('registros')->where(['id'=>$id])->get();
            return response()->json(['message'=>'success', 'registros'=>$registros]);
        } catch (\Throwable $th) {
            return response()->json(['message'=>'failed']);
        }
   }
}
