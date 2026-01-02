<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ceks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('firma_id')->constrained()->onDelete('cascade');
            $table->foreignId('cari_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('banka_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('cek_tip', ['musteri_ceki', 'kendi_cekimiz', 'senet']);
            $table->enum('portfoy_tip', ['alacak', 'borc']);
            $table->string('cek_no', 100);
            $table->decimal('tutar', 18, 2);
            $table->date('vade_tarih');
            $table->enum('durum', ['portfoyde', 'bankaya_verildi', 'tahsil_edildi', 'odendi', 'iade'])->default('portfoyde');
            $table->string('banka_adi', 255)->nullable();
            $table->string('sube_adi', 255)->nullable();
            $table->string('hesap_no', 100)->nullable();
            $table->string('keside_yeri', 255)->nullable();
            $table->date('keside_tarih')->nullable();
            $table->text('aciklama')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('vade_tarih');
            $table->index('durum');
            $table->index('cek_tip');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ceks');
    }
};
