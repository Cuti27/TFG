<?php

namespace App\Http\Controllers\API;

use App\Http\ClientHTTP;
use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\DigitalOutput;
use App\Models\Emitter;
use App\Models\Head;
use App\Models\History;
use App\Models\Programs;
use App\Models\Sector;
use App\Models\Timer;
use Hamcrest\Core\IsNull;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProgramController extends Controller
{
    /**
     * Create a program
     * 
     * @return \Illuminate\Http\Response
     */
    public function createProgram(Request $request)
    {
        // Recuperamos y validamos el formulario
        $fields = $request->validate([
            'programId' => 'integer',
            'name' => 'required|string',
            'headId' => 'required',
            'programDays' => 'required | array',
            'emitter' => 'required | array',
            'emitter.*.id' => 'required',
            'drip' => 'required | boolean',
            'afterProgram' => 'required | boolean',
            'autoTimer' => 'required | boolean',
            'automaticDays' => 'required | boolean',
            'active' => 'required | boolean',
            'sector' => 'required | array',
            'sector.*.id' => 'required',
            'timer' => 'required | array',
            'timer.*.duration' => 'required',
            'timer.*.timeStart' => 'required',
            'timer.*.postIrrigation' => 'required',
        ]);

        error_log("Vamos recuperar el cabezal");

        // Comprobamos que el cabezal es del usuario, y es correcto
        $head = Head::where("userId", $request->user()->id)->where('id', $fields['headId'])->first();

        if (!$head) {
            return response([
                'message' => 'Bad head'
            ], 400);
        }

        error_log("Hemos recuperado el cabezal vamos a guardar los tiempos");

        // Calculamos el inicio y fin del programa
        $end = array();
        $start = array();
        foreach ($fields['timer'] as $timer) {
            // error_log(print_r($timer, TRUE));
            $start[] = $timer["timeStart"];

            $end[] = date('H:i:s', strtotime($timer["timeStart"]) + strtotime($timer["duration"])
                + strtotime($timer["postIrrigation"]) - strtotime('00:00:00'));
        }

        error_log("Fecha de inicio");
        // error_log(print_r($start, TRUE));
        error_log("Fecha de fin");
        error_log(print_r($end, TRUE));

        // Recuperamos la lista de programas asociados, en los que algún día de la semana coincide con el de nuestro programa
        $query =
            Programs::where('headId', $head->id)->where(function ($query) use ($fields) {
                $first = true;
                if ($fields['programDays'][0]) {
                    if ($first) {
                        $query->where('mon', true);
                        $first = false;
                    }
                }
                if ($fields['programDays'][1]) {
                    if ($first) {
                        $query->where('tue', true);
                        $first = false;
                    } else $query->orWhere('tue', true);
                }
                if ($fields['programDays'][2]) {
                    if ($first) {
                        $query->where('wed', true);
                        $first = false;
                    } else $query->orWhere('wed', true);
                }
                if ($fields['programDays'][3]) {
                    if ($first) {
                        $query->where('thu', true);
                        $first = false;
                    } else $query->orWhere('thu', true);
                }
                if ($fields['programDays'][4]) {
                    if ($first) {
                        $query->where('fri', true);
                        $first = false;
                    } else $query->orWhere('fri', true);
                }
                if ($fields['programDays'][5]) {
                    if ($first) {
                        $query->where('sat', true);
                        $first = false;
                    } else $query->orWhere('sat', true);
                }
                if ($fields['programDays'][6]) {
                    if ($first) {
                        $query->where('sun', true);
                        $first = false;
                    } else $query->orWhere('sun', true);
                }
            });

        if (array_key_exists('programId', $fields)) {
            $query = $query->where('id', '!=', $fields['programId']);
        }

        $listPrograms = $query->pluck('id');

        $creation = false;

        error_log("Hemos encontrado una lista de programas");
        error_log(print_r($listPrograms, TRUE));

        if ($listPrograms) {

            // Recuperamos la lista de programas asociados a los emisores
            $listEmitterMsg = array();

            foreach ($fields['emitter'] as $emitter) {
                $listEmitterMsg[] = $emitter["id"];
            }

            error_log("Hemos recuperado la lista de emmiter del mensaje");

            $listProgramsEmitter = Emitter::whereIn('digitalOutputId', $listEmitterMsg)->whereIn('programId', $listPrograms)->pluck('programId');

            error_log("Listado de emisores");
            // error_log(print_r($listProgramsEmitter, TRUE));

            if ($listProgramsEmitter) {

                // Recuperamos los temporizadores de todos ellos

                $listTimer = Timer::whereIn('programId', $listProgramsEmitter)->get();

                error_log("Listado de temporizadores");
                // error_log(print_r($listTimer, TRUE));

                if ($listTimer) {
                    // Recorremos todos los timer encontrados, y todos los timer enviados, para ver si existe alguna incompatibilidad

                    error_log("Vamos a comprobar todos los timer");
                    foreach ($listTimer as $timer) {
                        foreach (range(0, count($start) - 1) as $index) {
                            $startBetween = $timer->timeStart >= $start[$index] && $timer->timeStart <= $end[$index];
                            $endBetween = $timer->end_time >= $start[$index] && $timer->end_time <= $end[$index];

                            $startBeforeButEndLater = $timer->timeStart < $start[$index] &&
                                $timer->end_time > $end[$index];
                            // En caso de que empiece o termina a la misma vez
                            if ($startBetween || $endBetween || $startBeforeButEndLater) {
                                $programId = $timer->programId;
                                $error = "El programa con id $programId, tiene el mismo emisor,y el temporizador que empieza $start[$index] y termina $end[$index], coincide con el temporizador del otro programa que comienza $timer->timeStart y termina $timer->end_time.";

                                if ($startBetween) {
                                    $error = $error . " Por tanto, el temporizador creado empieza entre el inicio y finalización del otro programa";
                                }
                                if ($endBetween) {
                                    $error = $error . " Por tanto, el temporizador creado termina entre el inicio y finalización del otro programa";
                                }
                                if ($startBeforeButEndLater) {
                                    $error = $error . " Por tanto, el temporizador creado empieza antes del inicio pero termina despues de la finalización del otro programa";
                                }

                                $error = $error . " Por favor, seleccione uno distinto.";

                                // $error = "El programa con id $programId, tiene el mismo emisor,y el temporizador que empieza $start[$index], coincide con el temporizador del otro programa que comienza $timer->timeStart. Por favor, seleccione uno distinto.";
                                return response([
                                    'customError' => true,
                                    'message' => $error
                                ], 400);
                            }
                        }
                    }
                    error_log("Terminado de checkear todos los timer correctamente");
                }
            } else $creation = true;

            // Repetimos el proceso pero con los sectores, para ver que no exista ningun problema

            $listSectorMsg = array();

            foreach ($fields['sector'] as $sector) {
                $listSectorMsg[] = $sector["id"];
            }

            $listProgramsSector = Sector::whereIn('digitalOutputId', $listSectorMsg)->whereIn('programId', $listPrograms)->pluck('programId');

            if ($listProgramsEmitter) {

                // Recuperamos los temporizadores de todos ellos
                $listTimer = Timer::whereIn('programId', $listProgramsSector)->get();

                if ($listTimer) {
                    // Recorremos todos los timer encontrados, y todos los timer enviados, para ver si existe alguna incompatibilidad
                    foreach ($listTimer as $timer) {
                        foreach (range(0, count($start) - 1) as $index) {
                            $startBetween = $timer->timeStart >= $start[$index] && $timer->timeStart <= $end[$index];
                            $endBetween = $timer->end_time >= $start[$index] && $timer->end_time <= $end[$index];

                            $startBeforeButEndLater = $timer->timeStart < $start[$index] &&
                                $timer->end_time > $end[$index];
                            // En caso de que empiece o termina a la misma vez
                            if ($startBetween || $endBetween || $startBeforeButEndLater) {
                                $programId = $timer->programId;
                                $error = "El programa con id $programId, tiene el mismo emisor,y el temporizador que empieza $start[$index] y termina $end[$index], coincide con el temporizador del otro programa que comienza $timer->timeStart y termina $timer->end_time.";


                                if ($startBetween) {
                                    $error = $error . " Por tanto, el temporizador creado empieza entre el inicio y finalización del otro programa";
                                }
                                if ($endBetween) {
                                    $error = $error . " Por tanto, el temporizador creado termina entre el inicio y finalización del otro programa";
                                }
                                if ($startBeforeButEndLater) {
                                    $error = $error . " Por tanto, el temporizador creado empieza antes del inicio pero termina despues de la finalización del otro programa";
                                }

                                $error = $error . " Por favor, seleccione uno distinto.";

                                return response([
                                    'customError' => true,
                                    'message' => $error
                                ], 400);
                            }
                        }
                    }

                    // Si hemos llegado aqui debemos crear el programa
                    $creation = true;
                }
            } else $creation = true;
        } else $creation = true;



        if ($creation) {


            if (array_key_exists('programId', $fields)) {
                $program = Programs::where('id', $fields['programId']);

                Emitter::where('programId', $fields['programId'])->delete();
                Sector::where('programId', $fields['programId'])->delete();
                Timer::where('programId', $fields['programId'])->delete();

                $program->update([
                    'fertigationId' => null,
                    'name' => $fields['name'],
                    'userId' =>  $request->user()->id,
                    'headId' => $fields['headId'],
                    'active' => $fields['active'],
                    'autoTimer' => $fields['autoTimer'],
                    'afterProgram' => $fields['afterProgram'],
                    'automaticDays' => $fields['automaticDays'],
                    'drip' => $fields['drip'],
                    'mon' => $fields['programDays'][0],
                    'tue' => $fields['programDays'][1],
                    'wed' => $fields['programDays'][2],
                    'thu' => $fields['programDays'][3],
                    'fri' => $fields['programDays'][4],
                    'sat' => $fields['programDays'][5],
                    'sun' => $fields['programDays'][6],
                ]);

                $createdProgram = Programs::where('id', $fields['programId'])->first();
            } else {
                // Creamos el programa
                $createdProgram = Programs::create([
                    'fertigationId' => null,
                    'name' => $fields['name'],
                    'userId' =>  $request->user()->id,
                    'headId' => $fields['headId'],
                    'active' => $fields['active'],
                    'autoTimer' => $fields['autoTimer'],
                    'afterProgram' => $fields['afterProgram'],
                    'automaticDays' => $fields['automaticDays'],
                    'drip' => $fields['drip'],
                    'mon' => $fields['programDays'][0],
                    'tue' => $fields['programDays'][1],
                    'wed' => $fields['programDays'][2],
                    'thu' => $fields['programDays'][3],
                    'fri' => $fields['programDays'][4],
                    'sat' => $fields['programDays'][5],
                    'sun' => $fields['programDays'][6],
                ]);
            }

            $listCreatedTimer = [];
            foreach ($fields['timer'] as $timer) {
                $listCreatedTimer[] = Timer::create([
                    'programId' => $createdProgram->id,
                    'timeStart' =>  date(
                        'H:i:s',
                        strtotime($timer['timeStart'])
                    ),
                    'duration' =>  date('H:i:s', strtotime($timer['duration'])),
                    'postIrrigation' =>  date('H:i:s', strtotime($timer['postIrrigation'])),
                ]);
            }

            // Buscamos los dispositivos que debemos informar
            $listDevice = array();
            $emitterToSend = array();
            foreach ($fields['emitter'] as  $emitter) {
                if (!isset($listDevice[$emitter['deviceId']]))
                    $listDevice[$emitter['deviceId']] = $emitter;
                $emitterToSend[$emitter['deviceId']][] = $emitter;
            }
            $sectorToSend = array();
            foreach ($fields['sector'] as  $sector) {
                if (!isset($listDevice[$sector['deviceId']]))
                    $listDevice[$sector['deviceId']] = $sector;
                $sectorToSend[$sector['deviceId']][] = $sector;
            }

            $correctSend = [];

            // Informamos a cada dispositivo con que salidas debe activar
            foreach ($listDevice as $device) {

                $response = [];

                try {
                    $response = Http::timeout(60)->post('http://josemiguel.myqnapcloud.com:41065/programar', [
                        'type' => array_key_exists('programId', $fields) ? 1 : 0, // 1 actualizar 0 crear
                        'deviceId' => $device['deviceId'],
                        'id' => $createdProgram->id, // Id del programa
                        'name' => $createdProgram->name, // Nombre del programa
                        'active' => $createdProgram->active, // Programa activo o inactivo
                        'drip' => $createdProgram->drip, // Goteo
                        'programDay' => $fields['programDays'], // Dias activo
                        'emitter' => $emitterToSend[$device['deviceId']], // Emisores del dispositivo actual
                        'sector' => $sectorToSend[$device['deviceId']], // Sector del dispositivo actual
                        'timer' => $listCreatedTimer, // All timer a enviar
                    ]);
                } catch (ConnectionException $e) {
                   error_log($e->getMessage());
                }



                // 
                if ($response && $response->status() == 200) {
                    $correctSend[] = $device;
                } else
                    break;
            }

            // Delete
            if (count($correctSend) != count($listDevice)) {
                $correctDelete = [];
                foreach ($correctSend as $actualDevice) {

                    $response = [];

                    try {
                        $response = Http::timeout(60)->delete('http://josemiguel.myqnapcloud.com:41065/programa', [
                            'type' => 3, // 1 actualizar 0 crear
                            'deviceId' => $actualDevice,
                            'id' => $createdProgram->id,
                        ]);
                    } catch (ConnectionException $e) {
                       error_log($e->getMessage());
                    }

                    if ($response && $response->getStatusCode() == 200) {
                        $correctDelete[] = $actualDevice;
                    } else break;
                }
                // Delete
                if (count($correctDelete) == count($correctSend)) {
                    foreach ($correctSend as $correctDelete) {
                        $response = null;
                        while (is_null($response) || $response->getStatusCode() != 200) {
                            try {
                                $response = Http::timeout(15)->post('http://josemiguel.myqnapcloud.com:41065/confirmar', [
                                    'type' => 4,
                                    'deviceId' => $actualDevice,
                                    'id' => $createdProgram->id,
                                ]);
                            } catch (ConnectionException $e) {
                                error_log($e->getMessage());
                            }
                        }
                    }


                    $error = "Algunos programadores han perdido la conexión completamente";
                } else {
                    $error = "No hemos podido comunicarnos con todos los dispositivos";
                }
                $createdProgram->delete();
                foreach ($listCreatedTimer as  $timer) {
                    $timer->delete();
                }

                return response([
                    'customError' => true,
                    'message' => $error,
                    'comunicatedDevice' => $correctSend,
                    'correctReset' => $correctDelete
                ], 400);
            }

            // Creamos todos los emisores
            $listCreatedEmitter = [];
            foreach ($fields['emitter'] as $emitter) {
                $listCreatedEmitter[] = Emitter::create([
                    'programId' => $createdProgram->id,
                    'digitalOutputId' => $emitter['id'],
                ]);
            }


            // Creamos todos los receptores
            $listCreatedSector = [];
            foreach ($fields['sector'] as $sector) {

                $listCreatedSector[] = Sector::create([
                    'programId' => $createdProgram->id,
                    'digitalOutputId' => $sector['id'],
                ]);
            }

            $head->touch();

            History::create([
                'userId' => $request->user()->id,
                'description' => "Creación del programa con nombre '$createdProgram->name' en el cabezal $head->name ($head->id)."
            ]);

            $response = [
                'program' => $createdProgram,
                'emitter' => $listCreatedEmitter,
                'sector' => $listCreatedSector,
                'timer' => $listCreatedTimer,
            ];
            return response($response, 201);
        }



        return response("", 400);
    }

    /**
     * List all program
     * 
     * @return \Illuminate\Http\Response
     */
    public function listProgram(Request $request, $id)
    {
        // Recuperamos la lista de programas asociados
        $listPrograms = Programs::where('headId', $id)->where('userId', $request->user()->id)->paginate(15);

        if (!$listPrograms) {
            return response([
                'message' => 'Bad creds'
            ], 401);
        }

        error_log("Listado de programas");
        $timer = array();
        $sector = array();
        $emitter = array();
        foreach ($listPrograms as $value) {
            // error_log(print_r($value, TRUE));
            $result = Timer::where('programId', $value->id)->get();

            if ($result) $timer[] = $result;

            $result = Sector::where('programId', $value->id)->pluck("digitalOutputId");


            $result = DigitalOutput::whereIn('id', $result)->get();
            if ($result) $sector[] = $result;

            $result = Emitter::where('programId', $value->id)->pluck("digitalOutputId");


            $result = DigitalOutput::whereIn('id', $result)->get();
            if ($result) $emitter[] = $result;
        }

        // Creamos la respuesta
        $response = [
            'count' => count($listPrograms),
            'listPrograms' => $listPrograms,
            'timer' => $timer,
            'sector' => $sector,
            'emitter' => $emitter,
        ];

        return response($response, 200);
    }

    public function getProgram(Request $request, string $headId = "", string $id = "")
    {
        $query = Programs::where('userId', $request->user()->id);

        if ($headId) {
            $query = $query->where('headId', $headId);
        }

        if ($id) {
            $query = $query->where('id', $id);
        }

        $listPrograms = $query->get();

        $timer = array();
        $sector = array();
        $emitter = array();
        foreach ($listPrograms as $value) {
            // error_log(print_r($value, TRUE));
            $result = Timer::where('programId', $value->id)->get();

            if ($result) $timer[] = $result;

            $result = Sector::where('programId', $value->id)->pluck("digitalOutputId");


            $result = DigitalOutput::whereIn('id', $result)->get();
            if ($result) $sector[] = $result;

            $result = Emitter::where('programId', $value->id)->pluck("digitalOutputId");


            $result = DigitalOutput::whereIn('id', $result)->get();
            if ($result) $emitter[] = $result;
        }

        // Creamos la respuesta
        $response = [
            'count' => count($listPrograms),
            'listPrograms' => $listPrograms,
            'timer' => $timer,
            'sector' => $sector,
            'emitter' => $emitter,
        ];

        return response($response, 200);
    }

    /**
     * Delete a program
     * 
     * @return \Illuminate\Http\Response
     */
    public function deleteProgram(Request $request)
    {

        // Recuperamos y validamos el formulario
        $fields = $request->validate([
            'programId' => 'required',
            'headId' => 'required',
        ]);

        // Recuperamos la lista de programas asociados
        $program = Programs::where('headId', $fields['headId'])->where('userId', $request->user()->id)->where('id', $fields['programId'])->first();

        if (!$program) {
            return response([
                'message' => 'Bad params'
            ], 400);
        }

        $listEmitterOutputId = Emitter::where('programId', $program->id)->pluck('digitalOutputId');
        $listSectorOutputId = Sector::where('programId', $program->id)->pluck('digitalOutputId');

        $listEmitterId = DigitalOutput::whereIn('id', $listEmitterOutputId)->pluck('deviceId')->toArray();
        $listSectorId = DigitalOutput::whereIn('id', $listSectorOutputId)->pluck('deviceId')->toArray();

        $listAllDevices = array_merge($listEmitterId, $listSectorId);

        $correctDelete = [];
        // Check connection
        foreach ($listAllDevices as $actualDevice) {

             $response = [];

                    try {
                        $response = Http::timeout(60)->delete('http://josemiguel.myqnapcloud.com:41065/programa', [
                            'type' => 3, // 1 actualizar 0 crear
                            'deviceId' => $actualDevice,
                            'id' => $program->id,
                        ]);
                    } catch (ConnectionException $e) {
                       error_log($e->getMessage());
                    }


            if ($response && $response->getStatusCode() == 200) {
                $correctDelete[] = $actualDevice;
            }
        }
        // Delete
        if (count($correctDelete) != count($listAllDevices)) {
            foreach ($listAllDevices as $actualDevice) {
                $response = null;
                while (is_null($response) || $response->getStatusCode() != 200) {
                    try {
                        $response = Http::timeout(15)->post('http://josemiguel.myqnapcloud.com:41065/confirmar', [
                            'type' => 4,
                            'deviceId' => $actualDevice,
                            'id' => $program->id,
                        ]);
                    } catch (ConnectionException $e) {
                       error_log($e->getMessage());
                    }
                }
            }

            $error = "No hemos podido comunicarnos con el dispositivo $actualDevice, intentelo más tarde";
            return response([
                'customError' => true,
                'message' => $error
            ], 400);
        }

        Sector::where('programId', $program->id)->delete();

        Emitter::where('programId', $program->id)->delete();

        Timer::where('programId', $program->id)->delete();


        $program->delete();

        $head = Head::where("id", $fields['headId'])->first();

        $head->touch();

        History::create([
            'userId' => $request->user()->id,
            'description' => "Eliminación del programa $program->name"
        ]);

        return response("", 204);
    }

    public function changeProgram(Request $request, string $id)
    {

        $program = Programs::where('id', $id)->where('userId', $request->user()->id)->first();
        if (!$program) {
            return response([
                'message' => 'Bad params'
            ], 400);
        }


        $program->active = !$program->active;

        $listEmitterOutputId = Emitter::where('programId', $program->id)->pluck('digitalOutputId');
        $listSectorOutputId = Sector::where('programId', $program->id)->pluck('digitalOutputId');

        $listEmitterId = DigitalOutput::whereIn('id', $listEmitterOutputId)->get();
        $listSectorId = DigitalOutput::whereIn('id', $listSectorOutputId)->get();


        $listDevice = array();
            $emitterToSend = array();
            foreach ($listEmitterId as  $emitter) {
                if (!isset($listDevice[$emitter['deviceId']]))
                    $listDevice[$emitter['deviceId']] = $emitter;
                $emitterToSend[$emitter['deviceId']][] = $emitter;
            }
            $sectorToSend = array();
            foreach ($listSectorId as $sector) {
                if (!isset($listDevice[$sector->deviceId]))
                    $listDevice[$sector->deviceId] = $sector;
                $sectorToSend[$sector->deviceId][] = $sector;
            }

        $response = [];
        foreach ($listDevice as $actualDevice) {
            

            $response = Http::timeout(60)->post('http://josemiguel.myqnapcloud.com:41065/programar', [
                'type' => 1, // 1 actualizar 0 crear
                'deviceId' => $actualDevice,
                'id' => $program->id, // Id del programa
                'name' => $program->name, // Nombre del programa
                'active' => $program->active, // Programa activo o inactivo
                'drip' => $program->drip, // Goteo
                'programDay' => [
                    $program->mon,
                    $program->tue,
                    $program->wed,
                    $program->thu,
                    $program->fri,
                    $program->sat,
                    $program->sun,
                ], // Dias activo
                'emitter' => $emitterToSend[$actualDevice['deviceId']], // Emisores del dispositivo actual
                        'sector' => $sectorToSend[$actualDevice['deviceId']], // Sector del dispositivo actual
                'timer' => Timer::where('programId', $program->id)->get(), // All timer a enviar
            ]);
        }

        if ($response && $response->getStatusCode() == 200) {
            $program->save();
            return response("", 204);
        } else {
            return response([
                'customError' => true,
                'message' => "No hemos podido comunicarnos con todos los dispositivos"
            ], 400);
        }

        

        

        
    }
}
