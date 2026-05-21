<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\AccountNumber;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate([
            'username' => 'admin'
        ], [
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'phone' => '',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'status' => 1,
        ]);

        AccountNumber::firstOrCreate([
            'account_number' => '01700000000'
        ], [
            'account_name' => 'Main bKash',
            'type' => 'personal',
            'status' => 1,
            'note' => 'Primary account',
        ]);
    }
}
