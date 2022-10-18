<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Redis;

class RedisMessageRepository
{
    public static function publish(array $packages, $headers): void
    {
        $envelope = ['headers' => $headers];

        foreach ($packages as $package) {
            if (empty($package['url'])) {
                continue;
            }
            $repositoryBaseUrl = parse_url($package['url']);
            Redis::connection('publish')
                ->publish(
                    env('REPO_TOPIC') . strtoupper($repositoryBaseUrl['host']),
                    json_encode(array_merge($envelope, ['payload' => $package]))
                );
        }
    }

    public static function publishError(array $errors, $headers): void
    {
        $envelope = ['headers' => $headers];

        Redis::connection('publish')
            ->publish(
                'APP_ERRORS',
                json_encode(array_merge($envelope, ['payload' => ['errors' => $errors]]))
            );
    }
}
