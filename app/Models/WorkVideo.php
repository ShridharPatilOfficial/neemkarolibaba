<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class WorkVideo extends Model {
    protected $fillable = ['title','description','youtube_url','thumbnail_url','sort_order','is_active'];
    protected $casts    = ['is_active' => 'boolean'];

    public function getYoutubeIdAttribute(): ?string {
        preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $this->youtube_url ?? '', $m);
        return $m[1] ?? null;
    }
    public function getThumbnailAttribute(): string {
        if ($this->thumbnail_url) return $this->thumbnail_url;
        $id = $this->youtube_id;
        return $id ? "https://img.youtube.com/vi/{$id}/maxresdefault.jpg" : '';
    }
}
