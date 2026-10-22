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
        Schema::create('articles', function (Blueprint $t) {
            $t->id();
            $t->string('title');
            $t->string('slug')->unique();
            $t->string('excerpt', 300)->nullable();
            $t->longText('content');                 // ditulis dalam Markdown
            $t->string('image')->nullable();
            $t->string('meta_title')->nullable();
            $t->string('meta_description')->nullable();
            $t->boolean('is_published')->default(false);
            $t->timestamp('published_at')->nullable();
            $t->timestamps();
        });

        Schema::create('leads', function (Blueprint $t) {
            $t->id();
            $t->string('type')->default('quotation');
            $t->string('name');
            $t->string('whatsapp', 30)->nullable();
            $t->string('company')->nullable();
            $t->string('project_type')->nullable();
            $t->string('project_location')->nullable();
            $t->text('products_needed')->nullable();
            $t->string('quantity')->nullable();
            $t->text('notes')->nullable();
            $t->string('source_page')->nullable();
            $t->string('status')->default('new');   // new | contacted | closed
            $t->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('leads');
        Schema::dropIfExists('articles');
    }
};
