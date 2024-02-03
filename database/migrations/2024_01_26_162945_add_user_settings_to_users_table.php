<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('phone')->nullable();
        $table->string('profile_picture')->nullable();
        $table->text('description')->nullable();
        $table->string('position')->nullable();
        $table->boolean('two_factor_enabled')->default(false);
        $table->text('signature')->nullable();
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['phone', 'profile_picture', 'description', 'position', 'two_factor_enabled', 'signature']);
    });
}

};
