<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Technique extends Model
{
    use HasFactory;

    protected $fillable = [
        'academy_id',
        'name',
        'description',
        'youtube_url',
        'youtube_id',
        'created_by',
        'created_at',
        'updated_at'
    ];

    protected $appends = ['youtube_embed_url'];

    public function trainingSessions(): BelongsToMany
    {
        return $this->belongsToMany(TrainingSession::class);
    }

    public function getYoutubeEmbedUrlAttribute()
    {
        if (!$this->youtube_id) {
            return null;
        }
        $embedUrl = 'https://www.youtube-nocookie.com/embed/' . $this->youtube_id;

        $startTime = self::youtubeTimeToSeconds($this->youtube_url);
        if ($startTime) {
            $embedUrl = $embedUrl . '?start=' . $startTime;
        }
        return $embedUrl;
    }

    public static function youtubeTimeToSeconds($youtubeUrl)
    {
        preg_match("/((#)|(\&)|(\?))t=(\d+h)?(\d+m)?(\d+s)?/", $youtubeUrl, $matches);

        $totalSeconds = 0;
        for ($i = 1; $i < count($matches); $i++) {
            $match = $matches[$i];
            if (Str::endsWith($match, 'h')) {
                $hours = rtrim($match, 'h');
                $totalSeconds = $totalSeconds + (intval($hours) * 3600);
            } elseif (Str::endsWith($match, 'm')) {
                $minutes = rtrim($match, 'm');
                $totalSeconds = $totalSeconds + (intval($minutes) * 60);
            } elseif (Str::endsWith($match, 's')) {
                $seconds = rtrim($match, 's');
                $totalSeconds = $totalSeconds + intval($seconds);
            }
        }
        return $totalSeconds;
    }
}
