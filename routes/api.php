<?php

use App\Http\Controllers\PasswordReserController;
use App\Http\Controllers\UserController;
use App\Models\PasswordReser;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//public routes
Route::post('home',[UserController::class,'register']);
Route::post('login',[UserController::class,'login']);
Route::post('password_reset',[PasswordReserController::class,'password_reset']);
Route::post('password_reset/{token}',[PasswordReserController::class,'reset']);


//protected routes
Route::middleware(['auth:sanctum'])->group(function(){
    Route::post('logout',[UserController::class,'logout']);
    Route::get('logeduser',[UserController::class,'logeduser']);
    Route::post('changepassword',[UserController::class,'changepassword']);
});
