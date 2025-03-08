<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\ComparisonController;

//Debo revisar si falta por crear alguna función en los controladores, pruebaaaa

Route::get('/test', function () {
    return response()->json(['message' => 'API funcionando']);
});


// Definimos las rutas de la API con apiResource
Route::apiResource('users', UserController::class);


// Route::apiResource('products', ProductController::class);
Route::get('/products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);

//Endpoints sobre los productos
Route::get('/products/filter/supermarket/{supermarket}', [ProductController::class, 'filterBySupermarket']);
Route::get('/products/filter/price/{min}/{max}', [ProductController::class, 'filterByPrice']);
Route::get('/products/filter/nutrition', [ProductController::class, 'filterByNutrition']);
Route::get('/products/offers', [ProductController::class, 'getOffers']);
Route::get('/products/nutrition-values', [ProductController::class, 'getProductsWithNutrition']);
Route::get('/products/ratings', [ProductController::class, 'getProductRatings']);
Route::get('/products/history', [ProductController::class, 'getUserSearchHistory']);
Route::get('/products/best-worst', [ProductController::class, 'getBestWorstRatedProducts']);
Route::get('/supermarkets', [ProductController::class, 'getAvailableSupermarkets']);


Route::apiResource('favourites', FavouriteController::class);

// Rutas de autenticación
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/user', [AuthController::class, 'me']);
Route::post('/logout', [AuthController::class, 'logout']);

// Rutas para Usuarios
Route::put('/update-profile', [UserController::class, 'updateProfile']);
Route::delete('/delete-account', [UserController::class, 'deleteAccount']);
Route::get('/users', [UserController::class, 'getUsers']);
Route::get('/users/search/{email}', [UserController::class, 'searchByEmail']);
Route::get('/users/{id}', [UserController::class, 'getUserById']);
Route::get('/users/search/username/{username}', [UserController::class, 'searchByUsername']);
    


// Rutas para Favoritos
Route::post('/favourites/add', [FavouriteController::class, 'addToFavourites']);
Route::get('/favourites/list', [FavouriteController::class, 'listFavourites']);
Route::delete('/favourites/remove/{id}', [FavouriteController::class, 'removeFavourite']);
Route::put('/favourites/update/{id}', [FavouriteController::class, 'updateFavouriteQuantity']);

// Rutas para Comparaciones y Recomendaciones
Route::get('/compare/{product_id}', [ComparisonController::class, 'compareSupermarkets']);
Route::post('/compare-nutrients', [ComparisonController::class, 'compareNutrients']);
Route::get('/recommendations', [ComparisonController::class, 'getRecommendations']);