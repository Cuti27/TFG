<?php

namespace App\Http\Controllers\API;

use App\Http\ClientHTTP;
use App\Http\Controllers\Controller;
use App\Models\AgronicAccount;
use App\Models\AnalogicalInput;
use App\Models\AnalogicalOutput;
use App\Models\Device;
use App\Models\DigitalInput;
use App\Models\DigitalOutput;
use App\Models\Emitter;
use App\Models\waittingId;
use App\Models\Head;
use App\Models\History;
use App\Models\Sector;
use App\Models\TypeAnalogicalInput;
use App\Models\TypeAnalogicalOutput;
use App\Models\TypeDevice;
use App\Models\TypeDigitalInput;
use App\Models\TypeDigitalOutput;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Psr\Http\Message\ResponseInterface;

class DeviceController extends Controller
{

    /**
     * Display all analogicalInput
     * 
     * @return \Illuminate\Http\Response
     */
    public function getTypeDevice()
    {
        return TypeDevice::all();
    }
    /**
     * Validate and create a new Device
     * 
     * @return \Illuminate\Http\Response
     */
    public function createDevice(Request $request, $id)
    {
        if (!is_string($id) || $id == '') {
            return response([
                'message' => 'Need a valid id'
            ], 400);
        }

        error_log($request);

        // Recuperamos y validamos el formulario
        $fields = $request->validate([
            'id' => 'required|string',
            'type' => 'required',
            'agronicId' => 'string',
            'name' => 'required|string',
        ]);

        error_log($fields['id']);

        $waittingId = waittingId::where('id', $fields['id'])->where('userId', $request->user()->id)->first();

        // Check password
        if (!$waittingId) {
            return response([
                'message' => 'Bad id',
                'id' => $fields['id']
            ], 400);
        }

        error_log($waittingId);
        error_log($waittingId->id);

        $response = (new ClientHTTP)("GET", "/identificador", [
            'connect_timeout' => 90,
'http_errors' => false,
            'query' => [
                'id' => $waittingId->id,
            ]
        ]);

        if ($response->getStatusCode() != 200) {
            return response([
                'message' => 'Cant connect to device, check if connected',
                'id' => $fields['id']
            ], 400);
        }

        $head = Head::where("userId", $request->user()->id)->where('id', $id)->first();

        if (!$head) {
            return response([
                'message' => 'Bad id of the head'
            ], 400);
        }

        $type = TypeDevice::where("id", $fields['type'])->first();

        if (!$type) {
            return response([
                'message' => 'Bad type of device'
            ], 400);
        }

        error_log($fields['name']);

        if ($fields['type'] && $fields['type'] == 3) {
            $agronicAccount = AgronicAccount::where('id', $fields['agronicId']);

            if (!$agronicAccount) {
                return response([
                    'message' => 'Agronic type need a previus Agronic Account'
                ], 400);
            }

            $device = Device::create([
                'type' => $type->id,
                'id' => $waittingId->id,
                'userId' =>  $request->user()->id,
                'headId' => $head->id,
                'agronicId' => $agronicAccount->id,
                'name' => $fields['name']
            ]);
        } else {
            // Creamos el nuevo usuario
            $device = Device::create([
                'id' => $waittingId->id,
                'type' => $type->id,
                'userId' =>  $request->user()->id,
                'headId' => $head->id,
                'agronicId' => null,
                'name' => $fields['name']
            ]);
        }

        error_log("llega");

        $waittingId->delete();

        $head = Head::where("id", $device->headId)->first();

        $head->touch();

        History::create([
            'userId' => $request->user()->id,
            'description' => "Creación del dispositivo con id $device->id y nombre $device->name ($device->type) en el cabezal $head->name ($head->id)"
        ]);

        // Creamos la respuesta
        $response = [
            'device' => $device,
            'digitalInput' => [],
            'digitalOutput' => [],
            'analogicalOutput' => [],
            'analogicalInput' => [],
        ];

        error_log("llega");

        return response($response, 201);
    }

