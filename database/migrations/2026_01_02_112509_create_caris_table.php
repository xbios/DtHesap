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
        Schema::create('caris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('firma_id')->constrained()->onDelete('cascade');
            $table->string('kod', 50);
            $table->string('unvan', 255);
            $table->enum('tip', ['musteri', 'tedarikci', 'her_ikisi']);
            $table->string('vergi_dairesi', 100)->nullable();
            $table->string('vergi_no', 50)->nullable();
            $table->string('tc_kimlik_no', 11)->nullable();
            $table->text('adres')->nullable();
            $table->string('il', 100)->nullable();
            $table->string('ilce', 100)->nullable();
            $table->string('telefon', 50)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('yetkili_kisi', 255)->nullable();
            $table->text('aciklama')->nullable();
            $table->decimal('borc_limiti', 18, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['firma_id', 'kod']);
            $table->index('tip');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caris');
    }
};
