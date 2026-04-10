<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'documents';

    protected $fillable = ['name', 'file_path', 'file_type', 'sort_order', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];
}
