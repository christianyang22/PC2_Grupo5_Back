<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\ComparisonController;
use Tymon\JWTAuth\Facades\JWTAuth;


Route::get('/products/filter/supermarket/{supermarket}', [ProductController::class, 'filterBySupermarket']);


Route::post('/user/cambiar-contraseña', [UserController::class, 'cambiarContraseñaSinLogin'])->middleware('throttle:5,1');

// Test endpoint
Route::get('/test', function () {
    return response()->json(['message' => 'API funcionando']);
});

// Rutas públicas
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
#Route::get('/products/public', [ProductController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);

// Rutas protegidas
Route::middleware(['jwt.auth'])->group(function () {

    Route::delete('/users/{id}', [UserController::class, 'destroy']);


    Route::get('/user', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::put('/update-profile', [UserController::class, 'updateProfile']);
    Route::delete('/delete-account', [UserController::class, 'deleteAccount']);

    // Rutas para clientes (rol 2)
    Route::group([
        'middleware' => function ($request, $next) {
            $user = JWTAuth::parseToken()->authenticate();
            if ($user->rol != 2) {
                return response()->json(['error' => 'No autorizado (rol ≠ 2)'], 403);
            }
            return $next($request);
        }
    ], function () {
       
        
        Route::get('/products/filter/price/{min}/{max}', [ProductController::class, 'filterByPrice']);
        Route::get('/products/filter/nutrition', [ProductController::class, 'filterByNutrition']);
        Route::get('/products/offers', [ProductController::class, 'getOffers']);
        Route::get('/products/nutrition-values', [ProductController::class, 'getProductsWithNutrition']);
        Route::get('/products/ratings', [ProductController::class, 'getProductRatings']);
        Route::get('/products/history', [ProductController::class, 'getUserSearchHistory']);
        Route::get('/products/best-worst', [ProductController::class, 'getBestWorstRatedProducts']);
        Route::get('/supermarkets', [ProductController::class, 'getAvailableSupermarkets']);

        Route::post('/favourites/add', [FavouriteController::class, 'addToFavourites']);
        Route::get('/favourites/list', [FavouriteController::class, 'listFavourites']);
        Route::delete('/favourites/remove/{id}', [FavouriteController::class, 'removeFavourite']);

        Route::get('/compare/{product_id}', [ComparisonController::class, 'compareSupermarkets']);
        Route::post('/compare-nutrients', [ComparisonController::class, 'compareNutrients']);
        Route::get('/recommendations', [ComparisonController::class, 'getRecommendations']);
    });

    // Rutas para administradores (rol 1)
    Route::group([
        'middleware' => function ($request, $next) {
            $user = JWTAuth::parseToken()->authenticate();
            if ($user->rol != 1) {
                return response()->json(['error' => 'No autorizado (rol ≠ 1)'], 403);
            }
            return $next($request);
        }
    ], function () {
        Route::post('/products', [ProductController::class, 'store']);
        Route::put('/products/{id}', [ProductController::class, 'update']);
        Route::delete('/products/{id}', [ProductController::class, 'destroy']);

        Route::get('/users', [UserController::class, 'getUsers']);
        Route::get('/users/search/{email}', [UserController::class, 'searchByEmail']);
        Route::get('/users/{id}', [UserController::class, 'getUserById']);
        Route::get('/users/search/username/{username}', [UserController::class, 'searchByUsername']);
        Route::apiResource('users', UserController::class)->only(['index', 'show']);
    });
});