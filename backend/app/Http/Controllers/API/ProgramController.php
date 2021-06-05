<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\DigitalOutput;
use App\Models\Emitter;
use App\Models\Head;
use App\Models\Programs;
use App\Models\Sector;
use App\Models\Timer;
use Illuminate\Http\Request;

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
            'programId' => 'string',
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
        $listPrograms = Programs::where('headId', $head->id)->where(function ($query) use ($fields) {
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
        })->pluck('id');

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

                            $startBeforeButEndLater = $timer->timeStart < $start &&
                                $timer->end_time > $end[$index];
                            // En caso de que empiece o termina a la misma vez
                            if ($startBetween || $endBetween || $startBeforeButEndLater) {
                                $programId = $timer->programId;
                                $error = "El programa con id $programId, tiene el mismo emisor,y el temporizador que empieza $start[$index], coincide con el temporizador del otro programa que comienza $timer->timeStart. Por favor, seleccione uno distinto.";
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
                            $startBetween = $timer->timeStart > $start[$index] && $timer->timeStart < $end[$index];
                            $endBetween = $timer->end_time > $start[$index] && $timer->end_time < $end[$index];

                            $startBeforeButEndLater = $timer->timeStart < $start &&
                                $timer->end_time > $end[$index];
                            // En caso de que empiece o termina a la misma vez
                            if ($startBetween || $endBetween || $startBeforeButEndLater) {
                                $programId = $timer->programId;
                                $error = "El programa con id $programId, programId, tiene el mismo sector,y el temporizador que empieza a las $start[$index] coincide con el temporizador del otro programa que comienza $timer->timeStart. Por favor, seleccione uno distinto.";
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


            if (array_key_exists('id', $fields)) {
                //TODO: Update
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
                $response = [
                    'program' => $createdProgram,
                    'emitter' => $listCreatedEmitter,
                    'sector' => $listCreatedSector,
                    'timer' => $listCreatedTimer,
                ];
                return response($response, 201);
            }
        }


        // // Creamos la respuesta
        $response = [
            'head' => $head,
        ];

        return response("", 201);
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
        foreach ($listPrograms as $value) {
            // error_log(print_r($value, TRUE));
            $result = Timer::where('programId', $value->id)->get();

            if ($result) $timer[] = $result;

            $result = Sector::where('programId', $value->id)->pluck("digitalOutputId");


            $result = DigitalOutput::whereIn('id', $result)->get();
            if ($result) $sector[] = $result;
        }

        // Creamos la respuesta
        $response = [
            'count' => count($listPrograms),
            'listPrograms' => $listPrograms,
            'timer' => $timer,
            'sector' => $sector
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

        Sector::where('programId', $program->id)->delete();

        Emitter::where('programId', $program->id)->delete();

        Timer::where('programId', $program->id)->delete();


        $program->delete();

        return response("", 204);
    }
}
