<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    protected $casts = [
        'specifications' => 'array', 'suitable_for' => 'array',
        'styles' => 'array', 'usages' => 'array',
        'is_featured' => 'boolean', 'is_best_seller' => 'boolean', 'is_active' => 'boolean',
    ];

    public function category() { return $this->belongsTo(Category::class); }
    public function brand()    { return $this->belongsTo(Brand::class); }
    public function images()   { return $this->hasMany(ProductImage::class)->orderBy('sort_order'); }

    public function related()
    {
        return $this->belongsToMany(Product::class, 'product_relations', 'product_id', 'related_product_id')
            ->orderBy('product_relations.sort_order');
    }

    public function getDisplayNameAttribute(): string
    {
        return trim(($this->brand?->name ?? '') . ' ' . ($this->sku ?: $this->name));
    }

    public function getUrlAttribute(): string
    {
        return url('/produk/' . $this->category->slug . '/' . $this->slug);
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}