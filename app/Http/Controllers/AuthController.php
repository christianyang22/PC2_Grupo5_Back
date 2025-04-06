<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'usuario'           => 'required|string|unique:usuarios,usuario',
            'email'             => 'required|string|email|unique:usuarios,email',
            'password'          => 'required|string|min:6',
            'rol'               => 'required|integer',
            'nombre'            => 'required|string',
            'apellido'          => 'required|string',
            'fecha_nacimiento'  => 'required|date'
        ]);

        $user = User::create([
            'usuario'          => $validatedData['usuario'],
            'email'            => $validatedData['email'],
            'hashed_password'  => Hash::make($validatedData['password']),
            'rol'              => $validatedData['rol'],
            'nombre'           => $validatedData['nombre'],
            'apellido'         => $validatedData['apellido'],
            'fecha_nacimiento' => $validatedData['fecha_nacimiento'],
            'fecha_creacion'   => now()
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'Usuario registrado con éxito',
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'usuario'  => 'required|string',
            'password' => 'required|string'
        ]);

        $token = JWTAuth::attempt([
            'usuario' => $credentials['usuario'],
            'password' => $credentials['password']
        ]);

        if (!$token) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        $user = JWTAuth::user();

        return response()->json([
            'message' => 'Inicio de sesión exitoso',
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(['message' => 'Sesión cerrada']);
        } catch (JWTException $e) {
            return response()->json(['error' => 'No se pudo cerrar sesión'], 500);
        }
    }

    public function me()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            return response()->json($user);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token inválido o expirado'], 401);
        }
    }
}
