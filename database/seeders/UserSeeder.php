<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Syarip Mas`ud',
            'phone_number' => '087852373926',
            'sim_number' => '101010',
            'address' => 'Lombok - NTB',
            'password' => Hash::make('password')
        ]);
    }
}
