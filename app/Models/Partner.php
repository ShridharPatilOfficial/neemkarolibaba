<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $table = 'partners';

    protected $fillable = ['name', 'logo_url', 'website_url', 'sort_order', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];
}
