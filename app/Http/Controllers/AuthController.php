<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    // se registra el usuario que se desea ingresar al sistema
    public function register(Request $request)
    {
        // input validation
        // nama, email & password
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:5'
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        return $user;
    }
    public function login(Request $request)
    {
        //input validation
        $validatedData = $request->validate([
            'email' => 'required|email|string',
            'password' => 'required|string|min:5'
        ]);

        if(!$token = auth('api')->attempt([
            'email' => $validatedData['email'], 
            'password' => $validatedData['password']])){
            return response()->json([
                'message' => 'Usuario no existe'
            ],401);
        }
        return $this->respondWithToken($token);
    }
    public function logout(Request $request)
    {        
        auth('api')->logout();

        return response()->json([
            'message' => 'Ha cerrado la sesion satisfactoriamente']);
    }  
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth('api')->factory()->getTTL() * 60 * 24
        ]);
    }
    public function me()
    {
        return response()->json(auth()->user());
    }
    
}
