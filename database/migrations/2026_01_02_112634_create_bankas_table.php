<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bankas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('firma_id')->constrained()->onDelete('cascade');
            $table->string('kod', 50);
            $table->string('banka_adi', 255);
            $table->string('sube_adi', 255)->nullable();
            $table->string('hesap_no', 100)->nullable();
            $table->string('iban', 50)->nullable();
            $table->string('doviz_tip', 10)->default('TRY');
            $table->decimal('acilis_bakiye', 18, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->text('aciklama')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['firma_id', 'kod']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bankas');
    }
};
