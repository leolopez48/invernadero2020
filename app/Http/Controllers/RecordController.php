<?php

namespace App\Http\Controllers;

use App\Record;
use App\Station;
use App\Notification;
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

            $notification = new Notification();
            $notification->id = $request->id;
            $notification->temperature = $request->temperature;
            $notification->humidity = $request->humidity;
            $notification->radiation = $request->radiation;
            $notification->updated_at = date("Y-m-d h:i:s A", time());
            $notification->created_at = date("Y-m-d h:i:s A", time());
            $not = new NotificationController();
            $not->add($notification);

            return response()->json(['message'=>'success']);
        } catch (\Throwable $th) {
           return response()->json(['message'=>'failed']);
        }
   }

   function get($id){
       try{
            $records = DB::table('record')->where(['id'=>$id])->get();
            $stations = DB::table('station')->where(['id'=>$id])->get();
            return response()->json(['message'=>'success', 'records'=>$records,
            'humidityL'=>$stations[0]['humidity'], 'temperatureL'=>$stations[0]['temperature'],
            'radiationL'=>$stations[0]['radiation']]);
        } catch (\Throwable $th) {
            return response()->json(['message'=>'failed']);
        }
   }

   public function filterRecords(Request $request){
    //try {

        $start = $request->start;
        $end = $request->end;
        //$start = date("Y/m/d", strtotime($request->start));
        //$end = date("Y/m/d", strtotime($request->end));
        $id = $request->id;
        $records = DB::table('record')->where(['id'=>$id])->whereBetween('created_at', [$start, $end])->get();
        return response()->json(['message'=>'success', 'records'=>$records]);
    //} catch (\Throwable $th) {
    //    return response()->json(['message'=>'fail'.$th]);
    //}
}
}
