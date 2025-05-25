<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Http\Resources\RolResource;
use Illuminate\Http\Request;

class RolController extends Controller
{
    /**
     * Muestra un listado de los roles.
     */
    public function index()
    {
        // Devuelve todos los roles paginados
        return RolResource::collection(Rol::paginate(10));
    }

    /**
     * Muestra un rol específico.
     */
    public function show($id)
    {
        // Encuentra un rol por su ID o lanza un error 404
        $rol = Rol::findOrFail($id);
        return new RolResource($rol);
    }

    /**
     * Almacena un nuevo rol.
     */
    public function store(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'Nombre' => 'required|string|max:255|unique:roles,Nombre',
        ]);

        // Crear el rol
        $rol = Rol::create($request->all());

        return new RolResource($rol);
    }

    /**
     * Actualiza un rol existente.
     */
    public function update(Request $request, $id)
    {
        // Validar los datos recibidos
        $request->validate([
            'Nombre' => 'required|string|max:255|unique:roles,Nombre,' . $id . ',Id_rol',
        ]);

        // Buscar y actualizar el rol
        $rol = Rol::findOrFail($id);
        $rol->update($request->all());

        return new RolResource($rol);
    }

    /**
     * Elimina un rol.
     */
    public function destroy($id)
    {
        // Buscar y eliminar el rol
        $rol = Rol::findOrFail($id);
        $rol->delete();

        return response()->json(['message' => 'Rol eliminado con éxito.']);
    }
}
