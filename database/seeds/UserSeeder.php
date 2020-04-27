<?php

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
            'first_name' => 'Joaquin',
            'last_name' => 'Vilchez',
            'email' => 'joaquinvilchez95@gmail.com',
            'password' => bcrypt('3844604125071995'),
            'phone' => '3462642680',
            'type' => 'administrator'
        ]);
    
        // User::create([
        //     'first_name' => 'Juan',
        //     'last_name' => 'Perez',
        //     'email' => 'juanperez@gmail.com',
        //     'password' => bcrypt('12345678'),
        //     'phone' => '3462336749',
        //     'type' => 'customer'
        // ]);

        // User::create([
        //     'first_name' => 'Maria',
        //     'last_name' => 'Rodriguez',
        //     'email' => 'mariarodriguez@gmail.com',
        //     'password' => bcrypt('12345678'),
        //     'phone' => '3462778457',
        //     'type' => 'merchant'
        // ]);
    }
}