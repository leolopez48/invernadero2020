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
                    $lastId = Station::all('id'); //Get the lastest id value of stations
                    $id = 0;
                    foreach ($lastId as $last) {
                        if ($last['id'] >= $id) {
                            $id = (int)$last['id'];
                        }
                    }
                    $lastId = $id+1; //Add 1 to set the new value to the station
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
                if (Auth::user()->typeAccess == 1) {
                    $user->addStationUser($newId, 'admin@gmail.com');
                } else {
                    $user->addStationUser($newId, 'admin@gmail.com');
                    $user->addStationUser($newId, Auth::user()->email);
                }

                DB::table('station')->insert([
                    'id'=>strval($newId),
                    'title'=>$title,
                    'description'=>$description,
                    'created_at'=> $date,
                    'updated_at'=> $date,
                    'state'=> $state,
                    'photo'=> $fullUrl
                ]);
                for ($i = 0; $i < count($minimums); $i++) {
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

    public function edit(Request $request)
    {
        try {
            //dd($request);
            $id = $request->id;
            $title = $request->title;
            $description = $request->description;
            $date = date('Y-m-d\TH:m:s');

            //FormData append the arrays as a unique string value, so it's needed
            //to split it
            $vars = array();
            $vars = explode(',', $request->minVars);
            $minimums = array();
            $minimums = explode(',', $request->minimums);
            $maximums = array();
            $maximums = explode(',', $request->maximums);

            $stationOld = DB::table('station')
            ->where(['id'=>$id])
            ->get();

            $deleted = DB::table('station')
            ->where(['id'=>$id])
            ->delete();

            if (isset($stationOld[0]['humidity'])) {
                array_push($minimums, strval($stationOld[0]['humidity']));
                array_push($maximums, strval($stationOld[0]['humidityM']));
            }
            if (isset($stationOld[0]['temperature'])) {
                array_push($minimums, strval($stationOld[0]['temperature']));
                array_push($maximums, strval($stationOld[0]['temperatureM']));
            }
            if (isset($stationOld[0]['radiation'])) {
                array_push($minimums, strval($stationOld[0]['radiation']));
                array_push($maximums, strval($stationOld[0]['radiationM']));
            }
            if (isset($stationOld[0]['ph'])) {
                array_push($minimums, strval($stationOld[0]['ph']));
                array_push($maximums, strval($stationOld[0]['phM']));
            }
            if (isset($stationOld[0]['oxigen'])) {
                array_push($minimums, strval($stationOld[0]['oxigen']));
                array_push($maximums, strval($stationOld[0]['oxigenM']));
            }

            if ($request->hasFile('photo')) {
                $photo = Storage::put('public', $request->photo);
                $url = Storage::url($photo);
                $fullUrl = asset($url);

                $stationU = DB::table('station')->insert([
                'id'=>$id,
                'title'=>$title,
                'description'=>$description,
                'created_at'=> $date,
                'updated_at'=> $date,
                'state'=> true,
                'photo'=> $fullUrl
            ]);

                for ($i = 0; $i < count($minimums); $i++) {
                    $this->addVar($vars[$i], $id, $minimums[$i], $maximums[$i]);
                }


                return response()->json(["stationU" => $stationU, 'id' => $id, "message" => "success"]);
            } else {
                $photo = $stationOld[0]["photo"];

                $stationU = DB::table('station')->insert([
                'id'=>$id,
                'title'=>$title,
                'description'=>$description,
                'created_at'=> $date,
                'updated_at'=> $date,
                'state'=> true,
                'photo'=> $photo
            ]);

                for ($i = 0; $i < count($minimums); $i++) {
                    $this->addVar($vars[$i], $id, $minimums[$i], $maximums[$i]);
                }

                return response()->json(["id" => $stationU, "message" => "success"]);
            }
        } catch (\Throwable $th) {
            return response()->json(["message" => "Error: ".$th]);
        }
    }

    public function addVar($variable, $id, $minimum, $maximum)
    {
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
                    $station = new Station();
                    $station->title = $st['title'];
                    $station->id = $st['id'];
                    $station->description = $st['description'];
                    $station->photo = $st['photo'];
                    $station->created_at = $st['created_at'];

                    if (isset($st['humidity'])) {
                        $station->humidity = strval($st['humidity']);
                        $station->humidityM = strval($st['humidityM']);
                    }
                    if (isset($st['temperature'])) {
                        $station->temperature = strval($st['temperature']);
                        $station->temperatureM = strval($st['temperatureM']);
                    }
                    if (isset($st['radiation'])) {
                        $station->radiation = strval($st['radiation']);
                        $station->radiationM = strval($st['radiationM']);
                    }
                    if (isset($st['ph'])) {
                        $station->ph = strval($st['ph']);
                        $station->phM = strval($st['phM']);
                    }
                    if (isset($st['oxigen'])) {
                        $station->oxigen = strval($st['oxigen']);
                        $station->oxigenM = strval($st['oxigenM']);
                    }
                    array_push($stations, $station);
                }
                $i += 1;
            }
            return response()->json(['stations' => $stations, 'typeAccess' => Auth::user()->typeAccess]);
        } else {
            $stations = DB::table('station')->where(['state' => $request->state])->get();
            $allStations = array();
            foreach ($stations as $st) {
                $station = new Station();
                $station->title = $st['title'];
                $station->id = $st['id'];
                $station->description = $st['description'];
                $station->photo = $st['photo'];
                $station->created_at = $st['created_at'];

                if (isset($st['humidity'])) {
                    $station->humidity = strval($st['humidity']);
                    $station->humidityM = strval($st['humidityM']);
                }
                if (isset($st['temperature'])) {
                    $station->temperature = strval($st['temperature']);
                    $station->temperatureM = strval($st['temperatureM']);
                }
                if (isset($st['radiation'])) {
                    $station->radiation = strval($st['radiation']);
                    $station->radiationM = strval($st['radiationM']);
                }
                if (isset($st['ph'])) {
                    $station->ph = strval($st['ph']);
                    $station->phM = strval($st['phM']);
                }
                if (isset($st['oxigen'])) {
                    $station->oxigen = strval($st['oxigen']);
                    $station->oxigenM = strval($st['oxigenM']);
                }
                array_push($allStations, $station);
            }
            return response()->json(['stations' => $allStations]);
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
