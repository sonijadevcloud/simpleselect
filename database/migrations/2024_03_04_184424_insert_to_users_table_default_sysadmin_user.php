<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Silber\Bouncer\Database\Ability;
use Silber\Bouncer\Database\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $user = User::create([
            'name' => 'sysadmin',
            'email' => 'support@sonija.cloud',
            'password' => bcrypt('Taboret1234QWER!@#$'),
            'phone' => '790218045',
            'position' => 'Default SuperAdmin SDC account',
        ]);

        // Przypisz rolę SuperAdmin
        $superAdminRole = Role::where('name', 'SuperAdmin')->first();
        $user->roles()->attach($superAdminRole);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        User::where('email', 'support@sonija.cloud')->delete();
    }
};
