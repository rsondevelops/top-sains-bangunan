<?php

use Illuminate\Database\Migrations\Migration;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $t) {
            $t->id();
            $t->string('key')->unique();
            $t->text('value')->nullable();
        });

        Schema::create('categories', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('slug')->unique();
            $t->text('description')->nullable();
            $t->string('image')->nullable();
            $t->unsignedInteger('sort_order')->default(0);
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });

        Schema::create('brands', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('slug')->unique();
            $t->string('logo')->nullable();
            $t->text('description')->nullable();
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });

        Schema::create('products', function (Blueprint $t) {
            $t->id();
            $t->foreignId('category_id')->constrained();
            $t->foreignId('brand_id')->nullable()->constrained();
            $t->string('name');
            $t->string('slug')->unique();
            $t->string('sku')->nullable();
            $t->string('short_description')->nullable();
            $t->text('description')->nullable();
            $t->unsignedBigInteger('price')->nullable();
            $t->string('image')->nullable();
            $t->json('specifications')->nullable();
            $t->json('suitable_for')->nullable();
            $t->json('styles')->nullable();
            $t->json('usages')->nullable();
            $t->string('meta_title')->nullable();
            $t->string('meta_description')->nullable();
            $t->boolean('is_featured')->default(false);
            $t->boolean('is_best_seller')->default(false);
            $t->boolean('is_active')->default(true);
            $t->unsignedInteger('sort_order')->default(0);
            $t->timestamps();
        });

        Schema::create('product_images', function (Blueprint $t) {
            $t->id();
            $t->foreignId('product_id')->constrained()->cascadeOnDelete();
            $t->string('path');
            $t->string('alt')->nullable();
            $t->unsignedInteger('sort_order')->default(0);
        });

        Schema::create('product_relations', function (Blueprint $t) {
            $t->foreignId('product_id')->constrained()->cascadeOnDelete();
            $t->foreignId('related_product_id')->constrained('products')->cascadeOnDelete();
            $t->unsignedInteger('sort_order')->default(0);
            $t->primary(['product_id', 'related_product_id']);
        });

        Schema::create('testimonials', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('role_company')->nullable();
            $t->text('content');
            $t->string('image')->nullable();
            $t->boolean('is_featured')->default(false);
            $t->boolean('is_active')->default(true);
            $t->unsignedInteger('sort_order')->default(0);
            $t->timestamps();
        });

        Schema::create('projects', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('slug')->unique();
            $t->string('location')->nullable();
            $t->string('type')->nullable();
            $t->string('image')->nullable();
            $t->text('description')->nullable();
            $t->json('gallery')->nullable();
            $t->boolean('is_featured')->default(false);
            $t->boolean('is_active')->default(true);
            $t->unsignedInteger('sort_order')->default(0);
            $t->timestamps();
        });
    }

    public function down(): void
    {
        foreach (['projects','testimonials','product_relations','product_images','products','brands','categories','settings'] as $table) {
            Schema::dropIfExists($table);
        }
    }

};