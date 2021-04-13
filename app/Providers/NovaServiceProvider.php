<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\{Gate, Route};
use Laravel\Nova\{Nova, NovaApplicationServiceProvider};

class NovaServiceProvider extends NovaApplicationServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		parent::boot();
	}

	/**
	 * Register the Nova routes.
	 *
	 * @return void
	 */
	protected function routes()
	{
		$this->withAuthenticationRoutes();
		Nova::routes()
			->register();
	}

	/**
	 * Register the Nova authentication routes.
	 *
	 * @param array $middleware
	 * @return $this
	 */
	public function withAuthenticationRoutes($middleware = ['web'])
	{
		Route::namespace('App\Http\Controllers')
			->domain(config('nova.domain', null))
			->middleware($middleware)
			->prefix(Nova::path())
			->group(function () {
				Route::get('/login', 'LoginController@showLoginForm');
				Route::post('/login', 'LoginController@login')->name('nova.login');
			});

		Route::namespace('Laravel\Nova\Http\Controllers')
			->domain(config('nova.domain', null))
			->middleware(config('nova.middleware', []))
			->prefix(Nova::path())
			->group(function () {
				Route::get('/logout', 'LoginController@logout')->name('nova.logout');
			});

		return $this;
	}

	/**
	 * Register the Nova gate.
	 *
	 * This gate determines who can access Nova in non-local environments.
	 *
	 * @return void
	 */
	protected function gate()
	{
		Gate::define('viewNova', function ($user) {
			return in_array($user->phone, [
				'+213550647548'
			]);
		});
	}

	/**
	 * Get the cards that should be displayed on the default Nova dashboard.
	 *
	 * @return array
	 */
	protected function cards()
	{
		return [];
	}

	/**
	 * Get the extra dashboards that should be displayed on the Nova dashboard.
	 *
	 * @return array
	 */
	protected function dashboards()
	{
		return [];
	}

	/**
	 * Get the tools that should be listed in the Nova sidebar.
	 *
	 * @return array
	 */
	public function tools()
	{
		return [];
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}
}
