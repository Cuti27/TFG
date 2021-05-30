<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    /**
     * Validate a Head
     * 
     * @return \Illuminate\Http\Response
     */
    public function createProgram(Request $request)
    {
        // Recuperamos y validamos el formulario
        $fields = $request->validate([
            'userId' => 'required',
            'headId' => 'required',
            'mon' => 'required | boolean',
            'tue' => 'required | boolean',
            'wed' => 'required | boolean',
            'thu' => 'required | boolean',
            'fri' => 'required | boolean',
            'sat' => 'required | boolean',
            'sun' => 'required | boolean',
        ]);

        // // Creamos el nuevo usuario
        // $head = Head::create([
        //     'name' => $fields['name'],
        //     'userId' =>  $request->user()->id,
        // ]);

        // // Creamos la respuesta
        // $response = [
        //     'head' => $head,
        // ];

        return response($response, 201);
    }
}
