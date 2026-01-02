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
        Schema::create('firmas', function (Blueprint $table) {
            $table->id();
            $table->string('kod', 50)->unique();
            $table->string('unvan', 255);
            $table->string('vergi_dairesi', 100)->nullable();
            $table->string('vergi_no', 50)->nullable();
            $table->text('adres')->nullable();
            $table->string('il', 100)->nullable();
            $table->string('ilce', 100)->nullable();
            $table->string('telefon', 50)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('website', 255)->nullable();
            $table->string('logo_path', 500)->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('ayarlar')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('firmas');
    }
};
