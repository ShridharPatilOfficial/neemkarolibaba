<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JoinUsSubmission extends Model
{
    protected $table = 'join_us_submissions';

    protected $fillable = ['name', 'phone', 'email', 'message', 'ip_address', 'is_read'];

    protected $casts = ['is_read' => 'boolean'];
}
