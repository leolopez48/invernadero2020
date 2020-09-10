<?php

namespace App\Http\Controllers;

use App\Station;
use Illuminate\Http\Request;
use DB;
use Storage;

class StationController extends Controller
{

    public function add(Request $request){
            //$photo = Storage::put('storage/', $request->photo);
            $photo = asset('storage/wallpaper.jpg');
            $id=$request->id;
            return response(["id"=>$id, "photo"=>$photo]);
    }

    public function index(Request $request)
    {
        //dd(asset('storage/wallpaper.jpg'));
        //$stations = Storage::get('storage/wallpaper.jpg');
        $stations = DB::table('station')->where(['state'=> $request->state])->get();
        
        return response($stations);
    }

    public function edit(Request $request){
        return response()->json(["id"=>$request->id, "message"=>"success"]);
    }

    public function delete(Request $request){
        $id = $request->id;
        $stationA = DB::table('station')->where(['id'=>$id])->get();
        //dd($stationA);
        if($stationA[0]["state"] == true){
            $stationA = DB::table('station')->where(['id'=>$id])->update(["state"=>false]);
        }else{
            $stationA = DB::table('station')->where(['id'=>$id])->update(["state"=>true]);
        }
        return response()->json(["id"=>$request->id, "message"=>"success"]);
    }
}
