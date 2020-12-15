<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Station;
use DB;
use Storage;
use Auth;
use MongoDB\BSON\Decimal128;

class StationController extends Controller
{

    public function prueba(Request $request){

        $medidas = $request->stations;
        $minimos = $request->minimos;
        $title = $request->title;
        $description = $request->description;
        $date = date('Y-m-d\TH:m:s');

        $ultimoId = Station::all('id')->last()->id + 1;
        DB::table('station')->insert([
            'id'=>strval($ultimoId),
            'title'=>$title,
            'description'=>$description,
            'created_at'=> $date,
            'updated_at'=> $date,
        ]);

        for($i = 0; $i < count($minimos); $i++){
            DB::table('station')->where(['id'=>strval($ultimoId)])->update([$medidas[$i] => $minimos[$i]]);
        }
    }

    public function add(Request $request)
    {

        try {
            if ($request->user()->typeAccess == 1) {

                if ($request->hasFile('photo')) {
                    $photo = Storage::put('public', $request->photo);
                    $url = Storage::url($photo);
                    $fullUrl = asset($url);
                }

                if ((int)Station::all('id')->count() == 0) {
                    $lastId = 1;
                } else {
                    $lastId = (int)Station::all('id')->last()->id; //Get the lastest id value of stations
                    $lastId += 1; //Add 1 to set the new value to the station
                }

                $newId = strval($lastId);
                $title = $request->title;
                $description = $request->description;
                $state = true;
                $date = date('Y-m-d\TH:m:s');

                //FormData append the arrays as a unique string value, so it's needed
                //to split it
                $vars = array();
                $vars = explode(',', $request->minVars);
                $minimums = array();
                $minimums = explode(',', $request->minimums);
                $maximums = array();
                $maximums = explode(',', $request->maximums);

                //Add user suscription
                $user = new UserController();
                if(Auth::user()->typeAccess == 1){
                    $user->addStationUser($newId, 'admin@gmail.com');
                }else{
                    $user->addStationUser($newId, 'admin@gmail.com');
                    $user->addStationUser($newId, Auth::user()->email);
                }

                $st = new Station();
                $st->id = $newId;
                $st->title = $title;
                $st->description = $description;
                $st->photo = $fullUrl;
                $st->state = $state;
                DB::table('station')->insert([
                    'id'=>strval($newId),
                    'title'=>$title,
                    'description'=>$description,
                    'created_at'=> $date,
                    'updated_at'=> $date,
                    'state'=> $state,
                    'photo'=> $fullUrl
                ]);
                for($i = 0; $i < count($minimums); $i++){

                    /*if($vars[$i] == 'temperature'){
                        DB::table('station')->where(['id'=>strval($newId)])
                        ->update(['temperature' => new Decimal128($minimums[$i]),
                        'temperatureM'=>new Decimal128($maximums[$i])]);
                    }
                    if($vars[$i] == 'humidity'){
                        DB::table('station')->where(['id'=>strval($newId)])
                        ->update(['humidity' => $minimums[$i],
                        'humidityM'=>$maximums[$i]]);
                    }
                    if($vars[$i] == 'radiation'){
                        DB::table('station')->where(['id'=>strval($newId)])
                        ->update(['radiation' => $minimums[$i],
                        'radiationM'=>$maximums[$i]]);
                    }
                    if($vars[$i] == 'ph'){
                        DB::table('station')->where(['id'=>strval($newId)])
                        ->update(['ph' => $minimums[$i],
                        'phM'=>$maximums[$i]]);
                    }
                    if($vars[$i] == 'oxigen'){
                        DB::table('station')->where(['id'=>strval($newId)])
                        ->update(['oxigen' => $minimums[$i],
                        'oxigenM'=>$maximums[$i]]);
                    }*/
                    $this->addVar($vars[$i], $newId, $minimums[$i], $maximums[$i]);
                }

                return response()->json(["message" => "success"]);
            } else {
                return response()->json(["message" => "error"]);
            }
       } catch (\Throwable $th) {
            return response()->json(["message" => $th->getMessage()]);
        }
    }

    public function addVar($variable, $id, $minimum, $maximum){
        DB::table('station')->where(['id'=>strval($id)])
        ->update([$variable => new Decimal128($minimum),
        $variable.'M'=> new Decimal128($maximum)]);
    }

    public function index(Request $request)
    {
        if ($request->action == 'admin') {

            $allStations = DB::table('station')->where(['state' => $request->state])->get();

            $i = 0;
            $stSus =Auth::user()->stationsSuscribed;
            $countStSus = count(Auth::user()->stationsSuscribed);
            $stations = array();

            foreach ($allStations as $st) {
                if ($i != $countStSus) {
                        array_push($stations, $st);
                }
                $i += 1;
            }
            return response()->json(['stations' => $stations, 'typeAccess' => Auth::user()->typeAccess]);
        } else {
            $stations = DB::table('station')->where(['state' => $request->state])->get();
            return response()->json(['stations' => $stations]);
        }

    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $title = $request->title;
        $description = $request->description;
        $temperature = $request->temperature;
        $humidity = $request->humidity;
        $radiation = $request->radiation;

        if ($request->hasFile('photo')) {

            $photo = Storage::put('public', $request->photo);
            $url = Storage::url($photo);
            $fullUrl = asset($url);

            $stationU = DB::table('station')->where(['id' => $id])->update([
                "photo" => $fullUrl, "title" => $title,
                "description" => $description, "humidity" => $humidity, "temperature" => $temperature, "radiation" => $radiation
            ]);

            return response()->json(["stationU" => $stationU, 'id' => $id, "message" => "success"]);
        } else {
            $stationU = DB::table('station')->where(['id' => $id])->update([
                "title" => $title,
                "description" => $description, "humidity" => $humidity, "temperature" => $temperature, "radiation" => $radiation
            ]);
            return response()->json(["id" => $stationU, "message" => "success"]);
        }
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $stationA = DB::table('station')->where(['id' => $id])->get();
        if ($stationA[0]["state"] == true) {
            $stationA = DB::table('station')->where(['id' => $id])->update(["state" => false]);
        } else {
            $stationA = DB::table('station')->where(['id' => $id])->update(["state" => true]);
        }
        return response()->json(["id" => $request->id, "message" => "success"]);
    }
}
