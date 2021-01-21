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

            $validatedH = true;
            $validatedT = true;
            $validatedR = true;
            $validatedO = true;
            $validatedP = true;
            $vars = "";

            if ($validatedH) {
                if (isset($not->humidity)) {
                    if ($not->humidity  < $lowest[0]['humidity'] || $not->humidity > $lowest[0]['humidityM']) {
                        $vars = $vars.' Húmedad';
                        $validatedH = false;
                    } else {
                        $validatedH = true;
                    }
                }
            } else {
                $validatedH = false;
            }

            if ($validatedT) {
                if (isset($not->temperature)) {
                    if ($not->temperature  < $lowest[0]['temperature'] || $not->temperature > $lowest[0]['temperatureM']) {
                        $vars = $vars.' Temperatura';
                        $validatedT = false;
                    } else {
                        $validatedT = true;
                    }
                }
            } else {
                $validatedT = false;
            }

            if ($validatedR) {
                if (isset($not->radiation)) {
                    if ($not->radiation  < $lowest[0]['radiation'] || $not->radiation > $lowest[0]['radiationM']) {
                        $vars = $vars.' Radiación';
                        $validatedR = false;
                    } else {
                        $validatedR = true;
                    }
                }
            } else {
                $validatedR = false;
            }

            if ($validatedP) {
                if (isset($not->ph)) {
                    if ($not->ph  < $lowest[0]['ph'] || $not->ph > $lowest[0]['phM']) {
                        $vars = $vars.' PH';
                        $validatedP = false;
                    } else {
                        $validatedP = true;
                    }
                }
            } else {
                $validatedP = false;
            }

            if ($validatedO) {
                if (isset($not->oxigen)) {
                    if ($not->oxigen  < $lowest[0]['oxigen'] || $not->oxigen > $lowest[0]['oxigenM']) {
                        $vars = $vars.' Oxígeno';
                        $validatedO = false;
                    } else {
                        $validatedO = true;
                    }
                }
            } else {
                $validatedO = false;
            }

            if ($validatedH && $validatedT && $validatedR && $validatedO && $validatedP) {
                $not->state = 'Válido';
            } else {
                $not->state = 'No válido';
                $this->notificate($lowest[0]['title'], 'Lectura fuera de los límites establecidos. Variables no válidas:'.$vars);
            }

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
