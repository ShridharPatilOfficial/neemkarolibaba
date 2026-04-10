<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PresidentMessage extends Model
{
    protected $table = 'president_messages';

    protected $fillable = ['president_name', 'president_title', 'photo_url', 'message', 'signature_url', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];
}
