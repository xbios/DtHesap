<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('odeme_hareketler', function (Blueprint $table) {
            $table->id();
            $table->foreignId('firma_id')->constrained()->onDelete('cascade');
            $table->foreignId('fatura_id')->nullable()->constrained()->onDelete('cascade');
            $table->date('tarih');
            $table->decimal('tutar', 18, 2);
            $table->enum('odeme_tip', ['nakit', 'banka', 'cek', 'senet', 'kredi_karti']);
            $table->foreignId('kasa_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('banka_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('cek_id')->nullable()->constrained()->onDelete('set null');
            $table->text('aciklama')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('tarih');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('odeme_hareketler');
    }
};
