<?php

namespace App\Http\Controllers;

use App\Station;
use Illuminate\Http\Request;
use DB;
use Storage;

class StationController extends Controller
{

    public function add(Request $request){
        // return response($request->photo);
        if($request->hasFile('photo')){
            $photo = Storage::put('public', $request->photo);
            $url = Storage::url($photo);
            $fullUrl = asset($url);
        }

        $lastId = (int)Station::all('id')->last()->id; //Get the lastest value of the stations
        $lastId+=1; //Add 1 to set the new value to the station
        $newId = strval($lastId);
        $title = $request->title;
        $description = $request->description;
        $state = true;

        $st = new Station();
        $st->id = $newId;
        $st->title = $title;
        $st->description = $description;
        $st->photo = $fullUrl;
        $st->state = $state;
        $stSaved = $st->save();

        return response()->json(["message"=>"success"]);
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
