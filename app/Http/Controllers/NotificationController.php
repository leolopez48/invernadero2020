<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;
use App\Station;
use DB;
use Auth;

class NotificationController extends Controller
{
    function __construct(){
    }

    function add(Notification $not){
        try {
            $lowest = DB::table('station')->select('humidity', 'radiation', 'temperature')
            ->where(['id'=>$not->id])->get();

            if($lowest[0]['humidity'] <= $not->humidity ||
            $lowest[0]['radiation'] <= $not->radiation ||
            $lowest[0]['temperature'] <= $not->temperature){

                $not->state = 'Correcto';

            }else{

                $not->state = 'No válido';

            }

            $not->save();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    function get(Request $request){
        $notifications = DB::table('notification')->take(5)->get();
        $station = DB::table('station')->select('id')->where(['id'=>$notifications[0]['id']])->get();
        $stat = array();

        foreach ($notifications as $nt) {
            $station = DB::table('station')->where(['id'=>$nt['id']])->get();
            if(in_array($station[0]['id'], $stat) == false){
                array_push($stat, $station[0]['id']);
            }
        }

        $stations = array();
        foreach ($stat as $st) {
            $st = DB::table('station')->where(['id'=>$st])->get();
            array_push($stations, $st);
        }

        return response()->json(['message'=>'success', 'notification'=>$notifications, 'stations'=>$stations]);
    }
}
