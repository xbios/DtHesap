<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cek_hareketler', function (Blueprint $table) {
            $table->id();
            $table->foreignId('firma_id')->constrained()->onDelete('cascade');
            $table->foreignId('cek_id')->constrained()->onDelete('cascade');
            $table->date('tarih');
            $table->enum('islem_tip', ['giris', 'cikis', 'tahsil', 'odeme', 'iade']);
            $table->text('aciklama')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();

            $table->index('tarih');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cek_hareketler');
    }
};
