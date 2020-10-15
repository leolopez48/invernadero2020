<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class UserController extends Controller
{
    public function findUser(Request $request){
        $idStation = (int)$request->idStation;
        $email = $request->email;
        $user = DB::table('users')->select('name','email','stationsSuscribed')->where(["email"=>$email])->get();

        $statSuscribed = $user[0]['stationsSuscribed'];
        $i = 0;
        foreach($statSuscribed as $st){
            if($idStation == $st[$i]){
                return response()->json(['message'=>'Station already added.', 'user'=>$user]);
            }
            $i+=1;
        }
        return response()->json(['message'=>'success', 'user'=>$user]);

    }

    public function addStationUser(Request $request){

        $email = $request->email;
        $stationId = (int)$request->idStation;

        $stations = DB::table('users')->select('email','_id','stationsSuscribed')->where(["email"=>$email])->get();
        $st = $stations->toArray();
        
        if(count($stations[0]['stationsSuscribed']) == 0){
            $newStations = array(strval($stationId));
        }else{
            $newStations = array(strval($st[0]['stationsSuscribed'][0]), strval($stationId));
        }
        $id = $stations[0]['_id'];

        DB::table('users')->where(["_id"=>$id])->update(['stationsSuscribed'=>$newStations]);
        return response()->json(['message'=>'success']);
    }

    public function user(){
        dd(Auth::user()->stationsSuscribed);
    }
}
