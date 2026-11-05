<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('downloads', function (Blueprint $t) {
            $t->id();
            $t->string('title');
            $t->string('type')->default('pricelist');   // pricelist | fitting | katalog | brosur
            $t->string('period')->nullable();            // mis. "Berlaku per Januari 2026"
            $t->text('description')->nullable();
            $t->string('file')->nullable();              // PDF yang diunggah
            $t->string('url', 500)->nullable();          // atau link ke PDF resmi
            $t->unsignedInteger('sort_order')->default(0);
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('downloads');
    }
};
