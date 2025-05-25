<?php

namespace App\Http\Controllers;

use App\Models\HistorialSesion;
use App\Http\Resources\HistorialResource;
use Illuminate\Http\Request;

class HistorialController extends Controller
{
    /**
     * Muestra un listado del historial de sesiones.
     */
    public function index()
    {
        // Carga el historial de sesiones con la relación del usuario
        return HistorialResource::collection(
            HistorialSesion::with('usuario')->paginate(10)
        );
    }

    /**
     * Muestra un registro específico del historial.
     */
    public function show($id)
    {
        // Busca el historial con la relación del usuario o lanza un error 404
        $historial = HistorialSesion::with('usuario')->findOrFail($id);
        return new HistorialResource($historial);
    }

    /**
     * Almacena un nuevo registro en el historial de sesiones.
     */
    public function store(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'Id_usuario' => 'required|exists:usuarios,Id_usuario',
            'Fecha_de_sesion' => 'nullable|date',
        ]);

        // Crear un nuevo registro en el historial
        $historial = HistorialSesion::create($request->all());

        return new HistorialResource($historial);
    }

    /**
     * Actualiza un registro específico del historial.
     */
    public function update(Request $request, $id)
    {
        // Validar los datos recibidos
        $request->validate([
            'Id_usuario' => 'required|exists:usuarios,Id_usuario',
            'Fecha_de_sesion' => 'nullable|date',
        ]);

        // Buscar el registro y actualizarlo
        $historial = HistorialSesion::findOrFail($id);
        $historial->update($request->all());

        return new HistorialResource($historial);
    }

    /**
     * Elimina un registro del historial de sesiones.
     */
    public function destroy($id)
    {
        // Eliminar el historial
        $historial = HistorialSesion::findOrFail($id);
        $historial->delete();

        return response()->json(['message' => 'Historial de sesión eliminado con éxito.']);
    }
}
