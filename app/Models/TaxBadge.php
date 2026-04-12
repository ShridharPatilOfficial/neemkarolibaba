<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaxBadge extends Model
{
    protected $table = 'tax_badges';

    protected $fillable = ['label', 'document_id', 'sort_order', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }
}