    /**listDeviceHead
     * List all device for an user
     * 
     * @return \Illuminate\Http\Response
     */
    public function listDevice(Request $request)
    {
        $listDevice = Device::where('userId', $request->user()->id)->get();

        // Creamos la respuesta
        $response = [
            'count' => count($listDevice),
            'listId' => $listDevice
        ];

        return response($response, 200);
    }

    /**
     * List all device for an user and a Head
     * 
     * @return \Illuminate\Http\Response
     */
    public function listDeviceHead(Request $request, $id)
    {
        if (!is_string($id) || $id == '') {
            return response([
                'message' => 'Need a valid id'
            ], 400);
        }
        $listDevice = Device::where('userId', $request->user()->id)->where('headId', $id)->get();

        // Creamos la respuesta
        $response = [
            'count' => count($listDevice),
            'listId' => $listDevice
        ];

        return response($response, 200);
    }

    /**
     * Create a new Id for device
     * 
     * @return \Illuminate\Http\Response
     */
    public function createIdDevice(Request $request)
    {

        $generatedId = Str::uuid()->toString();

        $listDevice = waittingId::where('userId', $request->user()->id)->get();

        if (count($listDevice) >= 10) {
            return response([
                'message' => 'Too much id waitting to be asigned',
                'list' => $listDevice
            ], 400);
        }

        error_log($generatedId);

        // Creamos el nuevo usuario
        $waittingId = waittingId::create([
            'id' => $generatedId,
            'userId' => $request->user()->id,
        ]);

        History::create([
            'userId' => $request->user()->id,
            'description' => "Creación del id en espera $generatedId"
        ]);

        // Creamos la respuesta
        $response = [
            'waittingId' => $waittingId,
            'count' => count($listDevice) + 1,
            'listId' => $listDevice
        ];

        return response($response, 201);
    }

    /**
     * Delete a Id for device
     * 
     * @return \Illuminate\Http\Response
     */
    public function deleteIdDevice(Request $request)
    {

        // Recuperamos y validamos el formulario
        $fields = $request->validate([
            'id' => 'required|string',
        ]);

        $idDevice = waittingId::where('userId', $request->user()->id)->where("id", $fields["id"])->first();

        if (!$idDevice) {
            return response([
                'message' => 'Error in Id'
            ], 400);
        }

        $response = [
            'waittingId' => $idDevice,
        ];

        $idDevice->delete();

        History::create([
            'userId' => $request->user()->id,
            'description' => "Eliminación del id en espera $idDevice"
        ]);

        return response($response, 200);
    }

    /**
     * List Id for device
     * 
     * @return \Illuminate\Http\Response
     */
    public function listIdDevice(Request $request)
    {

        $listDevice = waittingId::where('userId', $request->user()->id)->get();


        // Creamos la respuesta
        $response = [
            'waittingId' => $listDevice
        ];

        return response($response, 200);
    }

    /**
     * List Id for device
     * 
     * @return \Illuminate\Http\Response
     */
    public function getDevice(Request $request)
    {
        // Recuperamos y validamos el formulario
        $fields = $request->validate([
            'id' => 'required|string',
        ]);

        $device = Device::where('userId', $request->user()->id)->where('id', $fields["id"])->first();

        if (!$device) {
            return response([
                'message' => 'The id of the device is not valid'
            ], 400);
        }

        $digitalInput = DigitalInput::where('deviceId', $fields["id"])->get();
        $digitalOutput = DigitalOutput::where('deviceId', $fields["id"])->get();
        $analogicalInput = AnalogicalInput::where('deviceId', $fields["id"])->get();
        $analogicalOutput = AnalogicalOutput::where('deviceId', $fields["id"])->get();

        // Creamos la respuesta
        $response = [
            'device' => $device,
            'digitalInput' => $digitalInput,
            'digitalOutput' => $digitalOutput,
            'analogicalOutput' => $analogicalOutput,
            'analogicalInput' => $analogicalInput,
        ];

        return response($response, 200);
    }

