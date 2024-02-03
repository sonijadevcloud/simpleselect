<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'System Admin',
            'email' => 'support@sonija.cloud',
            'password' => Hash::make('Korale23!204@')
        ]);
    }
}
