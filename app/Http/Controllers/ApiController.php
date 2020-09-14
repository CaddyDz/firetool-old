<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\Token;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ApiController extends Controller
{
	/**
	 * details api
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function user(Request $request)
	{
		return $request->user();
	}

	/**
	 * login api
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function login(Token $request)
	{
		$user = User::where('phone', $request->phone)->first();

		if ($user && $user->tokens->isNotEmpty()) {
			return response([
				'status' => 'Already logged in',
			], 403);
		}

		if (!$user || !Hash::check($request->password, $user->password)) {
			throw ValidationException::withMessages([
				'phone' => ['The provided credentials are incorrect.'],
			]);
		}

		return $user->createToken($request->device_name)->plainTextToken;
	}

	/**
	 * Logout user
	 *
	 * Revoke all tokens of user
	 *
	 * @param \Illuminate\Http\Request $request Request object
	 * @return \Illuminate\Http\Response
	 **/
	public function logout(Request $request): Response
	{
		// Revoke all tokens...
		$request->user()->tokens()->delete();
		return response([
			'status' => 'Logged out',
		], 204);
	}
}
