<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Principle extends Model
{
    protected $fillable = [
        'title',
        'description',
        'icon',
        'color_theme',
        'link_url',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Returns gradient + bg CSS classes for the given color_theme.
     * All class names are statically present in the codebase so Tailwind includes them.
     */
    public static function themeMap(): array
    {
        return [
            'orange'  => ['gradient' => 'from-orange-500 to-red-500',      'bg' => 'bg-orange-50',  'label' => 'Orange / Red'],
            'purple'  => ['gradient' => 'from-purple-600 to-violet-700',   'bg' => 'bg-purple-50',  'label' => 'Purple / Violet'],
            'emerald' => ['gradient' => 'from-emerald-500 to-teal-600',    'bg' => 'bg-emerald-50', 'label' => 'Emerald / Teal'],
            'blue'    => ['gradient' => 'from-blue-500 to-indigo-600',     'bg' => 'bg-blue-50',    'label' => 'Blue / Indigo'],
            'teal'    => ['gradient' => 'from-teal-500 to-cyan-600',       'bg' => 'bg-teal-50',    'label' => 'Teal / Cyan'],
            'red'     => ['gradient' => 'from-red-500 to-rose-600',        'bg' => 'bg-red-50',     'label' => 'Red / Rose'],
            'yellow'  => ['gradient' => 'from-yellow-500 to-orange-500',   'bg' => 'bg-yellow-50',  'label' => 'Yellow / Orange'],
            'pink'    => ['gradient' => 'from-pink-500 to-rose-500',       'bg' => 'bg-pink-50',    'label' => 'Pink / Rose'],
        ];
    }

    public function getThemeAttribute(): array
    {
        return static::themeMap()[$this->color_theme] ?? static::themeMap()['orange'];
    }
}