    /**
     * Add DigitalOutput
     * 
     * @return \Illuminate\Http\Response
     */
    public function addDigitalOutput(Request $request, $id)
    {
        // Recuperamos y validamos el formulario
        $fields = $request->validate([
            'idDevice' => 'required|string',
            'listDigitalOutput' => 'present|array',
            'listDigitalOutput.*.type' => ['required', Rule::in(TypeDigitalOutput::pluck('id')->all())],
            'listDigitalOutput.*.deviceId' => 'required',
            'listDigitalOutput.*.output' => 'required',
            'listDigitalOutput.*.id' => 'numeric',
            'listDigitalOutput.*.description' => 'string|nullable',
            'listDigitalOutput.*.name' => 'string|required',
        ]);


        $device = Device::where("id", $fields['idDevice'])->where('userId', $request->user()->id)->where('headId', $id)->first();

        if (!$device) {
            return response([
                'message' => 'The id of the device is not valid'
            ], 400);
        }

        // TODO: hacer eliminación de objetos
        $output = [];
        foreach ($fields['listDigitalOutput'] as $valor) {
            error_log(print_r($valor, TRUE));
            $inputOutput = DigitalOutput::where('output', $valor["output"])->where('deviceId', $device->id)->first();
            if ($inputOutput) {
                error_log($valor["type"]);
                $inputOutput->type = $valor["type"];
                $inputOutput->output = $valor["output"];
                $inputOutput->description = array_key_exists("description", $valor) ? $valor["description"] : null;
                $inputOutput->name = $valor["name"];

                $inputOutput->save();

                array_push($output, $inputOutput->output);
            } else {
                $dev = DigitalOutput::create([
                    'type' => $valor["type"],
                    'deviceId' => $device->id,
                    'output' => $valor["output"],
                    'description' => array_key_exists("description", $valor) ? $valor["description"] : null,
                    'name' => $valor["name"],
                ]);
                array_push($output, $dev->output);
            }
        }

        // TODO: Eliminar el programa ya que debe ir enlazado al head, y el porgrama tiene que tener otra cosa que una sector/bomba y programa

        // $listDigitalOutput =  DigitalOutput::createMany(collect($fields['listDigitalOutput'])->map(function ($value) {
        //     return [
        //         'type' => $value->type,
        //         'deviceId' => $value->deviceId,
        //         'output' => $value->output,
        //     ];
        // }));

        $listDigitalOutput = DigitalOutput::where('deviceId', $fields["idDevice"])->get();

        if (count($output) != count($listDigitalOutput)) {
            foreach ($listDigitalOutput as $valor) {
                if ($valor->output > count($output)) {
                    error_log("Borramos");
                    error_log(print_r($valor, TRUE));
                    $valor->delete();
                }
            }
            $listDigitalOutput = DigitalOutput::where('deviceId', $fields["idDevice"])->get();
        }

        $head = Head::where("id", $device->headId)->first();

        $head->touch();

        History::create([
            'userId' => $request->user()->id,
            'description' => "Modificación de las salidas digitales del dispositivo '$device->name' en el cabezal $head->name ($head->id)"
        ]);

        $response = [
            'device' => $device,
            'listDigitalOutput' => $listDigitalOutput,
        ];

        return response($response, 200);
    }
    /**
     * Add DigitalInput
     * 
     * @return \Illuminate\Http\Response
     */
    public function addDigitalInput(Request $request, $id)
    {
        // Recuperamos y validamos el formulario
        $fields = $request->validate([
            'idDevice' => 'required|string',
            'listDigitalInput' => 'present|array',
            'listDigitalInput.*.type' => ['required', Rule::in(TypeDigitalInput::pluck('id')->all())],
            'listDigitalInput.*.deviceId' => 'required',
            'listDigitalInput.*.input' => 'required',
            'listDigitalInput.*.id' => 'numeric',
            'listDigitalInput.*.description' => 'string|nullable',
        ]);

        $device = Device::where("id", $fields['idDevice'])->where('userId', $request->user()->id)->where('headId', $id)->first();

        if (!$device) {
            return response([
                'message' => 'The id of the device is not valid'
            ], 400);
        }

        // $listDigitalInput = DigitalInput::createMany(collect($fields['listDigitalInput'])->map(function ($value) {
        //     return [
        //         'type' => $value->type,
        //         'deviceId' => $value->deviceId,
        //         'input' => $value->input
        //     ];
        // }));

        $input = [];
        foreach ($fields['listDigitalInput'] as $valor) {
            $inputOutput = DigitalInput::where('input', $valor["input"])->where('deviceId', $device->id)->first();
            if ($inputOutput) {

                $inputOutput->type = $valor["type"];
                $inputOutput->input = $valor["input"];
                $inputOutput->description = array_key_exists("description", $valor) ? $valor["description"] : null;

                $inputOutput->save();
                array_push($input, $inputOutput->input);
            } else {
                $dev = DigitalInput::create([
                    'type' => $valor["type"],
                    'deviceId' => $device->id,
                    'input' => $valor["input"],
                    'description' => array_key_exists("description", $valor) ? $valor["description"] : null,

                ]);
                array_push($input, $dev->input);
            }
        }

        $listDigitalInput = DigitalInput::where('deviceId', $fields["idDevice"])->get();

        if (count($input) != count($listDigitalInput)) {
            foreach ($listDigitalInput as $valor) {
                if ($valor->input > count($input)) {
                    error_log("Borramos");
                    error_log(print_r($valor, TRUE));
                    $valor->delete();
                }
            }
            $listDigitalInput = DigitalInput::where('deviceId', $fields["idDevice"])->get();
        }

        $head = Head::where("id", $device->headId)->first();

        $head->touch();

        History::create([
            'userId' => $request->user()->id,
            'description' => "Modificación de las entradas digitales del dispositivo '$device->name' en el cabezal $head->name ($head->id)"
        ]);

        $response = [
            'device' => $device,
            'listDigitalInput' => $listDigitalInput,
        ];

        return response($response, 200);
    }
    /**
     * Add AnalogicalInput
     * 
     * @return \Illuminate\Http\Response
     */
    public function addAnalogicalInput(Request $request, $id)
    {
        // Recuperamos y validamos el formulario
        $fields = $request->validate([
            'idDevice' => 'required|string',
            'listAnalogicalInput' => 'present|array',
            'listAnalogicalInput.*.type' => ['required', Rule::in(TypeAnalogicalInput::pluck('id')->all())],
            'listAnalogicalInput.*.deviceId' => 'required',
            'listAnalogicalInput.*.input' => 'required',
            'listAnalogicalInput.*.id' => 'numeric',
            'listAnalogicalInput.*.description' => 'string|nullable',
        ]);

        $device = Device::where("id", $fields['idDevice'])->where('userId', $request->user()->id)->where('headId', $id)->first();

        if (!$device) {
            return response([
                'message' => 'The id of the device is not valid'
            ], 400);
        }

        $input = [];
        foreach ($fields['listAnalogicalInput'] as $valor) {
            $inputOutput = AnalogicalInput::where('input', $valor["input"])->where('deviceId', $device->id)->first();
            if ($inputOutput) {

                $inputOutput->type = $valor["type"];
                $inputOutput->input = $valor["input"];
                $inputOutput->description = array_key_exists("description", $valor) ? $valor["description"] : null;

                $inputOutput->save();
                array_push($input, $inputOutput->input);
            } else {
                $dev = AnalogicalInput::create([
                    'type' => $valor["type"],
                    'deviceId' => $device->id,
                    'input' => $valor["input"],
                    'description' => array_key_exists("description", $valor) ? $valor["description"] : null,
                ]);
                array_push($input, $dev->input);
            }
        }

        $listAnalogicalInput = AnalogicalInput::where('deviceId', $fields["idDevice"])->get();

        error_log(count($input));
        error_log(count($listAnalogicalInput));


        if (count($input) != count($listAnalogicalInput)) {
            foreach ($listAnalogicalInput as $valor) {
                error_log($valor->input);
                if ($valor->input > count($input)) {
                    error_log("Borramos");
                    error_log(print_r($valor, TRUE));
                    $valor->delete();
                }
            }
            $listAnalogicalInput = AnalogicalInput::where('deviceId', $fields["idDevice"])->get();
        }

        $head = Head::where("id", $device->headId)->first();

        $head->touch();

        History::create([
            'userId' => $request->user()->id,
            'description' => "Modificación de las salidas analógicas del dispositivo '$device->name' en el cabezal $head->name ($head->id)"
        ]);

        $response = [
            'device' => $device,
            'listAnalogicalInput' => $listAnalogicalInput,
        ];

        return response($response, 200);
    }

