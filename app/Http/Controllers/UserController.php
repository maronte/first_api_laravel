<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    //Post Insertar datos
    public function store(Request $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        User::create($input);
        return response()->json([
            'res' => true,
            'message' => 'Usuario registrado correctamente'
        ],200);
    }

    public function login(Request $request)
    {
        $user = User::whereEmail($request->email)->first();
        if ( !(is_null($user)) && Hash::check($request->password, $user->password) ){
            //$user->api_token = Str::random(100);
            //$user->save();
            $token = $user->createToken('contactos')->accessToken;
            return response([
                'res' => true,
                'message' => 'Bienvenido al sistema',
                'token' => $token
            ], 200);
        } else{
            return response([
               'res' => true,
               'message' => 'Usuario o contraseña incorrectos'
            ], 200);
        }
    }

    public function logout()
    {
        $user = auth()->user();
        $user->tokens->each(function ($token){
            $token->delete();
        });
        return response([
        'res' => true,
        'message' => 'Adios'
    ], 200);
    }

}
