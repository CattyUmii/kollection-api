<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//defined user route
Route::prefix("users")->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/assign-role/{id}/{roleId}', [UserController::class, "assignRole"]);
    Route::get('/{id}', [UserController::class, 'show'])->whereNumber("id");
});

//defined address route
Route::prefix("address")->group(function() {
    Route::get('/', [AddressController::class, 'index']);
    Route::get('/{id}', [AddressController::class, 'show'])->whereNumber("id");
});

//defined article route
Route::prefix("articles")->group(function() {
    Route::get('/', [ArticleController::class, 'index']);
    Route::post('/create/{userId}', [ArticleController::class, "store"]);
    Route::get('/{id}', [ArticleController::class, 'show'])->whereNumber("id");
    Route::get('/assign-article/{id}/{articleId}', [ArticleController::class, "assignArticle"]);
    Route::get('/user/{id}', [ArticleController::class, 'getArticleByEachUser'])->whereNumber("id");
});

Route::prefix("roles")->group(function() {
    Route::get('/', [RoleController::class, 'index']);
    Route::get('/{id}', [RoleController::class, 'show']);
    Route::post('/create', [RoleController::class, 'store']);
    Route::patch('/{id}', [RoleController::class, 'update']);
});




