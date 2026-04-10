<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $table = 'sliders';

    protected $fillable = ['image_url', 'caption', 'sort_order', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];
}
