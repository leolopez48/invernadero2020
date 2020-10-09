<?php

namespace App\Http\Controllers;

use App\Station;
use Illuminate\Http\Request;
use DB;
use Storage;

class StationController extends Controller
{

    public function add(Request $request){
        try {
            if($request->hasFile('photo')){
                $photo = Storage::put('public', $request->photo);
                $url = Storage::url($photo);
                $fullUrl = asset($url);
            }
            if((int)Station::all('id')->count() == 0){
                $lastId = 1;
                
            }else{
                $lastId = (int)Station::all('id')->last()->id; //Get the lastest id value of stations
                $lastId+=1; //Add 1 to set the new value to the station
            }
            $newId = strval($lastId);
            $title = $request->title;
            $description = $request->description;
            $temperature = $request->temperature;
            $humidity = $request->humidity;
            $radiation = $request->radiation;
            $state = true;
    
            $st = new Station();
            $st->id = $newId;
            $st->title = $title;
            $st->description = $description;
            $st->photo = $fullUrl;
            $st->state = $state;
            $st->temperature = (int)$temperature;
            $st->humidity = (int)$humidity;
            $st->radiation = (int)$radiation;
            $stSaved = $st->save();
    
            return response()->json(["message"=>"success"]);
        } catch (\Throwable $th) {
            return response()->json(["message"=>$th->getMessage()]);
        }
        
        
    }

    public function index(Request $request)
    {
        $stations = DB::table('station')->where(['state'=> $request->state])->get();
        
        return response($stations);
    }

    public function edit(Request $request){
        $id = $request->id;
        $title = $request->title;
        $description = $request->description;
        $temperature = $request->temperature;
        $humidity = $request->humidity;
        $radiation = $request->radiation;

        if($request->hasFile('photo')){

            $photo = Storage::put('public', $request->photo);
            $url = Storage::url($photo);
            $fullUrl = asset($url);

            $stationU = DB::table('station')->where(['id'=>$id])->update(["photo"=>$fullUrl,"title"=>$title, 
            "description"=>$description, "humidity"=>$humidity, "temperature"=>$temperature, "radiation"=>$radiation]);

            return response()->json(["stationU"=>$stationU, 'id'=>$id, "message"=>"success"]);
        }else{
            $stationU = DB::table('station')->where(['id'=>$id])->update(["title"=>$title, 
            "description"=>$description, "humidity"=>$humidity, "temperature"=>$temperature, "radiation"=>$radiation]);
            return response()->json(["id"=>$stationU, "message"=>"success"]);
        }
    }

    public function delete(Request $request){
        $id = $request->id;
        $stationA = DB::table('station')->where(['id'=>$id])->get();
        if($stationA[0]["state"] == true){
            $stationA = DB::table('station')->where(['id'=>$id])->update(["state"=>false]);
        }else{
            $stationA = DB::table('station')->where(['id'=>$id])->update(["state"=>true]);
        }
        return response()->json(["id"=>$request->id, "message"=>"success"]);
    }
}
