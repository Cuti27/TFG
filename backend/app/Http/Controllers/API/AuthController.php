<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\History;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Validate a register, and do it
     * 
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        // Recuperamos y validamos el formulario
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
            'phone' => 'required|string',
        ]);

        // Creamos el nuevo usuario
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'phone' => $fields['phone'],
            'password' => bcrypt($fields['password'])
        ]);

        //  Creamos el token
        $token = $user->createToken('myapptoken')->plainTextToken;


        History::create([
            'userId' => $user->id,
            'description' => "Registro del usuario $user->name con correo '$user->email'"
        ]);

        // Creamos la respuesta
        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();

        // Check password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad creds'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        History::create([
            'userId' => $user->id,
            'description' => "Login del usuario $user->name con correo '$user->email'"
        ]);

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }

    public function userInfo(Request $request)
    {
        return $request->user();
    }

    public function historyInfo(Request $request)
    {
        return response(History::where("userId", $request->user()->id)->orderBy('id', 'desc')->get(), 200);
    }
}
