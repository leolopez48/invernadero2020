<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Station;
use DB;
use Storage;
use Auth;

class StationController extends Controller
{

    public function add(Request $request){
        try {
            if($request->user()->typeAccess == 1){

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
            }else{
                return response()->json(["message"=>"error"]);
            }

        } catch (\Throwable $th) {
            return response()->json(["message"=>$th->getMessage()]);
        }
        
        
    }

    public function index(Request $request)
    {
        // $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        // $out->writeln("Stations: ".$request->user());   
        //return response()->json(["typeAccess"=>Auth::user()]);
        if($request->action == 'admin'){

            $allStations = DB::table('station')->where(['state'=> $request->state])->get();
            
            $i = 0;
            $stSus = $request->user()->stationsSuscribed;
            $countStSus = count(Auth::user()->stationsSuscribed);
            $stations = array();
            
            foreach($allStations as $st){
                if($i != $countStSus){
                    if($stSus[$i] == $st['id']){
                        array_push($stations, $st);
                    }
                }else{
                    break;
                }
                $i+=1;
            }

        }else{
            $stations = DB::table('station')->where(['state'=> $request->state])->get();
        }
       
        return response()->json(['stations'=>$stations, 'typeAccess'=>Auth::user()->typeAccess]);
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
