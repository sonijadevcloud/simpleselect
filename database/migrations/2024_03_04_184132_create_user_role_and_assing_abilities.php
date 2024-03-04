<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Silber\Bouncer\Database\Ability;
use Silber\Bouncer\Database\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tworzenie roli SuperAdmin
        $userRole = Role::create([
            'name' => 'User',
            'title' => 'Normal system user',
        ]);

        // Pobieranie określonych abilities
        $abilities = Ability::whereIn('name', [
            'Home-R',
            'Home-W',
            'Noticies-R',
            'Noticies-W',
            'Subscriptions-R',
            'Subscriptions-W',
            'PPZDictionaries-R',
            'DailySettlement-R',
            'DailySettlement-W',
            'Reports-R',
            'PPZDictionaries-R'
        ])->get();

        // Przypisanie abilities do roli User
        $userRole->abilities()->attach($abilities);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Role::where('name', 'User')->delete();
    }
};
