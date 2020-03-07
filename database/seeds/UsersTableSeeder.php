<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'first_name' => 'Hector',
            'last_name' => 'Caraballo',
            'email' => 'hcdisat@gmail.com',
            'username' => 'hcdisat',
        ]);
    }
}
