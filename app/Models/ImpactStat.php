<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImpactStat extends Model
{
    protected $table = 'impact_stats';

    protected $fillable = ['number_value', 'label', 'icon_class', 'sort_order', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];
}
