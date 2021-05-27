<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Head;
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

        // Creamos el nuevo usuario
        $head = Head::where('userId', $request->user()->id)->get();

        if (!$head) {
            return response([
                'message' => 'Bad creds'
            ], 401);
        }

        // Creamos la respuesta
        $response = [
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

        if (!$head) {
            return response([
                'message' => 'Bad creds',
                'id' => $id,
                'userId' => $request->user()->id
            ], 401);
        }

        $head->name = $data['name'];

        $head->save();

        // Creamos la respuesta
        $response = [
            'head' => $head,
        ];

        return response($response, 200);
    }
}
