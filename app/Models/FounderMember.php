<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FounderMember extends Model
{
    protected $table = 'founder_members';

    protected $fillable = ['name', 'role', 'photo_url', 'sort_order', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];
}
