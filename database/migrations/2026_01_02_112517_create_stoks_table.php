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
        Schema::create('stoks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('firma_id')->constrained()->onDelete('cascade');
            $table->string('kod', 50);
            $table->string('ad', 255);
            $table->foreignId('kategori_id')->nullable()->constrained('stok_kategoriler')->onDelete('set null');
            $table->string('birim', 20)->default('Adet');
            $table->string('barkod', 100)->nullable();
            $table->decimal('kdv_oran', 5, 2)->default(20);
            $table->decimal('alis_fiyat', 18, 2)->default(0);
            $table->decimal('satis_fiyat', 18, 2)->default(0);
            $table->decimal('min_stok', 18, 3)->default(0);
            $table->decimal('max_stok', 18, 3)->default(0);
            $table->text('aciklama')->nullable();
            $table->string('resim_path', 500)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['firma_id', 'kod']);
            $table->index('barkod');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stoks');
    }
};
