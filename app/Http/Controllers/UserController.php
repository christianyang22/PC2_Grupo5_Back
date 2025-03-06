<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        if (!$user instanceof User) { // Verificar que el usuario es válido
            return response()->json(['message' => 'Usuario no autenticado'], 401);
        }

        $validatedData = $request->validate([
            'username' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users,email,' . $user->id,
        ]);

        User::where('id', $user->id)->update($validatedData); // Cambio aquí para evitar error

        return response()->json(['message' => 'Perfil actualizado', 'user' => Auth::user()], 200);
    }

    public function deleteAccount()
    {
        $user = Auth::user();

        if (!$user instanceof User) { // Verificar que el usuario es válido
            return response()->json(['message' => 'Usuario no autenticado'], 401);
        }

        User::where('id', $user->id)->delete(); // Cambio aquí para evitar error

        return response()->json(['message' => 'Cuenta eliminada con éxito'], 200);
    }

    public function listUsers()
    {
        return response()->json(User::all());
    }

    public function findByEmail($email)
    {
        return response()->json(User::where('email', $email)->first());
    }

    public function getUserById($id)
    {
    $user = User::find($id);

    if (!$user) {
        return response()->json(['message' => 'Usuario no encontrado'], 404);
    }

    return response()->json($user);
    }

    public function getUsers()
    {
    return response()->json(User::all());
    }

    public function searchByEmail($email)
    {
    $user = User::where('email', $email)->first();

    if (!$user) {
        return response()->json(['message' => 'No se encuentra ese usuario en nuestra base de datos'], 404);
    }

    return response()->json($user);
    }

    public function searchByUsername($username)
    {
    $user = User::where('username', $username)->first();

    if (!$user) {
        return response()->json(['message' => 'No se encuentra ese usuario en nuestra base de datos'], 404);
    }

    return response()->json($user);
    }


}