<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        if (!$user instanceof User) { 
            return response()->json(['message' => 'Usuario no autenticado'], 401);
        }

        // Se valida usando 'usuario' y 'email' de la tabla 'usuarios'
        $validatedData = $request->validate([
            'usuario' => 'string|max:255|unique:usuarios,usuario,' . $user->id_usuario,
            'email'   => 'string|email|max:255|unique:usuarios,email,' . $user->id_usuario,
        ]);

        User::where('id_usuario', $user->id_usuario)->update($validatedData);

        return response()->json(['message' => 'Perfil actualizado', 'user' => Auth::user()], 200);
    }

    public function deleteAccount()
    {
        $user = Auth::user();

        if (!$user instanceof User) { 
            return response()->json(['message' => 'Usuario no autenticado'], 401);
        }

        User::where('id_usuario', $user->id_usuario)->delete();

        return response()->json(['message' => 'Cuenta eliminada con éxito'], 200);
    }

    public function destroy($id)
{
    $admin = Auth::user();

    if (!$admin || $admin->rol !== 1) {
        return response()->json(['message' => 'No autorizado'], 403);
    }

    $user = User::where('id_usuario', $id)->first();

    if (!$user) {
        return response()->json(['message' => 'Usuario no encontrado'], 404);
    }

    $user->delete();

    return response()->json(['message' => 'Usuario eliminado correctamente'], 200);
}

public function update(Request $request, $id)
{
    $admin = Auth::user();

    if (!$admin || (int)$admin->rol !== 1) {
        return response()->json(['message' => 'No autorizado'], 403);
    }

    $user = User::find($id);

    if (!$user) {
        return response()->json(['message' => 'Usuario no encontrado'], 404);
    }

    $request->validate([
        'usuario' => 'sometimes|string|max:255',
        'email' => 'sometimes|email|max:255|unique:usuarios,email,' . $user->id_usuario . ',id_usuario',
        'password' => 'sometimes|string|min:6',
        'rol' => 'sometimes|integer|in:1,2',
    ]);

    if ($request->filled('usuario')) {
        $user->usuario = $request->usuario;
    }

    if ($request->filled('email')) {
        $user->email = $request->email;
    }

    if ($request->filled('password')) {
        $user->hashed_password = bcrypt($request->password);
    }

    if ($request->filled('rol')) {
        $user->rol = $request->rol;
    }

    $user->save();

    return response()->json(['message' => 'Usuario actualizado correctamente', 'user' => $user], 200);
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
        $user = User::where('usuario', $username)->first();

        if (!$user) {
            return response()->json(['message' => 'No se encuentra ese usuario en nuestra base de datos'], 404);
        }

        return response()->json($user);
    }

    public function index()
    {
        return response()->json(User::all());
    }

    public function cambiarContraseñaSinLogin(Request $request)
    {
        $request->validate([
            'usuario'           => 'required|string',
            'current_password'  => 'required|string',
            'new_password'      => 'required|string|min:6|confirmed',
        ]);

        $user = User::where('usuario', $request->usuario)->first();
        if (!$user) {
            return response()->json(['message' => 'Credenciales incorrectas'], 422);
        }

        if (!Hash::check($request->current_password, $user->hashed_password)) {
            return response()->json(['message' => 'Credenciales incorrectas'], 422);
        }

        $user->hashed_password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Contraseña actualizada con éxito'], 200);
    }

}