    /**
     * Add AnalogicalOutput
     * 
     * @return \Illuminate\Http\Response
     */
    public function addAnalogicalOutput(Request $request, $id)
    {
        // Recuperamos y validamos el formulario

        $fields = $request->validate([
            'idDevice' => 'required|string',
            'listAnalogicalOutput' =>
            'present|array',
            'listAnalogicalOutput.*.type' => ['required', Rule::in(TypeAnalogicalOutput::pluck('id')->all())],
            'listAnalogicalOutput.*.deviceId' => 'required',
            'listAnalogicalOutput.*.output' => 'required',
            'listAnalogicalOutput.*.id' => 'numeric',
            'listAnalogicalOutput.*.description' => 'string|nullable',
        ]);

        $device = Device::where("id", $fields['idDevice'])->where('userId', $request->user()->id)->where('headId', $id)->first();

        if (!$device) {
            return response([
                'message' => 'The id of the device is not valid'
            ], 400);
        }

        // TODO: mirar bien como hacer esta comprobación



        // $listAnalogicalOutput =  AnalogicalOutput::createMany(collect($fields['listAnalogicalInput'])->map(function ($value) {
        //     return [
        //         'type' => $value->type,
        //         'deviceId' => $value->deviceId,
        //         'input' => $value->input
        //     ];
        // }));

        $output = [];
        foreach ($fields['listAnalogicalOutput'] as $valor) {
            $inputOutput = AnalogicalOutput::where('output', $valor["output"])->where('deviceId', $device->id)->first();
            if ($inputOutput) {
                $inputOutput->type = $valor["type"];
                $inputOutput->output = $valor["output"];
                $inputOutput->description = array_key_exists("description", $valor) ? $valor["description"] : null;

                $inputOutput->save();
                array_push($output, $inputOutput->output);
            } else {
                $dev = AnalogicalOutput::create([
                    'type' => $valor["type"],
                    'deviceId' => $device->id,
                    'output' => $valor["output"],
                    'description' => array_key_exists("description", $valor) ? $valor["description"] : null,
                ]);
                array_push($output, $dev->output);
            }
        }

        $listAnalogicalOutput = AnalogicalOutput::where('deviceId', $fields["idDevice"])->get();

        if (count($output) != count($listAnalogicalOutput)) {
            foreach ($listAnalogicalOutput as $valor) {
                if ($valor->output > count($output)) {
                    error_log("Borramos");
                    error_log(print_r($valor, TRUE));
                    $valor->delete();
                }
            }
            $listAnalogicalOutput = AnalogicalOutput::where('deviceId', $fields["idDevice"])->get();
        }

        $head = Head::where("id", $device->headId)->first();

        $head->touch();

        History::create([
            'userId' => $request->user()->id,
            'description' => "Modificación de las entradas analógicas del dispositivo '$device->name' en el cabezal $head->name ($head->id)"
        ]);

        // Creamos la respuesta
        $response = [
            'device' => $device,
            'listAnalogicalOutput' => $listAnalogicalOutput,
        ];

        return response($response, 200);
    }

