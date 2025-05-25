<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favourite;
use Illuminate\Support\Facades\Auth;

class FavouriteController extends Controller
{
    public function addToFavourites(Request $request)
    {
        $request->validate([
            'id_producto' => 'required|exists:productos,id_producto'
        ]);

        $id_usuario = Auth::user()->id_usuario;

        $fav = Favourite::firstOrCreate([
            'id_usuario' => $id_usuario,
            'id_producto' => $request->id_producto
        ]);

        return response()->json([
            'message' => 'Producto agregado a favoritos',
            'favourite' => $fav
        ]);
    }

    public function listFavourites()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Usuario no autenticado'], 401);
        }

        $favs = Favourite::with('product')
            ->where('id_usuario', $user->id_usuario)
            ->get();

        return response()->json($favs);
    }

    public function removeFavourite($id)
    {
        $favourite = Favourite::where('id_favorito', $id)
            ->where('id_usuario', Auth::user()->id_usuario)
            ->first();

        if (!$favourite) {
            return response()->json(['message' => 'Favorito no encontrado o no pertenece al usuario'], 404);
        }

        $favourite->delete();

        return response()->json(['message' => 'Producto eliminado de favoritos']);
    }
}