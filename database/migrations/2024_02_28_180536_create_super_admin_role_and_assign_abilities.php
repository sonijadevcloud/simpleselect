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
        $superAdminRole = Role::create([
            'name' => 'SuperAdmin',
            'title' => 'Fully access administrator',
        ]);

        // Pobieranie wszystkich abilities
        $abilities = Ability::all();

        // Przypisanie abilities do roli SuperAdmin
        $superAdminRole->abilities()->attach($abilities);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Usunięcie roli SuperAdmin
        Role::where('name', 'SuperAdmin')->delete();
    }
};
