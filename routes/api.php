<?php

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Admin
Route::group([
    'prefix' => "admin", 
    'middleware' => [
            'assign.guard:admin'
        ]
    ], function(){
    // Auth related 
    Route::prefix("auth")->group(function() {
        Route::post("store", [\App\Http\Controllers\Admin\AuthController::class, "store"])->name("admin.auth.store");
        Route::post("login", [\App\Http\Controllers\Admin\AuthController::class, "login"])->name("admin.auth.login");
        // Route::get("/", [\App\Http\Controllers\Admin\AuthController::class, "index"])->name("admin.auth");
    });

    Route::middleware("jwt.verify")->group(function() {
            Route::post("auth/logout", [\App\Http\Controllers\Admin\AuthController::class, "logout"])->name("admin.auth.logout");
    });
});