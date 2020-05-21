<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * PLAYER PAGES
 */

Route::get('/', "GetStart");
Route::post("/", "PostStart");

Route::get("/{playerId}/waiting-room", "GetWaitingRoom");

Route::get("/{playerId}/question/{questionId}", "GetQuestion");
Route::post("/{playerId}/question/{questionId}", "PostQuestion");

Route::get("/{playerId}/results", "GetResults");

/**
 * GAME MANAGEMENT
 */

Route::group(['middleware' => 'auth.basic'], function () {
    Route::get("/dashboard", "Admin\GetDashboard");
    Route::get("/game/{gameId}", "Admin\GetGame");

    Route::post("/game", "Admin\PostCreateGame");
    Route::post("/game/{gameId}/activate", "Admin\PostActivateGame");
    Route::post("/game/{gameId}/start", "Admin\PostStartGame");
    Route::post("/game/{gameId}/remove/{playerId}", "Admin\PostRemovePlayer");
});
