<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AgronicAccount;
use App\Models\AnalogicalInput;
use App\Models\AnalogicalOutput;
use App\Models\Device;
use App\Models\DigitalInput;
use App\Models\DigitalOutput;
use App\Models\waittingId;
use App\Models\Head;
use App\Models\TypeAnalogicalInput;
use App\Models\TypeDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DeviceController extends Controller
{
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
            ], 401);
        }

        // Recuperamos y validamos el formulario
        $fields = $request->validate([
            'id' => 'required|string',
            'type' => 'required|string',
            'agronicId' => 'string',
        ]);

        error_log($fields['id']);

        $waittingId = waittingId::where('id', $fields['id'])->where('userId', $request->user()->id)->first();

        // Check password
        if (!$waittingId) {
            return response([
                'message' => 'Bad id',
                'id' => $fields['id']
            ], 401);
        }

        error_log($waittingId);
        error_log($waittingId->id);

        $head = Head::where("userId", $request->user()->id)->where('id', $id)->first();

        if (!$head) {
            return response([
                'message' => 'Bad id of the head'
            ], 401);
        }

        $type = TypeDevice::where("id", $fields['type'])->first();

        if (!$type) {
            return response([
                'message' => 'Bad type of device'
            ], 401);
        }

        error_log("llega");

        if ($fields['type'] && $fields['type'] == 3) {
            $agronicAccount = AgronicAccount::where('id', $fields['agronicId']);

            if (!$agronicAccount) {
                return response([
                    'message' => 'Agronic type need a previus Agronic Account'
                ], 401);
            }

            $device = Device::create([
                'type' => $type->id,
                'id' => $waittingId->id,
                'userId' =>  $request->user()->id,
                'headId' => $head->id,
                'agronicId' => $agronicAccount->id
            ]);
        } else {
            // Creamos el nuevo usuario
            $device = Device::create([
                'id' => $waittingId->id,
                'type' => $type->id,
                'userId' =>  $request->user()->id,
                'headId' => $head->id,
                'agronicId' => null
            ]);
        }

        error_log("llega");

        $waittingId->delete();


        // Creamos la respuesta
        $response = [
            'device' => $device,
        ];

        error_log("llega");

        return response($response, 201);
    }

    /**
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
                'message' => 'Too much id wait to be asigned',
                'list' => $listDevice
            ], 401);
        }

        // Creamos el nuevo usuario
        $waittingId = waittingId::create([
            'id' => $generatedId,
            'userId' => $request->user()->id,
        ]);

        // Creamos la respuesta
        $response = [
            'waittingId' => $waittingId,
            'count' => count($listDevice),
            'listId' => $listDevice
        ];

        return response($response, 201);
    }

    /**
     * List Id for device
     * 
     * @return \Illuminate\Http\Response
     */
    public function listIdDevice(Request $request)
    {

        $listDevice = waittingId::where('userId', $request->user()->id)->get();
        // Creamos el nuevo usuario
        $waittingId = waittingId::create([
            'list' => $listDevice,
        ]);

        // Creamos la respuesta
        $response = [
            'waittingId' => $waittingId
        ];

        return response($response, 200);
    }

    /**
     * List Id for device
     * 
     * @return \Illuminate\Http\Response
     */
    public function addInputOutput(Request $request)
    {
        // Recuperamos y validamos el formulario

        $fields = Validator::make($request->all(), [
            'idDevice' => 'required|string',
            'listAnalogicalOutput' => 'required',
            'listAnalogicalOutput.type' => 'required',
            'listAnalogicalOutput.deviceId' => 'required',
            'listAnalogicalOutput.output' => 'required',
            'listAnalogicalInput' => 'required',
            'listAnalogicalInput.type' => 'required',
            'listAnalogicalInput.deviceId' => 'required',
            'listAnalogicalInput.input' => 'required',
            'listDigitalOutput' => 'required',
            'listDigitalOutput.type' => 'required',
            'listDigitalOutput.deviceId' => 'required',
            'listDigitalOutput.output' => 'required',
            'listDigitalOutput.programId' => 'string',
            'listDigitalInput' => 'required',
            'listDigitalInput.type' => 'required',
            'listDigitalInput.deviceId' => 'required',
            'listDigitalInput.input' => 'required',
        ]);

        $device = Device::where("id", $fields['idDevice'])->where('userId', $request->user()->id)->first();

        if (!$device) {
            return response([
                'message' => 'The id of the device is not valid'
            ], 401);
        }

        // TODO: mirar bien como hacer esta comprobación

        $listAnalogicalInput = AnalogicalInput::createMany(collect($fields['listAnalogicalOutput'])->map(function ($value) {

            $type = TypeAnalogicalInput::where('id', $value->type)->first();

            return [
                'type' => $value->type,
                'deviceId' => $value->deviceId,
                'output' => $value->output
            ];
        }));

        $listAnalogicalOutput =  AnalogicalOutput::createMany(collect($fields['listAnalogicalInput'])->map(function ($value) {
            return [
                'type' => $value->type,
                'deviceId' => $value->deviceId,
                'input' => $value->input
            ];
        }));

        $listDigitalOutput =  DigitalOutput::createMany(collect($fields['listDigitalOutput'])->map(function ($value) {
            return [
                'type' => $value->type,
                'deviceId' => $value->deviceId,
                'output' => $value->output,
                'programId' => $value->programId ? $value->programId : null,
            ];
        }));

        $listDigitalInput = DigitalInput::createMany(collect($fields['listDigitalInput'])->map(function ($value) {
            return [
                'type' => $value->type,
                'deviceId' => $value->deviceId,
                'input' => $value->input
            ];
        }));

        // Creamos la respuesta
        $response = [
            'device' => $device,
            'listAnalogicalInput' => $listAnalogicalInput,
            'listAnalogicalOutput' => $listAnalogicalOutput,
            'listDigitalOutput' => $listDigitalOutput,
            'listDigitalInput' => $listDigitalInput
        ];

        return response($response, 200);
    }
}