    /**
     * List Emitter of user to a Head
     * 
     * @return \Illuminate\Http\Response
     */
    public function getEmitterOfUser(Request $request, $id)
    {
        // Creamos el nuevo usuario
        $head = Head::where('userId', $request->user()->id)->where('id', $id)->first();

        if (!$head) {
            return response([
                'message' => 'Bad creds'
            ], 400);
        }

        $listDevice = Device::where('userId', $request->user()->id)->where('headId', $id)->pluck('id');

        if (!$listDevice) {
            return response([
                'message' => 'Bad creds'
            ], 400);
        }

        // Recuperamos emitter
        $emitterType = TypeDigitalOutput::where('type', 'Bomba')->first();

        if (!$emitterType) {
            return response([
                'message' => 'Error in BD'
            ], 500);
        }

        $listEmitter = DigitalOutput::where('type', $emitterType->id)->whereIn('deviceId', $listDevice)->get();

        $toRespond = [];
        foreach ($listEmitter as $valor) {
            $device = Device::where('id', $valor->deviceId)->first();
            array_push($toRespond, [
                'device' => $device,
                'output' => $valor,
            ]);
        }

        // Creamos la respuesta
        $response = [
            'emitterList' => $toRespond,
        ];

        return response($response, 200);
    }

    /**
     * List Sectors of user to a Head
     * 
     * @return \Illuminate\Http\Response
     */
    public function getSectorsOfUser(Request $request, $id)
    {
        // Creamos el nuevo usuario
        $head = Head::where('userId', $request->user()->id)->where('id', $id)->first();

        if (!$head) {
            return response([
                'message' => 'Bad creds'
            ], 400);
        }

        $listDevice = Device::where('userId', $request->user()->id)->where('headId', $id)->pluck('id');

        if (!$listDevice) {
            return response([
                'message' => 'Bad creds'
            ], 400);
        }

        // Recuperamos emitter
        $sectorType = TypeDigitalOutput::where('type', 'Sector')->first();

        if (!$sectorType) {
            return response([
                'message' => 'Error in DB'
            ], 500);
        }

        $sectorlist = DigitalOutput::where('type', $sectorType->id)->whereIn('deviceId', $listDevice)->get();

        $toRespond = [];
        foreach ($sectorlist as $valor) {
            $device = Device::where('id', $valor->deviceId)->first();
            array_push($toRespond, [
                'device' => $device,
                'output' => $valor,
            ]);
        }

        // Creamos la respuesta
        $response = [
            'sectorList' => $toRespond,
        ];

        return response($response, 200);
    }

    /**
     * Delete a device
     * 
     * @return \Illuminate\Http\Response
     */
    public function deleteDevice(Request $request, $id)
    {
        $device = Device::where('userId', $request->user()->id)->where('id', $id)->first();

        if (!$device) {
            return response([
                'message' => 'Bad id'
            ], 400);
        }

        // AnalogicalInput::where()

        $sectors = Sector::where("digitalOutputId", $device->id)->get();
        $emitters = Emitter::where("digitalOutputId", $device->id)->get();

        if ($sectors || $emitters) {
            $response = [
                'message' => 'Had sector or emitter in programs, remove it before',
                'sectors' => $sectors,
                'emitters' => $emitters,
            ];

            response($response, 400);
        }

        $device->delete();

        $head = Head::where("id", $device->headId)->first();

        $head->touch();

        History::create([
            'userId' => $request->user()->id,
            'description' => "Eliminación del dispositivos '$device->name', y sus salidas y entradas, presentes en el cabezal $head->name ($head->id)"
        ]);

        // Creamos la respuesta
        $response = [
            'device' => $device,
        ];

        return response($response, 204);
    }
}
