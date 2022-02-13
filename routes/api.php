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

Route::controller(ApiController::class)->group(function () {
	Route::post('login', 'login');
	Route::middleware(['auth:sanctum'])->group(function () {
		// lists all users
		Route::get('/user', 'user');
		Route::post('logout', 'logout');
	});
	// auth routes
});
