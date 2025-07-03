<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'titulo',
        'descripcion',
        'url_youtube',
        'video_id_youtube',
        'duracion',
        'orden',
        'estado',
        'curso_id'
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function setUrlYoutubeAttribute($value)
    {
        $this->attributes['url_youtube'] = $value;
        $this->attributes['video_id_youtube'] = $this->extractYouTubeId($value);
    }

    private function extractYouTubeId($url)
    {
        preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\n?#]+)/', $url, $matches);
        return $matches[1] ?? null;
    }

    public function getThumbnailUrlAttribute()
    {
        return "https://img.youtube.com/vi/{$this->video_id_youtube}/maxresdefault.jpg";
    }

    public function getEmbedUrlAttribute()
    {
        return "https://www.youtube.com/embed/{$this->video_id_youtube}";
    }
}
