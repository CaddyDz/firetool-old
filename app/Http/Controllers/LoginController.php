<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Laravel\Nova\Nova;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Controllers\LoginController as NovaLoginController;

class LoginController extends NovaLoginController
{
	/**
	 * Get the login username to be used by the controller.
	 *
	 * @return string
	 */
	public function username(): string
	{
		return 'phone';
	}

	/**
	 * Get the post register / login redirect path.
	 *
	 * @return string
	 */
	public function redirectPath(): string
	{
		return Nova::path() . '/resources/users';
	}

	protected function sendLoginResponse(Request $request)
	{
		$request->session()->regenerate();

		$this->clearLoginAttempts($request);

		$redirectPath = $this->redirectPath();
		redirect()->setIntendedUrl($redirectPath);

		return redirect()->intended($redirectPath);
	}
}
