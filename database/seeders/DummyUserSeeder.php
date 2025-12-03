<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DummyUserSeeder extends Seeder
{
    public function run(): void
    {
        // user admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@mail.com'],
            [
                'name' => 'Cece Syamsul Hadi',
                'password' => bcrypt('password123')
            ]
        );
        $admin->assignRole('admin');

        // user biasa
        $user = User::firstOrCreate(
            ['email' => 'user@mail.com'],
            [
                'name' => 'Febri Herdian',
                'password' => bcrypt('password123')
            ]
        );
        $user->assignRole('pelanggan');

        $cs1 = User::firstOrCreate(
            ['email' => 'cs1@mail.com'],
            [
                'name' => 'CS 1',
                'password' => bcrypt('password123')
            ]
        );

        $cs1->assignRole('cs1');

        $cs2 = User::firstOrCreate(
            ['email' => 'cs2@mail.com'],
            [
                'name' => 'CS 2',
                'password' => bcrypt('password123')
            ]
        );
        $cs2->assignRole('cs2');
    }
}
