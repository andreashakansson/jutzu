<?php
namespace App\Services;

use Illuminate\Support\Facades\Log;

class TechniqueService {

    public function getVideoUrl($videourl)
    {
        if (strstr($videourl, 'youtu.be')) {
            parse_str(parse_url($videourl, PHP_URL_QUERY), $vars);
            $time = null;
            if (array_key_exists('t', $vars)) {
                $time = $vars['t'] . 's';
            }

            $parseUrl = parse_url($videourl);
            Log::info('Parse URL');
            Log::info($parseUrl);
            if (array_key_exists('path', $parseUrl)) {
                Log::info('path:' . $parseUrl['path']);
                $videoId = trim($parseUrl['path'], '/');
                $videourl = 'https://youtube.com/watch?v=' . $videoId;
                if ($time) {
                    $videourl .= '&t=' . $time;
                }
            }
        }
        return $videourl;
    }

    public function getYoutubeId($videourl)
    {
        parse_str(parse_url($videourl, PHP_URL_QUERY), $vars);
        if (array_key_exists('v', $vars)) {
            return $vars['v'];
        }
        return null;
    }
}
