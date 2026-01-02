<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('current_firma_id')->nullable()->after('password');
            $table->boolean('is_active')->default(true)->after('current_firma_id');
            $table->timestamp('last_login_at')->nullable()->after('is_active');

            $table->index('current_firma_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['current_firma_id', 'is_active', 'last_login_at']);
        });
    }
};
