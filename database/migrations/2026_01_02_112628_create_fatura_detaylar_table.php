<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fatura_detaylar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('firma_id')->constrained()->onDelete('cascade');
            $table->foreignId('fatura_id')->constrained()->onDelete('cascade');
            $table->foreignId('stok_id')->nullable()->constrained()->onDelete('set null');
            $table->string('aciklama', 500);
            $table->decimal('miktar', 18, 3);
            $table->string('birim', 20)->default('Adet');
            $table->decimal('birim_fiyat', 18, 2);
            $table->decimal('kdv_oran', 5, 2)->default(20);
            $table->decimal('kdv_tutar', 18, 2)->default(0);
            $table->decimal('indirim_oran', 5, 2)->default(0);
            $table->decimal('indirim_tutar', 18, 2)->default(0);
            $table->decimal('toplam', 18, 2)->default(0);
            $table->integer('sira')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fatura_detaylar');
    }
};
