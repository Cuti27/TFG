<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Head;
use App\Models\History;
use Illuminate\Http\Request;

class HeadController extends Controller
{
    /**
     * Validate a Head
     * 
     * @return \Illuminate\Http\Response
     */
    public function createHead(Request $request)
    {
        // Recuperamos y validamos el formulario
        $fields = $request->validate([
            'name' => 'required|string',
        ]);

        // Creamos el nuevo usuario
        $head = Head::create([
            'name' => $fields['name'],
            'userId' =>  $request->user()->id,
        ]);


        History::create([
            'userId' => $request->user()->id,
            'description' => "Creación del cabbezal $head->name ($head->id)"
        ]);

        // Creamos la respuesta
        $response = [
            'head' => $head,
        ];

        return response($response, 201);
    }

    /**
     * Get a Head
     * 
     * @return \Illuminate\Http\Response
     */
    public function getHead(Request $request, $id)
    {
        if (!is_string($id) || $id == '') {
            return response([
                'message' => 'Need a valid id'
            ], 401);
        }

        // Creamos el nuevo usuario
        $head = Head::where('id', $id)->first();

        if (!$head) {
            return response([
                'message' => 'Bad creds'
            ], 401);
        }

        // Creamos la respuesta
        $response = [
            'head' => $head,
        ];

        return response($response, 200);
    }

    /**
     * Get Head List of a User
     * 
     * @return \Illuminate\Http\Response
     */
    public function getHeadByUser(Request $request)
    {

        // CRecuperamos el cabezal
        $head = Head::where('userId', $request->user()->id)->paginate(15);

        if (!$head) {
            return response([
                'message' => 'Bad creds'
            ], 401);
        }

        // Creamos la respuesta
        $response = [
            'count' => count($head),
            'headList' => $head,
        ];

        return response($response, 200);
    }

    /**
     * Update a Head
     * 
     * @return \Illuminate\Http\Response
     */
    public function updateHead(Request $request, $id)
    {
        if (!is_string($id) || $id == '') {
            return response([
                'message' => 'Need a valid id'
            ], 401);
        }

        $data = request()->validate([
            'name' => 'required|string',
        ]);


        // Creamos el nuevo usuario
        $head = Head::where('id', $id)->where('userId', $request->user()->id)->first();

        $originalName = $head->name;

        if (!$head) {
            return response([
                'message' => 'Bad creds',
                'id' => $id,
                'userId' => $request->user()->id
            ], 401);
        }

        $head->name = $data['name'];

        $head->save();

        History::create([
            'userId' => $request->user()->id,
            'description' => "Modificado el nombre del cabezal '$originalName' a $head->name ($head->id)"
        ]);

        // Creamos la respuesta
        $response = [
            'head' => $head,
        ];

        return response($response, 200);
    }


    /**
     * Delete a Head
     * 
     * @return \Illuminate\Http\Response
     */
    public function deleteHead(Request $request, $id)
    {
        if (!is_string($id) || $id == '') {
            return response([
                'message' => 'Need a valid id'
            ], 401);
        }

        // Creamos el nuevo usuario
        $head = Head::where('id', $id)->where('userId', $request->user()->id)->first();

        if (!$head) {
            return response([
                'message' => 'Bad creds',
                'id' => $id,
                'userId' => $request->user()->id
            ], 401);
        }


        $head->delete();


        History::create([
            'userId' => $request->user()->id,
            'description' => "Eliminación del cabezal $head->name ($head->id)"
        ]);

        // Creamos la respuesta
        $response = [
            'head' => $head,
        ];

        return response($response, 204);
    }
}
