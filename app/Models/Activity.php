<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activities';

    protected $fillable = ['heading', 'description', 'image_url', 'youtube_url', 'sort_order', 'post_year', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];
}
