<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSubmission extends Model
{
    protected $table = 'contact_submissions';

    protected $fillable = ['first_name', 'last_name', 'email', 'phone', 'message', 'ip_address', 'is_read'];

    protected $casts = ['is_read' => 'boolean'];
}
