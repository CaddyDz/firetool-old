<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run(): void
	{
		User::factory()->create([
			'name' => 'Admin',
			'phone' => '+213550647548',
		]);
		User::factory(10)->create();
	}
}
