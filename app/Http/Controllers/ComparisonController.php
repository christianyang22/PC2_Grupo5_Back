<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ComparisonController extends Controller
{
    public function compareSupermarkets($product_id)
    {
        return response()->json(Product::where('id', $product_id)->get());
    }

    public function getRecommendations()
    {
        // Implementación futura
        return response()->json([]);
    }

    public function compareNutrients(Request $request)
    {
        return response()->json(Product::whereIn('id', $request->input('products'))->get());
    }
}