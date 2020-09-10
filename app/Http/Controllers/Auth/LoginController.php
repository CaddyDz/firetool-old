<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
	/*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

	use AuthenticatesUsers;

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = RouteServiceProvider::HOME;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest')->except('logout', 'fuckoff');
	}

	/**
	 * Get the login username to be used by the controller.
	 *
	 * @return string
	 */
	public function username()
	{
		return 'phone';
	}

	/**
	 * Attempt to log the user into the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return bool
	 */
	protected function attemptLogin(Request $request)
	{
		$already_logged_in = optional(User::where('phone', $request->phone)->first())->logged_in;
		if ($already_logged_in) {
			return false;
		}
		return $this->guard()->attempt(
			$this->credentials($request),
			$request->filled('remember')
		);
	}

	protected function authenticated()
	{
		$user = auth()->user();
		$user->logged_in = true;
		$user->save();
	}

	/**
	 * Log the user out of the application.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
	 */
	public function logout(Request $request)
	{
		if (!auth()->check()) {
			return response([
				'status' => 'Bad Request',
				'message' => "Can't log out who's not logged in"
			], 200);
		}
		$user = $request->user();
		$user->logged_in = false;
		$user->save();

		$this->guard()->logout();

		$request->session()->invalidate();

		$request->session()->regenerateToken();

		if ($response = $this->loggedOut($request)) {
			return $response;
		}

		return $request->wantsJson()
			? new JsonResponse([], 204)
			: redirect('/');
	}

	public function fuckoff(Request $request)
	{
		$user = User::where('phone', $request->phone)->first();
		if (!$user) {
			return response([
				'status' => 'User not found'
			], 200);
		}
		Auth::setUser($user);
		Auth::logout();
		return response([
			'status' => 'Logged out'
		], 200);
	}
}
