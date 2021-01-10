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

    /*
        Agrega notificaciones en su respectiva tabla validando los campos de la estación específica.
    */
    public function add(Notification $not)
    {
        try {
            $lowest = DB::table('station')
            ->where(['id'=>$not->id])
            ->get();

            $validated = false;
            $vars = "";

            if ($validated) {
                if (isset($not->humidity)) {
                    if ($lowest[0]['humidity'] < $not->humidity || $lowest[0]['humidityM'] > $not->humidity) {
                        $validated = true;
                    } else {
                        $vars += ' Húmedad';
                        $validated = false;
                    }
                }
            } else {
                $validated = false;
            }

            if ($validated) {
                if (isset($not->temperature)) {
                    if ($lowest[0]['temperature'] < $not->temperature || $lowest[0]['temperatureM'] > $not->temperature) {
                        $validated = true;
                    } else {
                        $vars += ' Temperatura';
                        $validated = false;
                    }
                }
            } else {
                $validated = false;
            }

            if ($validated) {
                if (isset($not->radiation)) {
                    if ($lowest[0]['radiation'] < $not->radiation || $lowest[0]['radiationM'] > $not->radiation) {
                        $validated = true;
                    } else {
                        $vars += ' Radiación';
                        $validated = false;
                    }
                }
            } else {
                $validated = false;
            }

            if ($validated) {
                if (isset($not->ph)) {
                    if ($lowest[0]['ph'] < $not->ph || $lowest[0]['phM'] > $not->ph) {
                        $validated = true;
                    } else {
                        $vars += ' PH';
                        $validated = false;
                    }
                }
            } else {
                $validated = false;
            }

            if ($validated) {
                if (isset($not->oxigen)) {
                    if ($lowest[0]['oxigen'] < $not->oxigen || $lowest[0]['oxigenM'] > $not->oxigen) {
                        $validated = true;
                    } else {
                        $vars += ' Oxígeno';
                        $validated = false;
                    }
                }
            } else {
                $validated = false;
            }

            if ($validated) {
                $not->state = 'Correcto';
            } else {
                $not->state = 'No válido';
            }

            $this->notificate($lowest[0]['title'], 'Lectura fuera de los límites establecidos. Variables no válidas:'.$vars);

            $not->save();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /*
        Retorna un JSON con las últimas 3 notificaciones, estas notificaciones son accedidas
        por medio de una API que será consumida desde el frontend.
    */
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

    /*
        Recupera cada una de los endpoints registrados para luego conectarse con el servidor de
        notificaciones webpush para notificar a cada uno de los usuarios.
    */
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

    /*
        Cuando un usuario se conecta a la aplicación este método se encarga de verificar si el usuario
        ha sido registrado con anterioridad, y en el caso que no lo esté lo registra.
        Los endpoints acá registrados serán luego utilizados por el método notificate para notificar
        a cada uno de los usuarios registrados.
    */
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
