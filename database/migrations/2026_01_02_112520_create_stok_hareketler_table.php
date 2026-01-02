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
        Schema::create('stok_hareketler', function (Blueprint $table) {
            $table->id();
            $table->foreignId('firma_id')->constrained()->onDelete('cascade');
            $table->foreignId('stok_id')->constrained()->onDelete('cascade');
            $table->string('evrak_tip', 50);
            $table->unsignedBigInteger('evrak_id')->nullable();
            $table->date('tarih');
            $table->decimal('giris', 18, 3)->default(0);
            $table->decimal('cikis', 18, 3)->default(0);
            $table->decimal('bakiye', 18, 3)->default(0);
            $table->decimal('birim_fiyat', 18, 2)->default(0);
            $table->text('aciklama')->nullable();
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
        Schema::dropIfExists('stok_hareketler');
    }
};
