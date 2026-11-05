<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    protected $guarded = [];
    protected $casts = ['is_active' => 'boolean'];

    const TYPES = [
        'pricelist' => 'Pricelist',
        'fitting'   => 'Fitting Catalog',
        'katalog'   => 'Katalog Produk',
        'brosur'    => 'Brosur & Lainnya',
    ];

    // File yang diunggah diutamakan, jika tidak ada pakai link
    public function getLinkAttribute(): string
    {
        return $this->file ? asset('storage/' . $this->file) : (string) $this->url;
    }
}