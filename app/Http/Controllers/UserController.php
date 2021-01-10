<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class UserController extends Controller
{
    /*
        Buscar un usuario por el correo electrónico con el que se ha registrado.
        Esta función es la que se utiliza en el buscador de usuarios de la pestaña admin.
    */
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
                if ($idStation == $st) {
                    return response()->json(['message' => 'Station already added.', 'user' => $user]);
                }
                $i += 1;
            }
            return response()->json(['message' => 'success', 'user' => $user]);
        }
    }

    /*
    Si el usuario ha sido encontrado y el usuario quiere agregarlo para darle permisos
    de administrador al email seleccionado se invocará este método para agregar al usuario
    dentro de las suscripciones que la estación seleccionada.
    */
    public function addStationUser($idStation, $email)
    {
        $stationId = (int)$idStation;

        $stations = DB::table('users')->select('email', '_id', 'stationsSuscribed')->where(["email" => $email])->get();
        $st = $stations->toArray();

        $newStations = array();
        if (count($stations[0]['stationsSuscribed']) == 0) {
            array_push($newStations, strval($stationId));
        } else {
            $i = 0;
            for ($j = 0; $j < count($stations[0]['stationsSuscribed']); $j++) {
                array_push($newStations, strval($stations[0]['stationsSuscribed'][$i]));
                $i += 1;
            }
            array_push($newStations, strval($stationId));
        }

        $id = $stations[0]['_id'];
        DB::table('users')->where(["_id" => $id])->update(['stationsSuscribed' => $newStations]);

        return response()->json(['message' => $newStations]);
    }

    /*
    Si el usuario ha sido encontrado y el usuario quiere agregarlo para darle permisos
    de administrador al email seleccionado se invocará este método para agregar al usuario
    dentro de las suscripciones que la estación seleccionada.
    */
    public function addStationToUser(Request $request)
    {
        $email = $request->email;
        $stationId = $request->idStation;

        $stations = DB::table('users')->select('email', '_id', 'stationsSuscribed')->where(["email" => $email])->get();
        $st = $stations->toArray();

        $newStations = array();
        if (count($stations[0]['stationsSuscribed']) == 0) {
            array_push($newStations, strval($stationId));
        } else {
            $i = 0;
            for ($j = 0; $j < count($stations[0]['stationsSuscribed']); $j++) {
                array_push($newStations, strval($stations[0]['stationsSuscribed'][$i]));
                $i += 1;
            }
            array_push($newStations, strval($stationId));
        }

        $id = $stations[0]['_id'];
        DB::table('users')->where(["_id" => $id])->update(['stationsSuscribed' => $newStations]);

        return response()->json(['message' => 'success']);
    }

    /*
    Busca los usuarios que están suscritos a una estación específica y los retorna en forma de array
    para luego ser mostrados en la pestaña de administración.
    */
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

    /*
        Si a un usuario específico ya no se le darán permisos de administrador
        dentro de la estación esta función eliminará la estación de sus suscripciones.
    */
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

    public function user()
    {
        dd(Auth::user());
    }
}
