<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favourite;
use Illuminate\Support\Facades\Auth;

class FavouriteController extends Controller
{
    public function addToFavourites(Request $request)
    {
        $fav = Favourite::create($request->all());
        return response()->json(['message' => 'Producto agregado a favoritos', 'favourite' => $fav]);
    }

    public function listFavourites()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Usuario no autenticado'], 401);
        }

        return response()->json($user->favourites);
    }

    public function removeFavourite($id)
    {
        Favourite::findOrFail($id)->delete();
        return response()->json(['message' => 'Producto eliminado de favoritos']);
    }
}