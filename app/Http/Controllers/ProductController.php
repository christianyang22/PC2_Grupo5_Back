<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\HistorialSesion;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json(Product::all());
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return new ProductResource($product);
    }

    public function getOffers()
    {
        return response()->json(Product::whereNotNull('oferta')->get());
    }

    
    public function bestRated()
    {
        return response()->json(Product::orderBy('valoracion', 'desc')->take(10)->get());
    }

    public function getProductsWithNutrition()
    {
        return response()->json(Product::whereNotNull('grasas')
            ->whereNotNull('azucar')
            ->whereNotNull('proteina')
            ->get());
    }

    public function getProductRatings()
    {
        return response()->json(Product::select('nombre', 'valoracion')
            ->orderBy('valoracion', 'desc')
            ->get());
    }

    public function getUserSearchHistory()
    {
        return response()->json(HistorialSesion::where('Id_usuario', Auth::id())->get());
    }

    public function getBestWorstRatedProducts()
    {
        $best = Product::orderBy('valoracion', 'desc')->first();
        $worst = Product::orderBy('valoracion', 'asc')->first();

        return response()->json([
            'best' => $best,
            'worst' => $worst
        ]);
    }

    public function getAvailableSupermarkets()
    {
        return response()->json(Product::distinct()->pluck('supermercado'));
    }

    public function filterBySupermarket($supermarket)
    {
        return response()->json(Product::where('supermercado', $supermarket)->get());
    }

    public function filterByPrice($min, $max)
    {
        return response()->json(Product::whereBetween('precio', [$min, $max])->get());
    }

    public function filterByNutrition(Request $request)
    {
        $query = Product::query();

        if ($request->has('grasas')) {
            $query->where('grasas', '<=', $request->grasas);
        }
        if ($request->has('azucar')) {
            $query->where('azucar', '<=', $request->azucar);
        }
        if ($request->has('proteina')) {
            $query->where('proteina', '>=', $request->proteina);
        }

        return response()->json($query->get());
    }
}





