<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonateSetting extends Model
{
    protected $table = 'donate_settings';

    protected $fillable = ['key', 'value', 'type'];

    public static function get(string $key, string $default = ''): string
    {
        $setting = static::where('key', $key)->first();
        return $setting ? (string) $setting->value : $default;
    }

    public static function set(string $key, string $value, string $type = 'text'): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value, 'type' => $type]);
    }
}
