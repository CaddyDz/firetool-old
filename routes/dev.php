<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::get(
	'/debug-sentry',
	fn () =>
	throw new Exception('My first Sentry error!')
);
