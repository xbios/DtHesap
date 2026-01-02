<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kasa_hareketler', function (Blueprint $table) {
            $table->id();
            $table->foreignId('firma_id')->constrained()->onDelete('cascade');
            $table->foreignId('kasa_id')->constrained()->onDelete('cascade');
            $table->string('evrak_tip', 50);
            $table->unsignedBigInteger('evrak_id')->nullable();
            $table->date('tarih');
            $table->enum('islem_tip', ['giris', 'cikis']);
            $table->decimal('tutar', 18, 2);
            $table->string('doviz_tip', 10)->default('TRY');
            $table->decimal('doviz_kur', 18, 4)->default(1);
            $table->text('aciklama')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('tarih');
            $table->index(['evrak_tip', 'evrak_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kasa_hareketler');
    }
};
