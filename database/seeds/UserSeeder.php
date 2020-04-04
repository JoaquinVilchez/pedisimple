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
            'first-name' => 'Joaquin',
            'last-name' => 'Vilchez',
            'email' => 'joaquinvilchez95@gmail.com',
            'password' => bcrypt('12345678'),
            'phone' => '3462642680',
            'type' => 'merchant'
        ]);
    
        User::create([
            'first-name' => 'Juan',
            'last-name' => 'Perez',
            'email' => 'juanperez@gmail.com',
            'password' => bcrypt('12345678'),
            'phone' => '3462336749',
            'type' => 'customer'
        ]);

        User::create([
            'first-name' => 'Maria',
            'last-name' => 'Rodriguez',
            'email' => 'mariarodriguez@gmail.com',
            'password' => bcrypt('12345678'),
            'phone' => '3462778457',
            'type' => 'merchant'
        ]);
    }
}