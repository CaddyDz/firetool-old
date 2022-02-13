<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\{RateLimiter, Route};
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
	/**
	 * The path to the "home" route for your application.
	 *
	 * This is used by Laravel authentication to redirect users after login.
	 *
	 * @var string
	 */
	public const HOME = '/home';

	/**
	 * Define your route model bindings, pattern filters, etc.
	 *
	 * @return void
	 */
	public function boot(): void
	{
		$this->configureRateLimiting();

		$this->routes(function () {
			Route::prefix('api')
				->middleware('api')
				->group(base_path('routes/api.php'));
		});

		if (config('app.debug')) {
			$this->mapDevRoutes();
		}
	}

	/**
	 * Define the "dev" routes for the application.
	 *
	 * These routes are meant for testing and are inaccessible in production.
	 *
	 * @return void
	 */
	protected function mapDevRoutes(): void
	{
		Route::middleware('web')
			->namespace($this->namespace)
			->group(base_path('routes/dev.php'));
	}

	/**
	 * Configure the rate limiters for the application.
	 *
	 * @return void
	 */
	protected function configureRateLimiting(): void
	{
		RateLimiter::for('api', fn () => Limit::perMinute(60));
	}
}
