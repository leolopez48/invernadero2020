<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class UserController extends Controller
{
    public function findUser(Request $request)
    {
        $idStation = (int)$request->idStation;
        $email = $request->email;
        $user = DB::table('users')->select('name', 'email', 'stationsSuscribed')->where(["email" => $email])->get();
        if (count($user) == 0) {
            return response()->json(['message' => 'User not found.']);
        } else {
            $statSuscribed = $user[0]['stationsSuscribed'];
            $i = 0;
            foreach ($statSuscribed as $st) {
                if ($idStation == $st[$i]) {
                    return response()->json(['message' => 'Station already added.', 'user' => $user]);
                }
                $i += 1;
            }
            return response()->json(['message' => 'success', 'user' => $user]);
        }
    }

    public function addStationUser(Request $request)
    {

        $email = $request->email;
        $stationId = (int)$request->idStation;

        $stations = DB::table('users')->select('email', '_id', 'stationsSuscribed')->where(["email" => $email])->get();
        $st = $stations->toArray();

        if (count($stations[0]['stationsSuscribed']) == 0) {
            $newStations = array(strval($stationId));
        } else {
            $newStations = array(strval($st[0]['stationsSuscribed'][0]), strval($stationId));
        }
        // dd($newStations);
        $id = $stations[0]['_id'];
        DB::table('users')->where(["_id" => $id])->update(['stationsSuscribed' => $newStations]);

        return response()->json(['message' => 'success']);
    }

    public function getUsersSuscribed(Request $request)
    {

        $usersSucribed = array();

        $users = DB::table('users')->select('name', 'email', 'typeAccess', 'stationsSuscribed')->get();
        if (count($users) == 0) {
            return response()->json(['message' => 'success']);
        } else {
            foreach ($users as $user) {
                if ($user['typeAccess'] != 1) {
                    $usersCount = count($user['stationsSuscribed']);
                    $j = 0;
                    if ($usersCount > 0) {
                        while ($j < $usersCount) {
                            if ($user['stationsSuscribed'][$j] == $request->idStation) {
                                array_push($usersSucribed, $user);
                            }
                            $j += 1;
                        }
                    }
                }
            }
        }
        return response()->json(["message" => "success", "users" => $usersSucribed]);
    }

    public function deleteUserSuscription(Request $request)
    {
        $email = $request->email;
        $stationId = (int)$request->idStation;
        $newStations = array();

        $user = DB::table('users')->select('email', '_id', 'stationsSuscribed')->where(["email" => $email])->get();
        $us = $user->toArray();

        $usersCount = count($user[0]['stationsSuscribed']);
        $j = 0;
        if ($usersCount > 0) {
            while ($j < $usersCount) {
                if ($us[0]['stationsSuscribed'][$j] != $request->idStation) {
                    array_push($newStations, $us[0]['stationsSuscribed'][$j]);
                }
                $j += 1;
            }
        }

        DB::table('users')->where(["email" => $email])->update(['stationsSuscribed' => $newStations]);

        return response()->json(['message' => 'success']);
    }
}
