<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;
use App\Station;
use DB;
use Auth;
use Log;
use Http;
use App\Endpoint;

class NotificationController extends Controller
{
    public function __construct()
    {
    }

    public function add(Notification $not)
    {
        try {
            $lowest = DB::table('station')
            ->where(['id'=>$not->id])
            ->get();

            $validated = false;

            if ($validated) {
                if (isset($not->humidity)) {
                    $validated = ($lowest[0]['humidity'] < $not->humidity || $lowest[0]['humidityM'] > $not->humidity) ? true : false;
                }
            } else {
                $validated = false;
            }

            if ($validated) {
                if (isset($not->temperature)) {
                    $validated = ($lowest[0]['temperature'] <= $not->temperature || $lowest[0]['temperatureM'] >= $not->temperature) ? true : false;
                }
            } else {
                $validated = false;
            }

            if ($validated) {
                if (isset($not->radiation)) {
                    $validated = ($lowest[0]['radiation'] <= $not->radiation || $lowest[0]['radiationM'] >= $not->radiation) ? true : false;
                }
            } else {
                $validated = false;
            }

            if ($validated) {
                if (isset($not->ph)) {
                    $validated = ($lowest[0]['ph'] <= $not->ph || $lowest[0]['phM'] >= $not->ph) ? true : false;
                }
            } else {
                $validated = false;
            }

            if ($validated) {
                if (isset($not->oxigen)) {
                    $validated = ($lowest[0]['oxigen'] <= $not->oxigen || $lowest[0]['oxigenM'] > $not->oxigen) ? true : false;
                }
            } else {
                $validated = false;
            }

            if ($validated) {
                $not->state = 'Correcto';
            } else {
                $not->state = 'No válido';
            }

            $this->notificate($lowest[0]['title'], 'Nuevo registro no válido.');

            $not->save();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function get(Request $request)
    {
        $notifications = DB::table('notification')->take(3)->orderBy('created_at', 'desc')->get();
        $station = DB::table('station')->select('id')->where(['id'=>$notifications[0]['id']])->get();
        $stat = array();

        foreach ($notifications as $nt) {
            $station = DB::table('station')->where(['id'=>$nt['id']])->get();
            if (in_array($station[0]['id'], $stat) == false) {
                array_push($stat, $station[0]['id']);
            }
        }

        $stations = array();
        foreach ($stat as $st) {
            $st = DB::table('station')->where(['id'=>$st])->get();
            array_push($stations, $st);
        }

        return response()->json(['message'=>'success', 'notification'=>$notifications, 'stations'=>collect($stations)]);
    }

    public function notificate($title, $message)
    {
        try {
            $endpoints = DB::table('endpoints')->get();
            foreach ($endpoints as $end) {
                $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                ])->post('http://localhost:3000/suscribe', [
                    'dataSuscription' => $end,
                    'title'=>$title,
                    'message'=>$message
                    ]);
            }
            // return response('success', 200);
        } catch (\Throwable $th) {
            Log::error('Error: '.$th);
        }
    }

    public function suscribe(Request $request)
    {
        try {
            $founded = false;
            $endpoints = DB::table('endpoints')->select('endpoint')->get();

            foreach ($endpoints as $end) {
                if (!$founded) {
                    if ($end['endpoint'] == $request->dataSuscription['endpoint']) {
                        $founded = true;
                        break;
                    }
                }
            }

            if (!$founded) {
                DB::table('endpoints')->insert($request->dataSuscription);
            }
            return response(200);
        } catch (\Throwable $th) {
            Log::error('Error: '.$th);
        }
    }
}
