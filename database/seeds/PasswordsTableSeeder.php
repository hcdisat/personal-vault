<?php

use App\Models\Password;
use Illuminate\Database\Seeder;

class PasswordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Password::class, 10)
            ->create();
    }
}
