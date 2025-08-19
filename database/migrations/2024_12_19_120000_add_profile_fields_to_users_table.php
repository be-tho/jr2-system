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
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_image')->nullable()->after('email');
            $table->boolean('email_notifications')->default(true)->after('profile_image');
            $table->boolean('dark_mode')->default(false)->after('email_notifications');
            $table->enum('language', ['es', 'en'])->default('es')->after('dark_mode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['profile_image', 'email_notifications', 'dark_mode', 'language']);
        });
    }
};
