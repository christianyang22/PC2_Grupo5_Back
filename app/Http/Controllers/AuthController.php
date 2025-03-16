<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
            'usuario'         => $validatedData['usuario'],
            'email'           => $validatedData['email'],
            'hashed_password' => Hash::make($validatedData['password']),
            'rol'             => $validatedData['rol'],
            'nombre'          => $validatedData['nombre'],
            'apellido'        => $validatedData['apellido'],
            'fecha_nacimiento'=> $validatedData['fecha_nacimiento'] ?? null,
        ]);

        return response()->json(['message' => 'Usuario registrado con éxito'], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'usuario'  => 'required|string',
            'password' => 'required|string'
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        $user = Auth::user();

        return response()->json(['message' => 'Inicio de sesión exitoso', 'user' => $user]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Sesión cerrada'], 200);
    }

    public function me()
    {
        return response()->json(Auth::user());
    }
}