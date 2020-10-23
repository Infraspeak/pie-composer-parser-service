<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Redis;

class RedisMessageRepository
{
    public static function publish(array $packages): void
    {
        foreach ($packages as $package) {
            $repositoryBaseUrl = parse_url($package['url']);

            Redis::connection('publish')
                ->publish(
                    env('REPO_TOPIC') . strtoupper($repositoryBaseUrl['host']),
                    json_encode($packages)
                );
        }
    }
}
