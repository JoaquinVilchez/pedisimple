<?php

namespace Database\Seeders;


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'Juan Carlos',
            'last_name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('admin'),
            'phone' => '3462642680',
            'type' => 'administrator'
        ]);
    
        User::create([
            'first_name' => 'Juan Carlos',
            'last_name' => 'Cliente',
            'email' => 'cliente@mail.com',
            'password' => bcrypt('12345678'),
            'phone' => '3462336749',
            'type' => 'customer'
        ]);

        User::create([
            'first_name' => 'Juan Carlos',
            'last_name' => 'Comerciante',
            'email' => 'comerciante@mail.com',
            'password' => bcrypt('12345678'),
            'phone' => '3462778457',
            'type' => 'merchant'
        ]);
    }
}