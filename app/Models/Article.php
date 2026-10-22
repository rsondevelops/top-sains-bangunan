<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $guarded = [];
    protected $casts = ['is_published' => 'boolean', 'published_at' => 'datetime'];
}

class Lead extends Model
{
    protected $guarded = [];
}
