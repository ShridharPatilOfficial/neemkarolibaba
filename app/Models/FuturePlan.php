<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FuturePlan extends Model
{
    protected $table = 'future_plans';

    protected $fillable = ['heading', 'description', 'image_url', 'youtube_url', 'sort_order', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];
}
