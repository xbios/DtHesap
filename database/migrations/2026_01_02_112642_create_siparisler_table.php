<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('siparisler', function (Blueprint $table) {
            $table->id();
            $table->foreignId('firma_id')->constrained()->onDelete('cascade');
            $table->foreignId('cari_id')->constrained()->onDelete('restrict');
            $table->string('siparis_no', 50);
            $table->enum('siparis_tip', ['alis', 'satis']);
            $table->date('tarih');
            $table->date('teslim_tarih')->nullable();
            $table->enum('durum', ['beklemede', 'onaylandi', 'hazirlaniyor', 'tamamlandi', 'iptal'])->default('beklemede');
            $table->decimal('toplam_tutar', 18, 2)->default(0);
            $table->decimal('kdv_tutar', 18, 2)->default(0);
            $table->decimal('genel_toplam', 18, 2)->default(0);
            $table->string('doviz_tip', 10)->default('TRY');
            $table->decimal('doviz_kur', 18, 4)->default(1);
            $table->text('aciklama')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['firma_id', 'siparis_no']);
            $table->index('tarih');
            $table->index('durum');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siparisler');
    }
};
