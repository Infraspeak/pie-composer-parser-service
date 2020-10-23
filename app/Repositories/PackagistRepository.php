<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class PackagistRepository
{
    public static function getUrl($name)
    {
        return Cache::remember($name, Carbon::now()->addHours(4)->diffInSeconds(), function () use ($name) {
            $response = Http::get('https://packagist.org/search.json', [
                'q' => $name,
            ]);

            return $response['total'] !== 0 ? $response['results'][0]['repository'] : null;
        });
    }
}
