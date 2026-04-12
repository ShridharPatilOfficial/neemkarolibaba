<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrustObjective extends Model
{
    protected $table = 'trust_objectives';

    protected $fillable = ['title', 'description', 'image', 'sort_order', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    /** Full public URL for the image (or null if no image). */
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) return null;
        if (str_starts_with($this->image, 'http')) return $this->image;
        return asset('storage/' . $this->image);
    }
}
