<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
	/**
	 * The policy mappings for the application.
	 *
	 * @var array<class-string, class-string>
	 */
	protected $policies = [
		// 'App\Models\Model' => 'App\Policies\ModelPolicy',
	];

	/**
	 * Register any authentication / authorization services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->registerPolicies();

		Gate::define('sadmin', function ($user) {
			return $user->role_id === 1;
		});

		Gate::define('admin', function ($user) {
			return $user->role_id === 2;
		});

		Gate::define('store', function ($user) {
			return $user->role_id === 3;
		});

		Gate::define('cutting', function ($user) {
			return $user->role_id === 4;
		});

		Gate::define('sewing', function ($user) {
			return $user->role_id === 5;
		});

		Gate::define('washing', function ($user) {
			return $user->role_id === 6;
		});

		Gate::define('finishing', function ($user) {
			return $user->role_id === 7;
		});

		Gate::define('authCheck', function ($user) {
			return $user->role_id === 1 || $user->role_id === 2 || $user->role_id === 3 ||
				$user->role_id === 4 || $user->role_id === 5 || $user->role_id === 6 || $user->role_id === 7;
		});
	}
}
