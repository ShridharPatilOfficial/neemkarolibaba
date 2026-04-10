<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MediaCoverage extends Model {
    protected $fillable = ['title','description','source_name','source_url','youtube_url','cover_image_url','published_date','category','sort_order','is_active'];
    protected $casts    = ['is_active' => 'boolean', 'published_date' => 'date'];

    public function getYoutubeIdAttribute(): ?string {
        preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $this->youtube_url ?? '', $m);
        return $m[1] ?? null;
    }

    public static function categories(): array {
        return ['news' => 'News Article', 'tv' => 'TV / Video', 'online' => 'Online Media', 'magazine' => 'Magazine'];
    }
}
