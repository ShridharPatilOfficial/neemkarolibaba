<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';

    protected $fillable = ['heading', 'description', 'image_url', 'youtube_url', 'sort_order', 'post_year', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];
}
