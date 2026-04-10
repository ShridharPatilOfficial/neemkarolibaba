<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecentActivity extends Model
{
    protected $table = 'recent_activities';

    protected $fillable = ['heading', 'description', 'image_url', 'youtube_url', 'sort_order', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];
}
