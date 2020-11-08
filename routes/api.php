<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

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

Route::middleware(['auth:sanctum'])->group(function () {
	// lists all users
	Route::get('/user', [ApiController::class, 'user']);
	Route::post('logout', [ApiController::class, 'logout']);
});
// auth routes
Route::post('login', [ApiController::class, 'login']);
