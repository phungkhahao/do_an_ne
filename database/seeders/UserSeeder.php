<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'ho_ten' => 'Admin',
            'email' => 'admin@email.com',
            'username' => "admin",
            'password' => Hash::make('123456'),
            'sdt' => '123456',
        ]);
    }
}
