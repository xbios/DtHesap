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
        Schema::create('cari_hareketler', function (Blueprint $table) {
            $table->id();
            $table->foreignId('firma_id')->constrained()->onDelete('cascade');
            $table->foreignId('cari_id')->constrained()->onDelete('cascade');
            $table->string('evrak_tip', 50);
            $table->unsignedBigInteger('evrak_id')->nullable();
            $table->date('tarih');
            $table->text('aciklama')->nullable();
            $table->decimal('borc', 18, 2)->default(0);
            $table->decimal('alacak', 18, 2)->default(0);
            $table->decimal('bakiye', 18, 2)->default(0);
            $table->string('doviz_tip', 10)->default('TRY');
            $table->decimal('doviz_kur', 18, 4)->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->index('tarih');
            $table->index(['evrak_tip', 'evrak_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cari_hareketler');
    }
};
