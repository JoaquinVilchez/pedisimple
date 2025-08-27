<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Invitation;
use Carbon\Carbon;

class InvitationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Invitation::create([
            'first_name' => 'Joaquin',
            'last_name' => 'Vilchez',
            'email' => 'joaquinvilchez95@gmail.com',
            'token' => bcrypt('joaquin-vilchez-'.Carbon::now()),
        ]);
    }
}
