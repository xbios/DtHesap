<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('siparis_detaylar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('firma_id');
            $table->unsignedBigInteger('siparis_id');
            $table->unsignedBigInteger('stok_id')->nullable();

            $table->foreign('firma_id')->references('id')->on('firmas')->onDelete('cascade');
            $table->foreign('siparis_id')->references('id')->on('siparisler')->onDelete('cascade');
            $table->foreign('stok_id')->references('id')->on('stoks')->onDelete('set null');
            $table->string('aciklama', 500);
            $table->decimal('miktar', 18, 3);
            $table->decimal('teslim_miktar', 18, 3)->default(0);
            $table->string('birim', 20)->default('Adet');
            $table->decimal('birim_fiyat', 18, 2);
            $table->decimal('kdv_oran', 5, 2)->default(20);
            $table->decimal('toplam', 18, 2)->default(0);
            $table->integer('sira')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siparis_detaylar');
    }
};
