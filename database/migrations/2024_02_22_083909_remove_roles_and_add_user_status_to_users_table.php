<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Usuń kolumnę role_id z tabeli users
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });

        // Usuń tabelę roles
        Schema::dropIfExists('roles');

        // Dodaj kolumnę user_status do tabeli users
        Schema::table('users', function (Blueprint $table) {
            $table->enum('user_status', ['active', 'notactive', 'blocked'])->default('active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Jeśli konieczne, odwróć operacje wykonywane w metodzie up()
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->dropColumn('user_status');
        });

        // Jeśli konieczne, odtwórz tabelę roles
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 45);
            $table->string('description', 255)->nullable();
            $table->timestamps();
        });
    }
};
